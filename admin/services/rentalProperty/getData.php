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
        $sql = "SELECT rp.*, l.name AS locationName, a.fullName as brokerName, a.phoneNumber as brokerPhone, tp.name AS typeName
                FROM `rental_property` rp 
                LEFT JOIN `location` l ON rp.locationId = l.id 
                LEFT JOIN `broker` b ON rp.brokerId = b.id 
                LEFT JOIN `type_rental_property` tp ON rp.typeId = tp.id 
                LEFT JOIN `account` a ON b.accountId = a.id 
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
                    'locationName' => $propertyData['locationName'] ?? '',
                    'typeId' => $propertyData['typeId'] ?? '',
                    'typeName' => $propertyData['typeName'] ?? '',
                    'brokerId' => $propertyData['brokerId'] ?? '',
                    'brokerName' => $propertyData['brokerName'] ?? '',
                    'brokerPhone' => $propertyData['brokerPhone'] ?? '',
                    'transactionType' => $propertyData['transactionType'] ?? '',
                    'price' => $propertyData['price'] ?? '',
                    'area' => $propertyData['area'] ?? '',
                    'bedrooms' => $propertyData['bedrooms'] ?? '',
                    'bathrooms' => $propertyData['bathrooms'] ?? '',
                    'floors' => $propertyData['floors'] ?? '',
                    'frontage' => $propertyData['frontage'] ?? '',
                    'direction' => $propertyData['direction'] ?? '',
                    'furniture' => $propertyData['furniture'] ?? '',
                    'parking' => $propertyData['parking'] ?? '',
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
