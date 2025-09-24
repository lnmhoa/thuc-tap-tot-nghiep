<?php
// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == '') {
    header("Location: index.php?act=login");
    exit();
}

// Kiểm tra quyền truy cập - chỉ User(1) và Broker(2) mới được thêm property  
if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] != '1' && $_SESSION['user_role'] != '2')) {
    errorNotLoad('Bạn không có quyền truy cập trang này.');
    header("Location: index.php");
    exit();
}

$userId = $_SESSION['user_id'];

try {
    // Lấy dữ liệu để populate form
    // Lấy danh sách loại BĐS
    $propertyTypes = [];
    $stmt = $conn->prepare("SELECT * FROM type_rental_property ORDER BY name");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $propertyTypes[] = $row;
    }
    $stmt->close();
    
    // Lấy danh sách địa điểm
    $locations = [];
    $stmt = $conn->prepare("SELECT * FROM location ORDER BY name");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $locations[] = $row;
    }
    $stmt->close();
    
    // Xử lý form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errors = [];
        
        // Validate và lấy dữ liệu từ form
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $locationId = intval($_POST['locationId'] ?? 0);
        $typeId = intval($_POST['typeId'] ?? 0);
        $transactionType = $_POST['transactionType'] ?? 'rent';
        $price = floatval($_POST['price'] ?? 0);
        $area = floatval($_POST['area'] ?? 0);
        $bedrooms = intval($_POST['bedrooms'] ?? 0);
        $bathrooms = intval($_POST['bathrooms'] ?? 0);
        $floors = intval($_POST['floors'] ?? 1);
        $frontage = !empty($_POST['frontage']) ? floatval($_POST['frontage']) : null;
        $direction = trim($_POST['direction'] ?? '');
        $legalStatus = trim($_POST['legalStatus'] ?? '');
        $furniture = $_POST['furniture'] ?? 'none';
        $parking = isset($_POST['parking']) ? 1 : 0;
        
        // Validation
        if (empty($title)) $errors[] = 'Tiêu đề không được để trống';
        if (empty($address)) $errors[] = 'Địa chỉ không được để trống';
        if ($typeId <= 0) $errors[] = 'Vui lòng chọn loại bất động sản';
        if ($price <= 0) $errors[] = 'Giá phải lớn hơn 0';
        if ($area <= 0) $errors[] = 'Diện tích phải lớn hơn 0';
        
        // Lấy brokerId nếu user là broker
        $brokerId = null;
        if ($_SESSION['user_role'] == '2') {
            $stmt = $conn->prepare("SELECT id FROM broker WHERE accountId = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $brokerId = $row['id'];
            }
            $stmt->close();
            
            if (!$brokerId) {
                $errors[] = 'Không tìm thấy thông tin broker';
            }
        } else {
            // Nếu user không phải broker, tạo broker record hoặc gán broker mặc định
            $brokerId = 1; // Broker mặc định
        }
        
        if (empty($errors)) {
            try {
                $conn->autocommit(FALSE);
                
                // Insert property
                $insertSql = "
                    INSERT INTO rental_property (
                        title, description, address, locationId, typeId, brokerId, userId,
                        transactionType, price, priceUnit, area, bedrooms, bathrooms, floors,
                        frontage, direction, legalStatus, furniture, parking, status,
                        createdAt, updatedAt
                    ) VALUES (
                        ?, ?, ?, ?, ?, ?, ?,
                        ?, ?, 'month', ?, ?, ?, ?,
                        ?, ?, ?, ?, ?, 'pending',
                        NOW(), NOW()
                    )
                ";
                
                $stmt = $conn->prepare($insertSql);
                $stmt->bind_param(
                    "sssiiiisdiiidssssii",
                    $title, $description, $address, $locationId, $typeId, $brokerId, $userId,
                    $transactionType, $price, $area, $bedrooms, $bathrooms, $floors,
                    $frontage, $direction, $legalStatus, $furniture, $parking
                );
                
                if ($stmt->execute()) {
                    $propertyId = $conn->insert_id;
                    
                    // Xử lý upload hình ảnh
                    $uploadDir = './uploads/rentalProperty/';
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    
                    $imageCount = 0;
                    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
                        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                        $maxFileSize = 5 * 1024 * 1024; // 5MB
                        
                        for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
                            if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                                $fileInfo = getimagesize($_FILES['images']['tmp_name'][$i]);
                                
                                if ($fileInfo && in_array($fileInfo['mime'], $allowedTypes)) {
                                    if ($_FILES['images']['size'][$i] <= $maxFileSize) {
                                        $extension = pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);
                                        $filename = uniqid() . '.' . $extension;
                                        $filepath = $uploadDir . $filename;
                                        
                                        if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $filepath)) {
                                            // Insert image record
                                            $imgStmt = $conn->prepare("
                                                INSERT INTO property_images (propertyId, imagePath, isMain, sortOrder, createdAt) 
                                                VALUES (?, ?, ?, ?, NOW())
                                            ");
                                            $isMain = ($imageCount === 0) ? 1 : 0; // First image is main
                                            $sortOrder = $imageCount + 1;
                                            $imgStmt->bind_param("isii", $propertyId, $filename, $isMain, $sortOrder);
                                            $imgStmt->execute();
                                            $imgStmt->close();
                                            $imageCount++;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    
                    // Update imageCount in rental_property
                    if ($imageCount > 0) {
                        $updateStmt = $conn->prepare("UPDATE rental_property SET imageCount = ? WHERE id = ?");
                        $updateStmt->bind_param("ii", $imageCount, $propertyId);
                        $updateStmt->execute();
                        $updateStmt->close();
                    }
                    
                    $conn->commit();
                    success('Đăng tin bất động sản thành công! Tin đăng đang chờ được duyệt.', '?act=brokerProperty');
                    
                } else {
                    throw new Exception('Lỗi khi thêm bất động sản: ' . $stmt->error);
                }
                
                $stmt->close();
                
            } catch (Exception $e) {
                $conn->rollback();
                error_log("Add property error: " . $e->getMessage());
                $errors[] = 'Có lỗi xảy ra khi đăng tin. Vui lòng thử lại.';
            } finally {
                $conn->autocommit(TRUE);
            }
        }
        
        // Hiển thị lỗi nếu có
        if (!empty($errors)) {
            errorNotLoad(implode('<br>', $errors));
        }
    }

} catch (Exception $e) {
    error_log("Add Property controller error: " . $e->getMessage());
    errorNotLoad('Có lỗi xảy ra khi tải trang. Vui lòng thử lại.');
    
    // Giá trị mặc định
    $propertyTypes = [];
    $locations = [];
}

include "./views/page/addProperty.php";
return;
