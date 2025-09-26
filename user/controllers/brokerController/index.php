<?php

$brokerId = isset($_GET['id']) ? (int)$_GET['id'] : 1;

$sql = "SELECT b.*, a.fullName, a.email, a.phoneNumber, a.avatar, a.address 
        FROM broker b 
        LEFT JOIN account a ON b.accountId = a.id 
        WHERE b.id = ?";
$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $brokerId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $broker = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

if (!$broker) {
    header(header: "Location: index.php?act=listBroker");
    exit();
}

$propertyStatsSql = "SELECT 
    COUNT(*) as total_properties,
    COUNT(CASE WHEN status = 'active' THEN 1 END) as active_properties,
    COUNT(CASE WHEN status IN ('rented', 'sold') THEN 1 END) as completed_deals,
    COUNT(CASE WHEN transactionType = 'rent' THEN 1 END) as rental_properties,
    COUNT(CASE WHEN transactionType = 'sale' THEN 1 END) as sale_properties
    FROM rental_property 
    WHERE brokerId = ?";
$stmt = mysqli_prepare($conn, $propertyStatsSql);
mysqli_stmt_bind_param($stmt, "i", $brokerId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$propertyStats = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

$propertiesListSql = "SELECT rp.*, l.name as locationName, t.name as typeName
    FROM rental_property rp 
    LEFT JOIN location l ON rp.locationId = l.id 
    LEFT JOIN type_rental_property t ON rp.typeId = t.id 
    WHERE rp.brokerId = ?
    ORDER BY rp.createdAt DESC 
    LIMIT 12";
$stmt = mysqli_prepare($conn, $propertiesListSql);
mysqli_stmt_bind_param($stmt, "i", $brokerId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$properties = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

$ratingStatsSql = "SELECT 
    COUNT(*) as total_reviews,
    AVG(rating) as avg_rating,
    COUNT(CASE WHEN rating = 5 THEN 1 END) as five_star,
    COUNT(CASE WHEN rating = 4 THEN 1 END) as four_star,
    COUNT(CASE WHEN rating = 3 THEN 1 END) as three_star,
    COUNT(CASE WHEN rating = 2 THEN 1 END) as two_star,
    COUNT(CASE WHEN rating = 1 THEN 1 END) as one_star
    FROM broker_ratings 
    WHERE brokerId = ?";
$stmt = mysqli_prepare($conn, $ratingStatsSql);
mysqli_stmt_bind_param($stmt, "i", $brokerId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$ratingStats = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

$reviewsSql = "SELECT br.*, a.fullName, a.avatar 
    FROM broker_ratings br 
    LEFT JOIN account a ON br.userId = a.id 
    WHERE br.brokerId = ? 
    ORDER BY br.createdAt DESC 
    LIMIT 10";
$stmt = mysqli_prepare($conn, $reviewsSql);
mysqli_stmt_bind_param($stmt, "i", $brokerId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$reviews = [];
while ($review = mysqli_fetch_assoc($result)) {
    $reviews[] = $review;
}
mysqli_stmt_close($stmt);

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
    $brokerExpertises = array_slice($allExpertises, 0, 3);
}

if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') {
    $userId = $_SESSION['user']['id'];

    $checkFollow = mysqli_query($conn, "SELECT id FROM follow_broker WHERE idUser = $userId AND idBroker = $brokerId");
    $broker['isFollowed'] = mysqli_num_rows($checkFollow) > 0;
    
    for ($i = 0; $i < count($properties); $i++) {
        $checkSaved = mysqli_query($conn, "SELECT id FROM saved_properties WHERE userId = $userId AND propertyId = {$properties[$i]['id']}");
        $properties[$i]['isSaved'] = mysqli_num_rows($checkSaved) > 0;
    }
} else {
    $broker['isFollowed'] = false;
    for ($i = 0; $i < count($properties); $i++) {
        $properties[$i]['isSaved'] = false;
    }
}
if(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') {
   $checkRating = mysqli_query($conn, 'SELECT id FROM broker_ratings WHERE brokerId = "'.$brokerId.'" AND userId = "'.$_SESSION['user']['id'].'"');
} 

if(isset($_POST['submit-review']) && isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') {
    $userId = $_SESSION['user']['id'];
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';
    if ($rating >= 1 && $rating <= 5) {
        $insertReviewSql = "INSERT INTO broker_ratings (brokerId, userId, rating, content, createdAt) VALUES ('$brokerId','$userId', '$rating', '$content', NOW())";

        if(mysqli_query($conn, $insertReviewSql)) {
         success("Cảm ơn bạn đã đánh giá môi giới!", "index.php?act=broker&id=$brokerId");
        }
    } else {
        errorNotLoad("Vui lòng chọn đánh giá từ 1 đến 5 sao.");
    }
}

if(isset($_POST['delete-rating']) && isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') {
 $deleteRating = "DELETE FROM broker_ratings WHERE brokerId = '$brokerId' AND userId = '".$_SESSION['user']['id']."'";
    if(mysqli_query($conn, $deleteRating)) {
        success("Đã xóa đánh giá môi giới!", "index.php?act=broker&id=$brokerId");
    }
}

include "./views/page/brokerDetail.php";
return;
