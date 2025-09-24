<?php
// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == '') {
    header("Location: index.php?act=login");
    exit();
}

include "./views/page/userRentals.php";
return;
