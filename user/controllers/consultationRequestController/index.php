<?php
if (!isset($_SESSION['user']['id']) || $_SESSION['user']['id'] == '') {
    header("Location: index.php?act=login");
    exit();
}

$userId = $_SESSION['user']['id'];

$_SESSION['sort-consultation-request'] = isset($_SESSION['sort-consultation-request']) ? $_SESSION['sort-consultation-request'] : 'desc';
if(isset($_POST['sort'])) {
    $_SESSION['sort-consultation-request'] = $_POST['sort'];
}
$sql ="SELECT cr.*, u.fullName AS userName,  b.id AS brokerId, a.fullName AS brokerName -- Tên Broker
    FROM contact_requests cr LEFT JOIN
    broker b ON cr.brokerId = b.id LEFT JOIN
    account a ON a.id = b.accountId LEFT JOIN
    account u ON cr.userId = u.id WHERE
    cr.userId = '$userId'
    ORDER BY cr.createdAt " . $_SESSION['sort-consultation-request'] . "";

$result = mysqli_query($conn, $sql);
$listConsultationRequest = mysqli_fetch_all($result, MYSQLI_ASSOC);
include "./views/page/consultationRequest.php";
return;
