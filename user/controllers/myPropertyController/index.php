<?php
if (!isset($_SESSION['user']['id']) || $_SESSION['user']['id'] == '') {
    header("Location: index.php?act=login");
    exit();
}

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != '2') {
    errorNotLoad('Bạn không có quyền truy cập trang này.');
    header("Location: index.php");
    exit();
}

$_SESSION['sort-my-property'] = isset($_SESSION['sort-my-property']) ? $_SESSION['sort-my-property'] : 'desc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['sort'])) {
        $_SESSION['sort-my-property'] = $_POST['sort'];
    }
}
$sql = "SELECT rp.*, pi.imagePath as image, t.name as typeName, l.name as locationName,
               COUNT(sp.id) as saveCount
        FROM rental_property rp
        LEFT JOIN property_images pi ON rp.id = pi.propertyId AND pi.isMain = 1
        LEFT JOIN type_rental_property t ON rp.typeId = t.id
        LEFT JOIN location l ON rp.locationId = l.id
        LEFT JOIN saved_properties sp ON rp.id = sp.propertyId
        WHERE rp.brokerId = ".$_SESSION['user']['broker_info']['id']."
        GROUP BY rp.id
        ORDER BY rp.createdAt " . ($_SESSION['sort-my-property']) . ";";
$result = mysqli_query($conn, $sql);
$myProperties = mysqli_fetch_all($result, MYSQLI_ASSOC); 

include "./views/page/myProperty.php";
return;
