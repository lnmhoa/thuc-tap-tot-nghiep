<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $location = trim($_POST['location']);
    $subject = trim($_POST['subject']);
    $price = trim($_POST['price']) ?: '0';
    $message = trim($_POST['message']);
    
    if (empty($name)) {
        errorNotLoad('Vui lòng nhập họ tên');
    }
    
    if (empty($phone)) {
        errorNotLoad('Vui lòng nhập số điện thoại');
    } elseif (!preg_match('/^[0-9\-\+\(\)\s]{10,15}$/', $phone)) {
        errorNotLoad('Số điện thoại không hợp lệ');
    }
    
    if (empty($location)) {
        errorNotLoad('Vui lòng nhập khu vực');
    }
    
    if (empty($subject)) {
        errorNotLoad('Vui lòng chọn chủ đề');
    }
    
    if (empty($message)) {
        errorNotLoad('Vui lòng nhập nội dung tin nhắn');
    }
            $userId = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;
            $brokerId = 1; // Có thể để mặc định hoặc chọn broker
            
            $sql = "INSERT INTO contact_requests (userId, brokerId, name, phone, location, subject, price, message, status, createdAt) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iissssss", $userId, $brokerId, $name, $phone, $location, $subject, $price, $message);
            
            if ($stmt->execute()) {
                success('Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.','index.php?act=contact');
                exit();
            } else {
               errorNotLoad('Có lỗi xảy ra. Vui lòng thử lại sau.');
            }
       
 
}

$sqlLocations = "SELECT id, name FROM location ORDER BY name ASC";
$resultLocations = mysqli_query($conn, $sqlLocations);
$locations = [];
if ($resultLocations) {
    $locations = mysqli_fetch_all($resultLocations, MYSQLI_ASSOC);
}
include "./views/page/contact.php";
return;