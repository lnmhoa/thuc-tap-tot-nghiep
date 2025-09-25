<?php
// Kiểm tra đăng nhập
if (!isset($_SESSION['user']['id']) || $_SESSION['user']['id'] == '') {
    header("Location: index.php?act=login");
    exit();
}

include "./views/page/userRentals.php";
return;
