<?php
// Kiểm tra đăng nhập
if (!isset($_SESSION['user']['id']) || $_SESSION['user']['id'] == '') {
    header("Location: index.php?act=login");
    exit();
}

// Kiểm tra quyền truy cập - chỉ User(1) và Broker(2) mới được thêm property  
if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] != '1' && $_SESSION['user_role'] != '2')) {
    errorNotLoad('Bạn không có quyền truy cập trang này.');
    header("Location: index.php");
    exit();
}

$userId = $_SESSION['user']['id'];

include "./views/page/addProperty.php";
return;
