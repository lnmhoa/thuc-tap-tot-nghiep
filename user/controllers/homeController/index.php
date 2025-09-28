<?php

$sql_pinNews = "SELECT n.id, n.title, n.image, n.content, n.createdAt, n.views, t.name FROM `news` n, `typenews` t WHERE n.pin = 1 GROUP BY n.id";
$sql_listNews = "SELECT n.id, n.title, n.image, n.content, n.createdAt, n.views, t.name FROM `news` n, `typenews` t WHERE n.typeId = t.id AND n.pin = 0 ORDER BY `createdAt` ASC LIMIT 0, 3";
$pinNews = mysqli_query($conn, $sql_pinNews);
$listNews = mysqli_query($conn, $sql_listNews);
$listNewsHome = mysqli_fetch_all($listNews, MYSQLI_ASSOC);
$pinNewsHome = mysqli_fetch_all($pinNews, MYSQLI_ASSOC);

$sql_properties = "
    SELECT rp.*, l.name as locationName, t.name as typeName, a.fullName as brokerName, a.avatar as brokerAvatar, a.phoneNumber as brokerPhone
    FROM rental_property rp 
    LEFT JOIN location l ON rp.locationId = l.id 
    LEFT JOIN type_rental_property t ON rp.typeId = t.id 
    LEFT JOIN broker b ON rp.brokerId = b.id 
    LEFT JOIN account a ON b.accountId = a.id 
    WHERE rp.status = 'active' 
    ORDER BY rp.views DESC, rp.createdAt DESC 
    LIMIT 6
";
$propertiesResult = mysqli_query($conn, $sql_properties);
$featuredProperties = mysqli_fetch_all($propertiesResult, MYSQLI_ASSOC);

$sql_brokers = "
    SELECT b.*, a.fullName, a.avatar, a.phoneNumber, a.email,
           (SELECT COUNT(*) FROM rental_property WHERE brokerId = b.id AND status = 'active') as propertyCount,
           (SELECT COUNT(*) FROM rental_property WHERE brokerId = b.id AND status IN ('rented', 'sold')) as dealCount,
           (SELECT AVG(rating) FROM broker_ratings WHERE brokerId = b.id) as avgRating,
           (SELECT COUNT(*) FROM broker_ratings WHERE brokerId = b.id) as ratingCount
    FROM broker b 
    LEFT JOIN account a ON b.accountId = a.id 
    WHERE a.role = 2 AND a.status = 'active'
    ORDER BY avgRating DESC, dealCount DESC, propertyCount DESC
    LIMIT 6
";
$brokersResult = mysqli_query($conn, $sql_brokers);
$topBrokers = mysqli_fetch_all($brokersResult, MYSQLI_ASSOC);
if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') {
    $userId = $_SESSION['user']['id'];
    
    foreach ($featuredProperties as &$property) {
        $checkSaved = mysqli_query($conn, "SELECT id FROM saved_properties WHERE userId = $userId AND propertyId = {$property['id']}");
 
        $property['isSaved'] = mysqli_num_rows($checkSaved) > 0;
    }
    
    foreach ($topBrokers as &$broker) {
        $checkFollow = mysqli_query($conn, "SELECT id FROM follow_broker WHERE idUser = $userId AND idBroker = {$broker['id']}");
        $broker['isFollowed'] = mysqli_num_rows($checkFollow) > 0;
    }
} else {
    foreach ($featuredProperties as &$property) {
        $property['isSaved'] = false;
    }
    foreach ($topBrokers as &$broker) {
        $broker['isFollowed'] = false;
    }
}



include "./views/page/home.php";
return;
