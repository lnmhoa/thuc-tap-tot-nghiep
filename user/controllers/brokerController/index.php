<?php

$brokerId = isset($_GET['id']) ? $_GET['id'] : 1;

$sql = "SELECT * FROM broker WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $brokerId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $broker = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

if (!$broker) {
    header("Location: index.php?act=listBroker");
    exit();
}

$accountSql = "SELECT * FROM account WHERE id = ?";
$accountStmt = mysqli_prepare($conn, $accountSql);
if ($accountStmt) {
   $accountSql = "SELECT * FROM account WHERE id = " . (int)$broker['accountId'];
    $accountResult = mysqli_query($conn, $accountSql);
    $account = $accountResult ? mysqli_fetch_assoc($accountResult) : false;
}

$propertySql = "SELECT COUNT(*) as property_count FROM rental_property WHERE brokerId = ?";
$propertyStmt = mysqli_prepare($conn, $propertySql);
if ($propertyStmt) {
    $propertySql = "SELECT COUNT(*) as property_count FROM rental_property WHERE brokerId = " . (int)$brokerId;
    $propertyResult = mysqli_query($conn, $propertySql);
    $propertyCount = $propertyResult ? mysqli_fetch_assoc($propertyResult)['property_count'] : 0;
}

$propertiesListSql = "SELECT * FROM rental_property WHERE brokerId = ? LIMIT 4";
$propertiesStmt = mysqli_prepare($conn, $propertiesListSql);
if ($propertiesStmt) {
  $propertiesListSql = "SELECT * FROM rental_property WHERE brokerId = " . (int)$brokerId . " LIMIT 4";
    $propertiesResult = mysqli_query($conn, $propertiesListSql);
    $properties = [];
    if ($propertiesResult) {
        while ($property = mysqli_fetch_assoc($propertiesResult)) {
            $properties[] = $property;
        }
    }
}

$expertisesSql = "SELECT * FROM expertises WHERE status = 1";
$expertisesResult = mysqli_query($conn, $expertisesSql);
$allExpertises = [];
if ($expertisesResult) {
    while ($expertise = mysqli_fetch_assoc($expertisesResult)) {
        $allExpertises[] = $expertise;
    }
}

$brokerExpertises = [];
if (!empty($broker['expertise'])) {
    $brokerExpertiseNames = explode(',', $broker['expertise']);
    foreach ($brokerExpertiseNames as $expertiseName) {
        $expertiseName = trim($expertiseName);
        foreach ($allExpertises as $expertise) {
            if (stripos($expertise['name'], $expertiseName) !== false || stripos($expertiseName, $expertise['name']) !== false) {
                $brokerExpertises[] = $expertise;
                break;
            }
        }
    }
}

if (empty($brokerExpertises)) {
    $brokerExpertises = $allExpertises;
}

include "./views/page/brokerDetail.php";
return;
