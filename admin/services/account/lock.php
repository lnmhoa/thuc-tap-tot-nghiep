<?php

require_once '../../connectDB.php';

if (!empty($_POST)) {
    $userId = $_POST['userId'] ?? '';
    if (empty($userId) || !is_numeric($userId)) {
        $response = array(
            'status' => 'error',
            'message' => 'Mã người dùng không hợp lệ. Không thể cập nhật.',
        );
        echo json_encode($response);
        exit();
    }
    $checkStatus = "SELECT status FROM account WHERE id = $userId";
    $result = mysqli_query($conn, $checkStatus);
    $statusUser=mysqli_fetch_all($result, MYSQLI_ASSOC);
    if($statusUser[0]['status']==='active'){
        $newStatus = 'inactive';
    } else {
       $newStatus = 'active';
    }
    $sql = "UPDATE account SET status = '$newStatus' WHERE id = '$userId'";
    $result = mysqli_query($conn, $sql);
    if($result){
        $response = array(
            'status' => 'success',
            'message' => 'Cập nhật trạng thái người dùng thành công.',
            'path'  => 'http://localhost/thuc-tap-tot-nghiep/admin/index.php?act=account',
        );
        echo json_encode($response);
        exit();
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Cập nhật trạng thái người dùng thất bại. Vui lòng thử lại.',
        );
        echo json_encode($response);
        exit();
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Không có dữ liệu. Vui lòng thử lại.'
    );
    echo json_encode($response);
}

$conn = null;
