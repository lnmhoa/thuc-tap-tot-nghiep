<?php
$propertyId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!isset($_SESSION['user']['id']) || $_SESSION['user']['id'] == '') {
    header("Location: index.php?act=login");
    exit();
}
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != '2') {
    header("Location: index.php");
    exit();
}

$locationsQuery = "SELECT id, name FROM location ORDER BY name ASC";
$locationsResult = mysqli_query($conn, $locationsQuery);
$locations = mysqli_fetch_all($locationsResult, MYSQLI_ASSOC);

$typesQuery = "SELECT id, name FROM type_rental_property ORDER BY name ASC";
$typesResult = mysqli_query($conn, $typesQuery);
$propertyTypes = mysqli_fetch_all($typesResult, MYSQLI_ASSOC);

$sql_property = "SELECT rp.*, t.name as propertyType, l.name as locationName, 
                 a.fullName as brokerName, a.avatar as brokerAvatar, a.phoneNumber as brokerPhone,
                 a.email as brokerEmail, b.shortIntro as brokerIntro
                 FROM rental_property rp
                 LEFT JOIN type_rental_property t ON rp.typeId = t.id
                 LEFT JOIN location l ON rp.locationId = l.id
                 LEFT JOIN broker b ON rp.brokerId = b.id
                 LEFT JOIN account a ON b.accountId = a.id
                 WHERE rp.id = $propertyId";
$propertyResult = mysqli_query($conn, $sql_property);
$property = mysqli_fetch_assoc($propertyResult);

$sql_images = "SELECT id, imagePath, isMain FROM property_images WHERE propertyId = $propertyId ORDER BY isMain DESC";
$imagesResult = mysqli_query($conn, $sql_images);
$propertyImages = mysqli_fetch_all($imagesResult, MYSQLI_ASSOC);

$sql_related = "SELECT rp.*, t.name as propertyType, l.name as locationName,
                pi.imagePath as mainImage
                FROM rental_property rp
                LEFT JOIN type_rental_property t ON rp.typeId = t.id
                LEFT JOIN location l ON rp.locationId = l.id
                LEFT JOIN property_images pi ON rp.id = pi.propertyId AND pi.isMain = 1
                WHERE (rp.typeId = {$property['typeId']} OR rp.locationId = {$property['locationId']})
                AND rp.id != $propertyId AND rp.status = 'active'
                ORDER BY rp.createdAt DESC
                LIMIT 6";
$relatedResult = mysqli_query($conn, $sql_related);
$relatedProperties = mysqli_fetch_all($relatedResult, MYSQLI_ASSOC);

