<?php
if (!isset($_SESSION['user']['id']) || $_SESSION['user']['id'] == '') {
    header("Location: index.php?act=login");
    exit();
}

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != '2') {
    errorNotLoad('Bạn không có quyền truy cập trang này.');
    header("Location: index.php");
    exit();
}

$locationsQuery = "SELECT id, name FROM location ORDER BY name ASC";
$locationsResult = mysqli_query($conn, $locationsQuery);
$locations = mysqli_fetch_all($locationsResult, MYSQLI_ASSOC);

$typesQuery = "SELECT id, name FROM type_rental_property ORDER BY name ASC";
$typesResult = mysqli_query($conn, $typesQuery);
$propertyTypes = mysqli_fetch_all($typesResult, MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_property'])) {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $locationId = (int)($_POST['locationId'] ?? 0);
    $typeId = (int)($_POST['typeId'] ?? 0);
    $transactionType = $_POST['transactionType'] ?? '';
    $price = (float)str_replace(',', '', $_POST['price'] ?? 0); // Chuyển đổi giá trị tiền tệ an toàn
    $area = (float)($_POST['area'] ?? 0);
    $bedrooms = (int)($_POST['bedrooms'] ?? 0);
    $bathrooms = (int)($_POST['bathrooms'] ?? 0);
    $floors = (int)($_POST['floors'] ?? 1);
    $frontage = (float)($_POST['frontage'] ?? 0);
    $direction = trim($_POST['direction'] ?? '');
    $furniture = $_POST['furniture'] ?? 'none';
    $parking = isset($_POST['parking']) && $_POST['parking'] == '1' ? 1 : 0;
    $brokerId = (int)($_SESSION['user']['broker_info']['id']);

    if (empty($title)) errorNotLoad("Tiêu đề không được để trống");
    if (empty($description)) errorNotLoad("Mô tả không được để trống");
    if (empty($address)) errorNotLoad("Địa chỉ không được để trống");
    if ($locationId <= 0) errorNotLoad("Vui lòng chọn khu vực");
    if ($typeId <= 0) errorNotLoad("Vui lòng chọn loại BĐS");
    if ($price <= 0) errorNotLoad("Giá không hợp lệ");
    if ($area <= 0) errorNotLoad("Diện tích không hợp lệ");
    if (!isset($_FILES['mainImage']) || $_FILES['mainImage']['error'] !== UPLOAD_ERR_OK) {
        errorNotLoad("Vui lòng tải lên ảnh chính.");
        return;
    }
    mysqli_begin_transaction($conn);

    try {
        $sql_property = "INSERT INTO rental_property (
            title, description, address, locationId, typeId, brokerId, 
            transactionType, price, area, bedrooms, bathrooms, floors, 
            frontage, direction, furniture, parking, status, createdAt
        ) VALUES ('$title', '$description', '$address', $locationId, $typeId, $brokerId, 
            '$transactionType', $price, $area, $bedrooms, $bathrooms, $floors, 
            $frontage, '$direction', '$furniture', $parking, 'active', NOW())";
        $result_property = mysqli_query($conn, $sql_property);
        $propertyId = mysqli_insert_id($conn);

        if ($propertyId <= 0) {
            throw new Exception("Không thể tạo bất động sản trong cơ sở dữ liệu.");
        }
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

        $uploadFileDir = '../uploads/property/';
        $mainImageName = uploadImage($_FILES['mainImage'], $uploadFileDir);
        if ($mainImageName) {
            $sql_main_image = "INSERT INTO property_images (propertyId, imagePath, isMain) VALUES ($propertyId, '$mainImageName', 1)";
           $result_main_img = mysqli_query($conn, $sql_main_image);
        } else {
            errorNotLoad("Ảnh chính không hợp lệ (sai định dạng hoặc kích thước quá 5MB).");
        }
        if (isset($_FILES['subImages']) && !empty($_FILES['subImages']['name'][0])) {
            $subImages = $_FILES['subImages'];
            $num_files = count($subImages['name']);
            
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
                    $sql_sub_image = "INSERT INTO property_images (propertyId, imagePath, isMain) VALUES ($propertyId, '$subImageName', 0)";
                  $result_sub_img = mysqli_query($conn, $sql_sub_image);
                }
            }
        }
        mysqli_commit($conn);
        success("Thêm bất động sản thành công!", "index.php?act=myProperty");

    } catch (Exception $e) {
        mysqli_rollback($conn);
        errorNotLoad("Đã xảy ra lỗi: " . $e->getMessage());
    }
}

include "./views/page/addProperty.php";
return;
