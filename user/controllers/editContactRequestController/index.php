<?php
$contactId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!isset($_SESSION['user']['id']) || $_SESSION['user']['id'] == '') {
    header("Location: index.php?act=login");
    exit();
}
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != '2') {
    header("Location: index.php");
    exit();
}

$locationsQuery = "SELECT id, name FROM location ORDER BY name ASC";
$locationsResult = mysqli_query($conn, $locationsQuery);
$locations = mysqli_fetch_all($locationsResult, MYSQLI_ASSOC);

$sql_details = "SELECT * FROM contact_requests WHERE id = $contactId";
$detailsResult = mysqli_query($conn, $sql_details);
$detailsContactRequest = mysqli_fetch_assoc($detailsResult);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact'])) {
    $note = $_POST['note'] ?? '';
    $status = $_POST['status'] ?? 'inProgress';
   $sql_update = "UPDATE contact_requests SET note = '$note', status = '$status' WHERE id = '$contactId'";
   if(mysqli_query($conn, $sql_update)) {
        include "./views/page/editContactRequest.php";
       success("Cập nhật yêu cầu liên hệ thành công.", "index.php?act=contactRequest");
       exit();
   } else {
       errorNotLoad("Có lỗi xảy ra khi cập nhật yêu cầu liên hệ.");
   }
}
include "./views/page/editContactRequest.php";
return;
