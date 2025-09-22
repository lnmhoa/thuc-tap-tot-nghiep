<?php

$limit = 4;
$_SESSION['sort-broker-admin'] = isset($_SESSION['sort-broker-admin']) ? $_SESSION['sort-broker-admin'] : 'desc';
$_SESSION['sort-status-broker'] = isset($_SESSION['sort-status-broker']) ? $_SESSION['sort-status-broker'] : 'all';
$_SESSION['search-broker'] = isset($_SESSION['search-broker']) ? $_SESSION['search-broker'] : '';
if (isset($_POST['sort-broker-admin'])) {
    $_SESSION['sort-broker-admin'] = $_POST['sort-broker-admin'];
}
if (isset($_POST['search-broker'])) {
    $_SESSION['search-broker'] = $_POST['search-broker'];
}
if (isset($_POST['sort-status-broker'])) {
    $_SESSION['sort-status-broker'] = $_POST['sort-status-broker'];
}

if ($_SESSION['sort-status-broker'] === 'all') {
    $sql_total = "SELECT COUNT(*) FROM `account` a JOIN `broker` b ON a.id = b.accountId WHERE a.`role` = 2 AND (a.`email` LIKE '%" . $_SESSION['search-broker'] . "%' OR a.`phoneNumber` LIKE '%" . $_SESSION['search-broker'] . "%')";
} else {
    $sql_total = "SELECT COUNT(*) FROM `account` a JOIN `broker` b ON a.id = b.accountId WHERE a.`role` = 2 AND a.`status` = '" . $_SESSION['sort-status-broker'] . "' AND (a.`email` LIKE '%" . $_SESSION['search-broker'] . "%' OR a.`phoneNumber` LIKE '%" . $_SESSION['search-broker'] . "%')";
}
$total_result = mysqli_query($conn, $sql_total);
$total_rows = mysqli_fetch_row($total_result)[0];

$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$total_page = ceil($total_rows / $limit);
if ($current_page > $total_page) {
    $current_page = $total_page;
}
if ($current_page < 1) {
    $current_page = 1;
}
$start = ($current_page - 1) * $limit;

if ($_SESSION['sort-status-broker'] === 'all') {
    $sql_list = "SELECT a.*, b.* FROM `account` a JOIN `broker` b ON a.id = b.accountId WHERE a.`role` = 2 AND (a.`email` LIKE '%" . $_SESSION['search-broker'] . "%' OR a.`phoneNumber` LIKE '%" . $_SESSION['search-broker'] . "%') ORDER BY a.`createdAt` " . $_SESSION['sort-broker-admin'] . " LIMIT $start, $limit;";
} else {
    $sql_list = "SELECT a.*, b.* FROM `account` a JOIN `broker` b ON a.id = b.accountId WHERE a.`role` = 2 AND a.`status` = '" . $_SESSION['sort-status-broker'] . "' AND (a.`email` LIKE '%" . $_SESSION['search-broker'] . "%' OR a.`phoneNumber` LIKE '%" . $_SESSION['search-broker'] . "%') ORDER BY a.`createdAt` " . $_SESSION['sort-broker-admin'] . " LIMIT $start, $limit;";
}
$sql_expertises = "SELECT name, id FROM `expertises`";
$sql_location = "SELECT name, id FROM `location`";
$listLocationResult = mysqli_query($conn, $sql_location);
$listExpertisesResult = mysqli_query($conn, $sql_expertises);
$listBrokerResult = mysqli_query($conn, $sql_list);
if ($listBrokerResult) {
    $listExpertises = mysqli_fetch_all($listExpertisesResult, MYSQLI_ASSOC);
    $listLocation = mysqli_fetch_all($listLocationResult, MYSQLI_ASSOC);
    $listBroker = mysqli_fetch_all($listBrokerResult, MYSQLI_ASSOC);
} else {
    error('Lấy thông tin tài khoản thất bại!', 'index.php?act=broker');
}
include "./views/page/broker.php";
return;