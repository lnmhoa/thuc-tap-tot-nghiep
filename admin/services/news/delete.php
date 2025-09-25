<?php

require_once '../../connectDB.php';

if (!empty($_POST) && isset($_POST['newsId'])) {
    $newsId = $_POST['newsId'];
    $stmt = $conn->prepare("DELETE FROM `news` WHERE id = ?");
    $stmt->bind_param("i", $newsId);

    if ($stmt->execute()) {
        $response = array(
            'status' => 'success',
            'message' => 'Xóa tin tức thành công!',
            'path' => 'http://localhost/van_van-1p/admin/index.php?act=news',
        );
        echo json_encode($response);
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Xóa tin tức thất bại. Vui lòng thử lại.',
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