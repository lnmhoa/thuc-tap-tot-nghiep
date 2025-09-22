<?php
// Lấy ID broker từ URL parameter
$brokerId = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// Truy vấn thông tin broker từ database
$sql = "SELECT * FROM broker WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $brokerId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $broker = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
} else {
    // Nếu prepare thất bại, thử với query thường
    $sql = "SELECT * FROM broker WHERE id = " . (int)$brokerId;
    $result = mysqli_query($conn, $sql);
    $broker = $result ? mysqli_fetch_assoc($result) : false;
}

// Nếu không tìm thấy broker, chuyển hướng về trang danh sách
if (!$broker) {
    header("Location: index.php?act=listBroker");
    exit();
}

// Lấy thông tin account liên kết
$accountSql = "SELECT * FROM account WHERE id = ?";
$accountStmt = mysqli_prepare($conn, $accountSql);
if ($accountStmt) {
    mysqli_stmt_bind_param($accountStmt, "i", $broker['accountId']);
    mysqli_stmt_execute($accountStmt);
    $accountResult = mysqli_stmt_get_result($accountStmt);
    $account = mysqli_fetch_assoc($accountResult);
    mysqli_stmt_close($accountStmt);
} else {
    // Nếu prepare thất bại, thử với query thường
    $accountSql = "SELECT * FROM account WHERE id = " . (int)$broker['accountId'];
    $accountResult = mysqli_query($conn, $accountSql);
    $account = $accountResult ? mysqli_fetch_assoc($accountResult) : false;
}

// Lấy số lượng bất động sản của broker
$propertySql = "SELECT COUNT(*) as property_count FROM rental_property WHERE brokerId = ?";
$propertyStmt = mysqli_prepare($conn, $propertySql);
if ($propertyStmt) {
    mysqli_stmt_bind_param($propertyStmt, "i", $brokerId);
    mysqli_stmt_execute($propertyStmt);
    $propertyResult = mysqli_stmt_get_result($propertyStmt);
    $propertyCount = mysqli_fetch_assoc($propertyResult)['property_count'];
    mysqli_stmt_close($propertyStmt);
} else {
    // Nếu prepare thất bại, thử với query thường
    $propertySql = "SELECT COUNT(*) as property_count FROM rental_property WHERE brokerId = " . (int)$brokerId;
    $propertyResult = mysqli_query($conn, $propertySql);
    $propertyCount = $propertyResult ? mysqli_fetch_assoc($propertyResult)['property_count'] : 0;
}

// Lấy danh sách bất động sản của broker (giới hạn 4 cái đầu)
$propertiesListSql = "SELECT * FROM rental_property WHERE brokerId = ? LIMIT 4";
$propertiesStmt = mysqli_prepare($conn, $propertiesListSql);
if ($propertiesStmt) {
    mysqli_stmt_bind_param($propertiesStmt, "i", $brokerId);
    mysqli_stmt_execute($propertiesStmt);
    $propertiesResult = mysqli_stmt_get_result($propertiesStmt);
    $properties = [];
    while ($property = mysqli_fetch_assoc($propertiesResult)) {
        $properties[] = $property;
    }
    mysqli_stmt_close($propertiesStmt);
} else {
    // Nếu prepare thất bại, thử với query thường
    $propertiesListSql = "SELECT * FROM rental_property WHERE brokerId = " . (int)$brokerId . " LIMIT 4";
    $propertiesResult = mysqli_query($conn, $propertiesListSql);
    $properties = [];
    if ($propertiesResult) {
        while ($property = mysqli_fetch_assoc($propertiesResult)) {
            $properties[] = $property;
        }
    }
}

include "./views/page/broker.php";
return;
