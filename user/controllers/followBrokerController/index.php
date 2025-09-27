<?php
if (!isset($_SESSION['user']['id']) || $_SESSION['user']['id'] == '') {
    header("Location: index.php?act=login");
    exit();
}
$userId = $_SESSION['user']['id'];
$_SESSION['sort-follow-broker-profile'] = isset($_SESSION['sort-follow-broker-profile']) ? $_SESSION['sort-follow-broker-profile'] : 'desc';
if(isset($_POST['sort'])) {
    $_SESSION['sort-follow-broker-profile'] = $_POST['sort'];
}
$sql = "SELECT fb.*, b.id as brokerId, b.mainArea as mainArea, b.language as brokerLanguage, b.expertise as brokerExpertise, a.fullName as brokerName, a.email as brokerEmail, a.phoneNumber as brokerPhone, a.avatar as avatar
        FROM follow_broker fb
        JOIN broker b ON fb.idBroker = b.id
	    JOIN account a ON a.id = b.id
        WHERE fb.idUser = '$userId'
        ORDER BY fb.createdAt " . $_SESSION['sort-follow-broker-profile'] . "";
$result = mysqli_query($conn, $sql);
$listFollowedBrokers = mysqli_fetch_all($result, MYSQLI_ASSOC);
include "./views/page/followBroker.php";
return;