function uploadImage($file, $uploadDir) {
    if ($file['error'] !== UPLOAD_ERR_OK) return null;
    
    $fileTmpPath = $file['tmp_name'];
    $fileNameCmps = explode(".", $file['name']);
    $fileExtension = strtolower(end($fileNameCmps));
    
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    if (in_array($fileExtension, $allowedExtensions) && $file['size'] < 5242880) { 
        $newFileName = md5(time() . $file['name'] . rand(1000, 9999)) . '.' . $fileExtension;
        $dest_path = $uploadDir . $newFileName;
        
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            return $newFileName;
        }
    }
    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_property'])) {
    global $conn;
    $uploadFileDir = '../uploads/property/';
    $title = mysqli_real_escape_string($conn, trim($_POST['title'] ?? ''));
    $description = mysqli_real_escape_string($conn, trim($_POST['description'] ?? ''));
    $address = mysqli_real_escape_string($conn, trim($_POST['address'] ?? ''));
    $locationId = (int)($_POST['locationId'] ?? 0);
    $typeId = (int)($_POST['typeId'] ?? 0);
    $transactionType = mysqli_real_escape_string($conn, $_POST['transactionType'] ?? '');
    $price = (float)str_replace(['.', ','], ['', ''], $_POST['price'] ?? 0); 
    $area = (float)($_POST['area'] ?? 0);
    $bedrooms = (int)($_POST['bedrooms'] ?? 0);
    $bathrooms = (int)($_POST['bathrooms'] ?? 0);
    $floors = (int)($_POST['floors'] ?? 1);
    $frontage = (float)($_POST['frontage'] ?? 0);
    $direction = mysqli_real_escape_string($conn, trim($_POST['direction'] ?? ''));
    $furniture = mysqli_real_escape_string($conn, $_POST['furniture'] ?? 'none');
    $parking = isset($_POST['parking']) && $_POST['parking'] == '1' ? 1 : 0;
    $brokerId = (int)($_SESSION['user']['broker_info']['id'] ?? 0);
    $status = mysqli_real_escape_string($conn, $_POST['status'] ?? 'active');
    $errors = [];
    if (empty($title)) $errors[] = "Tiêu đề không được để trống";
    if (empty($description)) $errors[] = "Mô tả không được để trống";
    if (empty($address)) $errors[] = "Địa chỉ không được để trống";
    if ($locationId <= 0) $errors[] = "Vui lòng chọn khu vực";
    if ($typeId <= 0) $errors[] = "Vui lòng chọn loại BĐS";
    if ($price <= 0) $errors[] = "Giá không hợp lệ";
    if ($area <= 0) $errors[] = "Diện tích không hợp lệ";

    if (!empty($errors)) {
        foreach ($errors as $error) {
            errorNotLoad($error);
        }
        include "./views/page/editProperty.php";
        return;
    }
    
    mysqli_begin_transaction($conn);

    try {
        $sql_property = "UPDATE rental_property SET
            title = '$title', description = '$description', address = '$address', locationId = $locationId, typeId = $typeId, brokerId = $brokerId, 
            transactionType = '$transactionType', price = $price, area = $area, bedrooms = $bedrooms, bathrooms = $bathrooms, floors = $floors, 
            frontage = $frontage, direction = '$direction', furniture = '$furniture', parking = $parking, status = '$status', updatedAt = NOW()
        WHERE id = $propertyId";
        
        $result_property = mysqli_query($conn, $sql_property);
        if ($result_property === false) {
             throw new Exception("Lỗi truy vấn cập nhật thông tin BĐS.");
        }
        $is_main_image_uploaded = isset($_FILES['mainImage']) && $_FILES['mainImage']['error'] === UPLOAD_ERR_OK && $_FILES['mainImage']['size'] > 0;
        
        if ($is_main_image_uploaded) {
            $mainImageName = uploadImage($_FILES['mainImage'], $uploadFileDir);
            
            if ($mainImageName) {
                $sql_update_main = "UPDATE property_images SET imagePath = '$mainImageName' WHERE propertyId = $propertyId AND isMain = 1";
                $result_update = mysqli_query($conn, $sql_update_main);
                if (mysqli_affected_rows($conn) == 0) {
                     $sql_insert_main = "INSERT INTO property_images (propertyId, imagePath, isMain) VALUES ($propertyId, '$mainImageName', 1)";
                     mysqli_query($conn, $sql_insert_main);
                }

            } else {
                include "./views/page/editProperty.php";
                errorNotLoad("Ảnh chính không hợp lệ (sai định dạng hoặc kích thước quá 5MB).");
                return;
        } 

        $is_sub_images_uploaded = isset($_FILES['subImages']) && !empty($_FILES['subImages']['name'][0]);

        if ($is_sub_images_uploaded) {
            $subImages = $_FILES['subImages'];
            $num_files = count($subImages['name']);
            mysqli_query($conn,"DELETE FROM property_images WHERE propertyId = $propertyId AND isMain = 0");
            for ($i = 0; $i < $num_files; $i++) {
                $file = [
                    'name' => $subImages['name'][$i],
                    'type' => $subImages['type'][$i],
                    'tmp_name' => $subImages['tmp_name'][$i],
                    'error' => $subImages['error'][$i],
                    'size' => $subImages['size'][$i]
                ];
                
                $subImageName = uploadImage($file, $uploadFileDir);
                
                if ($subImageName) {
                    $sql_sub_image = "INSERT INTO property_images (propertyId, imagePath, isMain) 
                                      VALUES ($propertyId, '$subImageName', 0)";
                    mysqli_query($conn, $sql_sub_image);
                }
            }
        }
        mysqli_commit($conn);
        include "./views/page/editProperty.php";
        success("Cập nhật bất động sản thành công!", "index.php?act=myProperty");
        exit(); 
    }
    } catch (Exception $e) {

        mysqli_rollback($conn);
        errorNotLoad("Đã xảy ra lỗi trong quá trình cập nhật: " . $e->getMessage());
        $propertyResult = mysqli_query($conn, $sql_property);
        $property = mysqli_fetch_assoc($propertyResult);
        $imagesResult = mysqli_query($conn, $sql_images);
        $propertyImages = mysqli_fetch_all($imagesResult, MYSQLI_ASSOC);
        include "./views/page/editProperty.php";
        return;
    }
}
include "./views/page/editProperty.php";
return;
