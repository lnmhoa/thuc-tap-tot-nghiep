<?php
// Kiểm tra đăng nhập
if (!isset($_SESSION['user']['id']) || $_SESSION['user']['id'] == '') {
    header("Location: index.php?act=login");
    exit();
}

$userId = $_SESSION['user']['id'];

try {
    // Xử lý cập nhật thông tin cá nhân
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errors = [];
        
        // Lấy và validate dữ liệu
        $fullName = isset($_POST['fullName']) ? trim($_POST['fullName']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $phoneNumber = isset($_POST['phoneNumber']) ? trim($_POST['phoneNumber']) : '';
        $address = isset($_POST['address']) ? trim($_POST['address']) : '';
        
        // Validate họ tên
        if (empty($fullName)) {
            $errors[] = 'Họ và tên không được để trống.';
        } elseif (strlen($fullName) < 2) {
            $errors[] = 'Họ và tên phải có ít nhất 2 ký tự.';
        } elseif (strlen($fullName) > 100) {
            $errors[] = 'Họ và tên không được vượt quá 100 ký tự.';
        } elseif (!preg_match('/^[a-zA-ZàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđĐ\s]+$/u', $fullName)) {
            $errors[] = 'Họ và tên chỉ được chứa chữ cái và khoảng trắng.';
        }
        
        // Validate email
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email không hợp lệ.';
        }
        
        // Validate số điện thoại
        if (!empty($phoneNumber)) {
            if (!preg_match('/^[0-9]{10,11}$/', $phoneNumber)) {
                $errors[] = 'Số điện thoại không hợp lệ. Vui lòng nhập 10-11 số.';
            }
        }
        
        // Xử lý upload avatar
        $avatarPath = null;
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = './uploads/avatar/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileInfo = getimagesize($_FILES['avatar']['tmp_name']);
            if ($fileInfo === false) {
                $errors[] = 'File tải lên không phải là hình ảnh hợp lệ.';
            } else {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($fileInfo['mime'], $allowedTypes)) {
                    $errors[] = 'Chỉ chấp nhận file JPG, PNG, GIF hoặc WebP.';
                } elseif ($_FILES['avatar']['size'] > 5 * 1024 * 1024) { // 5MB
                    $errors[] = 'File ảnh quá lớn. Vui lòng chọn file nhỏ hơn 5MB.';
                } else {
                    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                    $filename = uniqid() . '.' . $extension;
                    $avatarPath = $uploadDir . $filename;
                    
                    if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $avatarPath)) {
                        $errors[] = 'Có lỗi khi tải lên ảnh đại diện.';
                        $avatarPath = null;
                    }
                }
            }
        }
        
        // Nếu không có lỗi, cập nhật database
        if (empty($errors)) {
            try {
                $conn->autocommit(FALSE);
                
                // Chuẩn bị câu SQL
                $updateFields = [
                    'fullName = ?',
                    'email = ?',
                    'phoneNumber = ?',
                    'address = ?',
                    'updatedAt = NOW()'
                ];
                
                $params = [$fullName, $email, $phoneNumber, $address];
                $types = 'ssss';
                
                if ($avatarPath) {
                    $updateFields[] = 'avatar = ?';
                    $params[] = $avatarPath;
                    $types .= 's';
                }
                
                $sql = "UPDATE account SET " . implode(', ', $updateFields) . " WHERE id = ?";
                $params[] = $userId;
                $types .= 'i';
                
                $stmt = $conn->prepare($sql);
                $stmt->bind_param($types, ...$params);
                
                if ($stmt->execute()) {
                    $conn->commit();
                    success('Cập nhật thông tin cá nhân thành công!', '?act=profile');
                } else {
                    throw new Exception('Lỗi khi cập nhật thông tin: ' . $stmt->error);
                }
                
                $stmt->close();
                
            } catch (Exception $e) {
                $conn->rollback();
                error_log("Profile update error: " . $e->getMessage());
                $errors[] = 'Có lỗi xảy ra khi cập nhật thông tin. Vui lòng thử lại.';
            } finally {
                $conn->autocommit(TRUE);
            }
        }
        
        // Hiển thị lỗi nếu có
        if (!empty($errors)) {
            errorNotLoad($errors[0]);
        }
    }
    
    // Lấy thông tin người dùng
    $stmt = $conn->prepare("SELECT * FROM account WHERE id = ? AND status = 'active'");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $userInfo = $result->fetch_assoc();
    $stmt->close();
    
    if (!$userInfo) {
        errorNotLoad('Không tìm thấy thông tin người dùng.');
        header("Location: index.php?act=logout");
        exit();
    }
    
    // Lấy thống kê người dùng
    $userStats = [
        'totalProperties' => 0,
        'savedProperties' => 0,
        'consultationRequests' => 0,
        'contactRequests' => 0
    ];
    
    // Đếm số BĐS đã đăng (nếu là broker)
    $stmt = $conn->prepare("
        SELECT COUNT(*) as total 
        FROM rental_property rp 
        INNER JOIN broker b ON rp.brokerId = b.id 
        WHERE b.accountId = ? AND rp.status = 'active'
    ");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $userStats['totalProperties'] = intval($row['total']);
    }
    $stmt->close();
    
    // Đếm số BĐS đã lưu
    $stmt = $conn->prepare("
        SELECT COUNT(*) as total 
        FROM saved_properties sp 
        INNER JOIN rental_property rp ON sp.propertyId = rp.id 
        WHERE sp.userId = ? AND rp.status = 'active'
    ");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $userStats['savedProperties'] = intval($row['total']);
    }
    $stmt->close();
    
    // Đếm số yêu cầu tư vấn (contact_requests)
    $stmt = $conn->prepare("
        SELECT COUNT(*) as total 
        FROM contact_requests 
        WHERE userId = ?
    ");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $userStats['consultationRequests'] = intval($row['total']);
    }
    $stmt->close();
    
} catch (Exception $e) {
    error_log("Profile controller error: " . $e->getMessage());
    errorNotLoad('Có lỗi xảy ra khi tải trang. Vui lòng thử lại.');
    
    $userInfo = [
        'id' => $userId,
        'fullName' => '',
        'phoneNumber' => '',
        'email' => '',
        'avatar' => '',
        'address' => '',
        'role' => '3',
        'status' => 'active',
        'createdAt' => date('Y-m-d H:i:s')
    ];
    
    $userStats = [
        'totalProperties' => 0,
        'savedProperties' => 0,
        'consultationRequests' => 0,
        'contactRequests' => 0
    ];
}

include "./views/page/profile.php";
return;
