<?php

require_once '../../connectDB.php';

if (!empty($_POST) && isset($_POST['typeId'])) {
    $typeId = $_POST['typeId'];

    $stmt = $conn->prepare("DELETE FROM `typerentalproperty` WHERE id = ?");
    $stmt->bind_param("i", $typeId);

    if ($stmt->execute()) {
        $response = array(
            'status' => 'success',
            'message' => 'Xóa loại bất động sản thành công!',
            'path' => 'http://localhost/thuc-tap-tot-nghiep/admin/index.php?act=typeRentalProperty',
        );
        echo json_encode($response);
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Xóa loại bất động sản thất bại. Vui lòng thử lại.',
        );
        echo json_encode($response);
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Yêu cầu không hợp lệ. Vui lòng thử lại.',
    );
    echo json_encode($response);
}

$conn = null;
?>