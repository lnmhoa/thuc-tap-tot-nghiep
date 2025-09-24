<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $location = trim($_POST['location']);
    $subject = trim($_POST['subject']);
    $price = trim($_POST['price']) ?: '0';
    $message = trim($_POST['message']);
    
    if (empty($name)) {
        $errors[] = 'Vui lòng nhập họ tên';
    }
    
    if (empty($phone)) {
        $errors[] = 'Vui lòng nhập số điện thoại';
    } elseif (!preg_match('/^[0-9\-\+\(\)\s]{10,15}$/', $phone)) {
        $errors[] = 'Số điện thoại không hợp lệ';
    }
    
    if (empty($location)) {
        $errors[] = 'Vui lòng nhập khu vực';
    }
    
    if (empty($subject)) {
        $errors[] = 'Vui lòng chọn chủ đề';
    }
    
    if (empty($message)) {
        $errors[] = 'Vui lòng nhập nội dung tin nhắn';
    }
            // Lấy userId nếu user đã đăng nhập
            $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
            $brokerId = 1; // Có thể để mặc định hoặc chọn broker
            
            $sql = "INSERT INTO contact_requests (userId, brokerId, name, phone, location, subject, price, message, status, createdAt) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iissssss", $userId, $brokerId, $name, $phone, $location, $subject, $price, $message);
            
            if ($stmt->execute()) {
                $_SESSION['success'] = 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.';
                header('Location: /luan_van-1/user/index.php?page=contact');
                exit();
            } else {
                $errors[] = 'Có lỗi xảy ra, vui lòng thử lại';
            }
       
 
}
include ".//views/page/contact.php";
return;