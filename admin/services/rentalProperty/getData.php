<?php
header('Content-Type: application/json');
require_once '../../connectDB.php';

if(!empty($_POST)){
    $propertyId = $_POST['propertyId'] ?? '';

    if(empty($propertyId) || !is_numeric($propertyId)){
        $response = array(
            'status' => 'error',
            'message' => 'Mã bất động sản không hợp lệ. Không thể lấy dữ liệu.',
        );
        echo json_encode($response);
        exit();
    }
    
    try {
        $sql = "SELECT rp.*, l.name AS location_name, tp.name AS type_name, a.fullName AS broker_name , a.phoneNumber as broker_phone
                FROM `rental_property` rp 
                LEFT JOIN `location` l ON rp.locationId = l.id 
                LEFT JOIN `type_rental_property` tp ON rp.typeId = tp.id 
                LEFT JOIN `account` a ON rp.brokerId = a.id 
                WHERE rp.id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        $bind_result = mysqli_stmt_bind_param($stmt, 'i', $propertyId);
        $execute_result = mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if($result && mysqli_num_rows($result) > 0){
            $propertyData = mysqli_fetch_assoc($result);
            $response = array(
                'status' => 'success',
                'data' => array(
                    'title' => $propertyData['title'] ?? '',
                    'description' => $propertyData['description'] ?? '',
                    'address' => $propertyData['address'] ?? '',
                    'locationId' => $propertyData['locationId'] ?? '',
                    'location_name' => $propertyData['location_name'] ?? '',
                    'typeId' => $propertyData['typeId'] ?? '',
                    'type_name' => $propertyData['type_name'] ?? '',
                    'brokerId' => $propertyData['brokerId'] ?? '',
                    'broker_name' => $propertyData['broker_name'] ?? '',
                    'broker_phone' => $propertyData['broker_phone'] ?? '',
                    'userId' => $propertyData['userId'] ?? '',
                    'transactionType' => $propertyData['transactionType'] ?? '',
                    'price' => $propertyData['price'] ?? '',
                    'priceUnit' => $propertyData['priceUnit'] ?? '',
                    'area' => $propertyData['area'] ?? '',
                    'bedrooms' => $propertyData['bedrooms'] ?? '',
                    'bathrooms' => $propertyData['bathrooms'] ?? '',
                    'floors' => $propertyData['floors'] ?? '',
                    'frontage' => $propertyData['frontage'] ?? '',
                    'direction' => $propertyData['direction'] ?? '',
                    'legalStatus' => $propertyData['legalStatus'] ?? '',
                    'furniture' => $propertyData['furniture'] ?? '',
                    'parking' => $propertyData['parking'] ?? '',
                    'featured' => $propertyData['featured'] ?? '',
                    'status' => $propertyData['status'] ?? '',
                    'views' => $propertyData['views'] ?? '',
                    'createdAt' => $propertyData['createdAt'] ?? '',
                    'updatedAt' => $propertyData['updatedAt'] ?? '',
                )
            );
            mysqli_stmt_close($stmt);
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Không tìm thấy bất động sản với ID: ' . $propertyId,
            );
        }
        
    } catch (Exception $e) {
        $response = array(
            'status' => 'error',
            'message' => 'Lỗi server: ' . $e->getMessage(),
        );
    } 
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Không có dữ liệu POST được gửi lên.',
    );
}

echo json_encode($response, JSON_PRETTY_PRINT);
