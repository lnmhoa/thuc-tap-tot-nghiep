<?php
if (!isset($_SESSION['user']['id']) || $_SESSION['user']['id'] == '') {
    header("Location: index.php?act=login");
    exit();
}

$userId = $_SESSION['user']['id'];
$_SESSION['sort-property-profile'] = isset($_SESSION['sort-property-profile']) ? $_SESSION['sort-property-profile'] : 'desc';
if(isset($_POST['sort'])) {
    $_SESSION['sort-property-profile'] = $_POST['sort'];
}
$sql = "SELECT rp.*, pi.imagePath as image
        FROM saved_properties sp
        JOIN rental_property rp ON sp.propertyId = rp.id
        JOIN property_images pi ON rp.id = pi.propertyId
        WHERE sp.userId = '$userId' AND pi.isMain = 1
        ORDER BY sp.createdAt " . $_SESSION['sort-property-profile'] . "";
$result = mysqli_query($conn, $sql);
$listSavedProperties = mysqli_fetch_all($result, MYSQLI_ASSOC);
include "./views/page/saveProperty.php";
return;
