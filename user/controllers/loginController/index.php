<?php
if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != '') {
    header("Location: index.php?act=home");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember_me = isset($_POST['remember_me']);
    
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
            if (password_verify($password, $user_from_db['password'])) {
                $_SESSION['user_phone'] = $user_from_db['phoneNumber'];
                $_SESSION['user_id'] = $user_from_db['id'];
                if ($remember_me) {
                    $remember_token = bin2hex(random_bytes(32)); 
                    setcookie("remember_me_token", $remember_token, time() + (30 * 24 * 60 * 60), "/"); 
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