<?php

$limit = 4;
$_SESSION['sort-account'] = isset($_SESSION['sort-account']) ? $_SESSION['sort-account'] : 'desc';
$_SESSION['search-account'] = isset($_SESSION['search-account']) ? $_SESSION['search-account'] : '';
if (isset($_POST['sort-account'])) {
  $_SESSION['sort-account'] = $_POST['sort-account'];
}
if (isset($_POST['search-account'])) {
  $_SESSION['search-account'] = $_POST['search-account'];
}
if($_SESSION['sort-account'] === 'active' || $_SESSION['sort-account'] === 'inactive'){
    $total = mysqli_query($conn, "SELECT id FROM `account` WHERE (`email` LIKE '%" . $_SESSION['search-account'] . "%' OR `phoneNumber` LIKE '%" . $_SESSION['search-account'] . "%') AND `status` = '" . $_SESSION['sort-account'] . "'");
} else {
    $total = mysqli_query($conn, "SELECT id FROM `account` WHERE `email` LIKE '%" . $_SESSION['search-account'] . "%' OR `phoneNumber` LIKE '%" . $_SESSION['search-account'] . "%'");
}
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$total_page = ceil(mysqli_num_rows($total) / $limit);
if ($current_page > $total_page) {
  $current_page = $total_page;
}
if ($current_page < 1) {
  $current_page = 1;
}
$start = ($current_page - 1) * $limit;
if($_SESSION['sort-account'] === 'active' || $_SESSION['sort-account'] === 'inactive'){
    $sql_list = "SELECT id, fullName, phoneNumber, email, password, createdAt, role, status, avatar FROM `account` WHERE (`email` LIKE '%" . $_SESSION['search-account'] . "%' OR `phoneNumber` LIKE '%" . $_SESSION['search-account'] . "%') AND `status` = '" . $_SESSION['sort-account'] . "' LIMIT $start, $limit";
} else {
    $sql_list = "SELECT id, fullName, phoneNumber, email, password, createdAt, role, status, avatar FROM `account` WHERE `email` LIKE '%" . $_SESSION['search-account'] . "%' OR `phoneNumber` LIKE '%" . $_SESSION['search-account'] . "%' ORDER BY `createdAt` " . $_SESSION['sort-account'] . " LIMIT $start, $limit";
}
$listAccountResult = mysqli_query($conn, $sql_list);
if ($listAccountResult) {
  $listAccount = mysqli_fetch_all($listAccountResult, MYSQLI_ASSOC);
} else {
   error('Lấy thông tin tài khoản thất bại!', 'index.php?act=account&page=' . $current_page);
}
include "./views/page/account.php";
return;
