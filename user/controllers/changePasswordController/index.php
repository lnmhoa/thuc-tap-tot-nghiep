<?php
// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == '') {
    header("Location: index.php?act=login");
    exit();
}

$userId = $_SESSION['user_id'];

try {
    // Xử lý thay đổi mật khẩu
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errors = [];
        
        // Lấy dữ liệu từ form
        $currentPassword = isset($_POST['currentPassword']) ? trim($_POST['currentPassword']) : '';
        $newPassword = isset($_POST['newPassword']) ? trim($_POST['newPassword']) : '';
        $confirmPassword = isset($_POST['confirmPassword']) ? trim($_POST['confirmPassword']) : '';
        
        // Validate mật khẩu hiện tại
        if (empty($currentPassword)) {
            $errors[] = 'Vui lòng nhập mật khẩu hiện tại.';
        }
        
        // Validate mật khẩu mới
        if (empty($newPassword)) {
            $errors[] = 'Vui lòng nhập mật khẩu mới.';
        } elseif (strlen($newPassword) < 6) {
            $errors[] = 'Mật khẩu mới phải có ít nhất 6 ký tự.';
        } elseif (strlen($newPassword) > 50) {
            $errors[] = 'Mật khẩu mới không được vượt quá 50 ký tự.';
        }
        
        // Validate xác nhận mật khẩu
        if (empty($confirmPassword)) {
            $errors[] = 'Vui lòng xác nhận mật khẩu mới.';
        } elseif ($newPassword !== $confirmPassword) {
            $errors[] = 'Xác nhận mật khẩu không khớp với mật khẩu mới.';
        }
        
        // Kiểm tra mật khẩu hiện tại có đúng không
        if (empty($errors)) {
            $stmt = $conn->prepare("SELECT password FROM account WHERE id = ? AND status = 'active'");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();
            
            if (!$user) {
                $errors[] = 'Không tìm thấy thông tin tài khoản.';
            } else {
                // Kiểm tra mật khẩu hiện tại (có thể là MD5 hoặc plaintext tùy vào cách lưu trữ hiện tại)
                $isCurrentPasswordCorrect = false;
                
                // Thử với MD5 trước (vì thấy trong database có MD5)
                if (md5($currentPassword) === $user['password']) {
                    $isCurrentPasswordCorrect = true;
                } 
                // Thử với plaintext
                elseif ($currentPassword === $user['password']) {
                    $isCurrentPasswordCorrect = true;
                }
                // Thử với password_verify nếu đã hash bằng password_hash
                elseif (password_verify($currentPassword, $user['password'])) {
                    $isCurrentPasswordCorrect = true;
                }
                
                if (!$isCurrentPasswordCorrect) {
                    $errors[] = 'Mật khẩu hiện tại không đúng.';
                }
            }
        }
        
        // Cập nhật mật khẩu nếu không có lỗi
        if (empty($errors)) {
            try {
                // Sử dụng MD5 để tương thích với hệ thống hiện tại
                $hashedNewPassword = md5($newPassword);
                
                $stmt = $conn->prepare("UPDATE account SET password = ?, updatedAt = NOW() WHERE id = ?");
                $stmt->bind_param("si", $hashedNewPassword, $userId);
                
                if ($stmt->execute()) {
                    success('Đổi mật khẩu thành công!', '?act=changePassword');
                } else {
                    throw new Exception('Lỗi khi cập nhật mật khẩu: ' . $stmt->error);
                }
                
                $stmt->close();
                
            } catch (Exception $e) {
                error_log("Change password error: " . $e->getMessage());
                $errors[] = 'Có lỗi xảy ra khi đổi mật khẩu. Vui lòng thử lại.';
            }
        }
        
        // Hiển thị lỗi nếu có
        if (!empty($errors)) {
            errorNotLoad($errors[0]);
        }
    }
    
    // Lấy thông tin cơ bản của user để hiển thị
    $stmt = $conn->prepare("SELECT fullName, email FROM account WHERE id = ? AND status = 'active'");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $userInfo = $result->fetch_assoc();
    $stmt->close();
    
    if (!$userInfo) {
        errorNotLoad('Không tìm thấy thông tin tài khoản.');
        header("Location: index.php?act=logout");
        exit();
    }

} catch (Exception $e) {
    error_log("Change Password controller error: " . $e->getMessage());
    errorNotLoad('Có lỗi xảy ra khi tải trang. Vui lòng thử lại.');
    
    // Giá trị mặc định khi có lỗi
    $userInfo = [
        'fullName' => '',
        'email' => ''
    ];
}

include "./views/page/changePassword.php";
return;
