<?php

$limit = 10;
$_SESSION['sort-contact'] = isset($_SESSION['sort-contact']) ? $_SESSION['sort-contact'] : 'desc';
$_SESSION['search-contact'] = isset($_SESSION['search-contact']) ? $_SESSION['search-contact'] : '';
$_SESSION['status-contact'] = isset($_SESSION['status-contact']) ? $_SESSION['status-contact'] : 'all';
if (isset($_POST['sort-contact'])) {
  $_SESSION['sort-contact'] = $_POST['sort-contact'];
}
if (isset($_POST['search-contact'])) {
  $_SESSION['search-contact'] = $_POST['search-contact'];
}
if (isset($_POST['status-contact'])) {
  $_SESSION['status-contact'] = $_POST['status-contact'];
}
if($_SESSION['status-contact'] === 'all'){
    $total = mysqli_query($conn, "SELECT id FROM `contact_requests` WHERE `phone` LIKE '%" . $_SESSION['search-contact'] . "%'");
} else if($_SESSION['status-contact'] !== "all"){
    $total = mysqli_query($conn, "SELECT id FROM `contact_requests` WHERE `phone` LIKE '%" . $_SESSION['search-contact'] . "%' AND `status` = '" . $_SESSION['status-contact'] . "'");
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
if($_SESSION['status-contact'] === 'all'){
    $sql_list = "SELECT cr.*, l.name AS location_name FROM `contact_requests` cr LEFT JOIN `location` l ON `cr`.`location` = `l`.`id` WHERE `cr`.`phone` LIKE '%" . $_SESSION['search-contact'] . "%' ORDER BY `cr`.`createdAt` " . $_SESSION['sort-contact'] . " LIMIT $start, $limit";
} else if($_SESSION['status-contact'] !== "all"){
    $sql_list = "SELECT cr.*, l.name AS location_name FROM `contact_requests` cr LEFT JOIN `location` l ON `cr`.`location` = `l`.`id` WHERE `cr`.`phone` LIKE '%" . $_SESSION['search-contact'] . "%' AND `cr`.`status` = '" . $_SESSION['status-contact'] . "' ORDER BY `cr`.`createdAt` " . $_SESSION['sort-contact'] . " LIMIT $start, $limit";
}
$listContactResult = mysqli_query($conn, $sql_list);
if ($listContactResult) {
  $listContact = mysqli_fetch_all($listContactResult, MYSQLI_ASSOC);
} else {
   error('Lấy thông tin yêu cầu thất bại!', 'index.php?act=contact&page=' . $current_page);
}
$sql_location="SELECT * FROM location";
$result_location = mysqli_query($conn, $sql_location);
$listLocation=mysqli_fetch_all($result_location, MYSQLI_ASSOC);
$sql_broker="SELECT account.*, broker.id as brokerId FROM account LEFT JOIN broker ON account.id = broker.accountId WHERE ROLE = 2";
$result_broker = mysqli_query($conn, $sql_broker);
$listBroker=mysqli_fetch_all($result_broker, MYSQLI_ASSOC);
if(isset($_POST['addContact'])){
    $name = $_POST['add-name'];
    $phone = $_POST['add-phone'];
    $location = $_POST['add-location'];
    $subject = $_POST['add-subject'];
    $message = $_POST['add-message'];
    $brokerId = $_POST['add-broker'];
    $sql_add = "INSERT INTO `contact_requests`( `brokerId`, `name`, `phone`, `location`, `subject`, `message`, `status`, `createdAt`) VALUES ('$brokerId', '$name', '$phone', '$location', '$subject', '$message', 'inProgress', NOW())";
    $result_add = mysqli_query($conn, $sql_add);
    if ($result_add) {
        success('Tạo yêu cầu thành công!', 'index.php?act=contact&page=' . $current_page);
    } else {
        error('Tạo yêu cầu thất bại!', 'index.php?act=contact&page=' . $current_page);
    }
}
if(isset($_POST['editContact'])){
    $id = $_POST['edit-id'];
    $name = $_POST['edit-name'];
    $phone = $_POST['edit-phone'];
    $status = $_POST['edit-status'];
    $location = $_POST['edit-location'];
    $brokerId = $_POST['edit-broker'];
    $message = $_POST['edit-message'];
    $note = $_POST['edit-note'];
    $sql_update = "UPDATE `contact_requests` SET `brokerId`= '$brokerId', `name`= '$name', `location`= '$location', `phone`= '$phone',  `note`= '$note', `message`= '$message', `status`= '$status' WHERE `id`= '$id'";
    $editContact=mysqli_query($conn, $sql_update);
    if ($editContact) {
        success('Cập nhật yêu cầu thành công!', 'index.php?act=contact&page=' . $current_page);
    } else {
        error('Cập nhật yêu cầu thất bại!', 'index.php?act=contact&page=' . $current_page);
    }
}

include "./views/page/contact.php";
return;