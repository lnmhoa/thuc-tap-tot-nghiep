<?php
session_destroy();
include "./views/page/home.php";
success('Đăng xuất thành công!', 'index.php?act=home');
exit();
