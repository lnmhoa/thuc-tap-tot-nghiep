<?php

include "./connectDB.php";

$sql_properties = "SELECT COUNT(*) as total FROM rental_property";
$result_properties = mysqli_query($conn, $sql_properties);
$totalProperties = mysqli_fetch_assoc($result_properties)['total'];

$sql_brokers = "SELECT COUNT(*) as total FROM account WHERE role IN ('2', '5')";
$result_brokers = mysqli_query($conn, $sql_brokers);
$totalBrokers = mysqli_fetch_assoc($result_brokers)['total'];

$sql_users = "SELECT COUNT(*) as total FROM account WHERE role IN ('1', '4')";
$result_users = mysqli_query($conn, $sql_users);
$totalUsers = mysqli_fetch_assoc($result_users)['total'];

$sql_news = "SELECT COUNT(*) as total FROM news";
$result_news = mysqli_query($conn, $sql_news);
$totalNews = mysqli_fetch_assoc($result_news)['total'];

$sql_contacts = "SELECT COUNT(*) as total FROM contact_requests";
$result_contacts = mysqli_query($conn, $sql_contacts);
$totalContacts = mysqli_fetch_assoc($result_contacts)['total'];

$chartData = [];
for ($i = 11; $i >= 0; $i--) {
    $month = date('Y-m', strtotime("-$i month"));
    $monthName = date('M Y', strtotime("-$i month"));

    $sql = "SELECT COUNT(*) as count FROM rental_property WHERE DATE_FORMAT(createdAt, '%Y-%m') = '$month'";
    $result = mysqli_query($conn, $sql);
    $propertiesCount = mysqli_fetch_assoc($result)['count'];
    
    $sql = "SELECT COUNT(*) as count FROM account WHERE role IN ('2', '5') AND DATE_FORMAT(createdAt, '%Y-%m') = '$month'";
    $result = mysqli_query($conn, $sql);
    $brokersCount = mysqli_fetch_assoc($result)['count'];

    $sql = "SELECT COUNT(*) as count FROM account WHERE role IN ('1', '4') AND DATE_FORMAT(createdAt, '%Y-%m') = '$month'";
    $result = mysqli_query($conn, $sql);
    $usersCount = mysqli_fetch_assoc($result)['count'];
    
    $sql = "SELECT COUNT(*) as count FROM news WHERE DATE_FORMAT(createdAt, '%Y-%m') = '$month'";
    $result = mysqli_query($conn, $sql);
    $newsCount = mysqli_fetch_assoc($result)['count'];
    
    $sql = "SELECT COUNT(*) as count FROM contact_requests WHERE DATE_FORMAT(createdAt, '%Y-%m') = '$month'";
    $result = mysqli_query($conn, $sql);
    $contactsCount = mysqli_fetch_assoc($result)['count'];
    
    $chartData[] = [
        'month' => $monthName,
        'properties' => $propertiesCount,
        'brokers' => $brokersCount,
        'users' => $usersCount,
        'news' => $newsCount,
        'contacts' => $contactsCount
    ];
}

include "./views/page/dashboard.php";
return;
