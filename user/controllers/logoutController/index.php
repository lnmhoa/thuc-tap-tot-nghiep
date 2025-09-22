<?php
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}
session_destroy();
if (isset($_COOKIE['remember_me_token'])) {
    setcookie("remember_me_token", "", time() - 3600, "/");
    setcookie("user_phone", "", time() - 3600, "/");
}
include "./views/page/home.php";
success('Đăng xuất thành công!', 'index.php?act=home');
exit();
