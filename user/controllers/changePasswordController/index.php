<?php
if (!isset($_SESSION['user']['id']) || $_SESSION['user']['id'] == '') {
    header("Location: index.php?act=login");
    exit();
}

$userId = $_SESSION['user']['id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $currentPassword = isset($_POST['currentPassword']) ? trim($_POST['currentPassword']) : '';
        $newPassword = isset($_POST['newPassword']) ? trim($_POST['newPassword']) : '';
        $confirmPassword = isset($_POST['confirmPassword']) ? trim($_POST['confirmPassword']) : '';
        if (empty($currentPassword)) {
            errorNotLoad('Vui lòng nhập mật khẩu hiện tại.');
        }
        if (empty($newPassword)) {
            errorNotLoad('Vui lòng nhập mật khẩu mới.');
        } elseif (strlen($newPassword) < 8) {
            errorNotLoad('Mật khẩu mới phải có ít nhất 8 ký tự.');
        } elseif (strlen($newPassword) > 255) {
            errorNotLoad('Mật khẩu mới không được vượt quá 255 ký tự.');
        }
        
        if (empty($confirmPassword)) {
            errorNotLoad('Vui lòng xác nhận mật khẩu mới.');
        } elseif ($newPassword !== $confirmPassword) {
            errorNotLoad('Xác nhận mật khẩu không khớp với mật khẩu mới.');
        }
        $sql_updatePassword = "SELECT password FROM account WHERE id = '$userId' AND status = 'active'";
        $resultUpdatePassword = mysqli_query($conn, $sql_updatePassword);
        if (!$resultUpdatePassword) {
            errorNotLoad('Lỗi khi kiểm tra mật khẩu hiện tại.');
        }
        $user = mysqli_fetch_assoc($resultUpdatePassword);
        if (!$user) {
            errorNotLoad('Không tìm thấy thông tin tài khoản.');
        } else {
            if (password_verify($currentPassword, $user['password'])) {
                $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
                $sql = "UPDATE account SET password = '$hashed_password', updatedAt = NOW() WHERE id = '$userId'";
                $result = mysqli_query($conn, $sql);
                if($result){
                    success('Đổi mật khẩu thành công!', '?act=changePassword');
                } else {
                    errorNotLoad('Lỗi khi cập nhật mật khẩu. Vui lòng thử lại.');
                }
            } else {
                errorNotLoad('Mật khẩu hiện tại không đúng.');
            }   
        }
    }



include "./views/page/changePassword.php";
return;
