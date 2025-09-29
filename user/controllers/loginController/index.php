<?php
if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') {
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
      $sql = "SELECT * FROM `account` WHERE phoneNumber = '$phone'";
      $sql_result = mysqli_query($conn, $sql);
      $dataUser = mysqli_fetch_all($sql_result, MYSQLI_ASSOC);
        if (count($dataUser) > 0) {
            $user_from_db = $dataUser[0];
            if ($user_from_db['role'] == 4 || $user_from_db['role'] == 5) {
                errorNotLoad('Tài khoản không có quyền truy cập.');
                return;
            }
            if (password_verify($password, $user_from_db['password'])) {
                $_SESSION['user'] = $user_from_db;
                if ($_SESSION['user']['role'] == '2') {
                    $sql = "SELECT * FROM `broker` WHERE accountId = ".$_SESSION['user']['id'];
                    $broker_result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($broker_result) > 0) {
                        $broker_data = mysqli_fetch_assoc($broker_result);
                        $_SESSION['user']['broker_info'] = $broker_data;
                    }
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
