<?php

require_once '../../connectDB.php';

if (!empty($_POST)) {
    $typeId = $_POST['typeId'] ?? '';
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';

    if (empty($typeId) || !is_numeric($typeId)) {
        $response = array(
            'status' => 'error',
            'message' => 'Mã loại không hợp lệ. Không thể cập nhật.',
        );
        echo json_encode($response);
        exit();
    }

    $checkName = mysqli_query($conn, "SELECT id FROM `typenews` WHERE name = '$name' AND id != '$typeId'");
    if (mysqli_num_rows($checkName) > 0) {
        $response = array(
            'status' => 'error',
            'message' => 'Tên loại đã tồn tại. Vui lòng sử dụng tên khác.',
        );
        echo json_encode($response);
        exit();
    }

    $updateTypeNews = mysqli_query($conn, "UPDATE `typenews` SET name = '$name', description = '$description' WHERE id = '$typeId'");
    if ($updateTypeNews) {
        $response = array(
            'status' => 'success',
            'message' => 'Cập nhật thông tin loại tin tức thành công!',
            'path' => 'http://localhost/thuc-tap-tot-nghiep/admin/index.php?act=typeNews',
        );
        echo json_encode($response);
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Cập nhật thông tin loại tin tức thất bại. Vui lòng thử lại.',
            'debug' => mysqli_error($conn)
        );
        echo json_encode($response);
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Không có dữ liệu. Vui lòng thử lại.'
    );
    echo json_encode($response);
}

$conn = null;
?>