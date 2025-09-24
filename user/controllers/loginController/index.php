<?php
if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != '') {
    header("Location: index.php?act=home");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!preg_match('/^[0-9]{10,11}$/', $phone)) {
        errorNotLoad('Số điện thoại không hợp lệ.');
    } elseif (strlen($password) < 6) {
        errorNotLoad('Mật khẩu phải có ít nhất 6 ký tự.');
    } else {
        $stmt = $conn->prepare("SELECT * FROM `account` WHERE phoneNumber = ?");
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user_from_db = $result->fetch_assoc();
            if ($user_from_db['role'] == 4 || $user_from_db['role'] == 5) {
                errorNotLoad('Tài khoản không có quyền truy cập.');
                return;
            }
            if (password_verify($password, $user_from_db['password'])) {
                // Lưu thông tin user vào session theo cấu trúc mà các controller khác mong đợi
                $_SESSION['user'] = $user_from_db;
                $_SESSION['user_id'] = $user_from_db['id'];
                $_SESSION['user_name'] = $user_from_db['fullName'];
                $_SESSION['user_email'] = $user_from_db['email'];
                $_SESSION['user_avatar'] = $user_from_db['avatar'];
                $_SESSION['user_role'] = $user_from_db['role'];
                
                // Nếu là broker thì lấy thêm thông tin broker
                if ($user_from_db['role'] == '2') {
                    $broker_stmt = $conn->prepare("SELECT * FROM `broker` WHERE accountId = ?");
                    $broker_stmt->bind_param("i", $user_from_db['id']);
                    $broker_stmt->execute();
                    $broker_result = $broker_stmt->get_result();
                    
                    if ($broker_result->num_rows > 0) {
                        $broker_data = $broker_result->fetch_assoc();
                        $_SESSION['user']['broker_info'] = $broker_data;
                        $_SESSION['broker_id'] = $broker_data['id'];
                    }
                    $broker_stmt->close();
                }
                
                success('Đăng nhập thành công!', 'index.php?act=home');
            } else {
                errorNotLoad('Số điện thoại hoặc mật khẩu không đúng.');
            }
        } else {
            errorNotLoad('Số điện thoại hoặc mật khẩu không đúng.');
        }
    }
}
include "./views/page/login.php";
return;
