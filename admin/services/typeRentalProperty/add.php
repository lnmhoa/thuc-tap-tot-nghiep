<?php

require_once '../../connectDB.php';

if (!empty($_POST)) {
    $name = trim($_POST['name'] ?? '');
    $description = $_POST['description'] ?? '';

    $checkName = mysqli_query($conn, "SELECT * FROM `typerentalproperty` WHERE name = '$name'");
    if (mysqli_num_rows($checkName) > 0) { 
        $response = array(
            'status' => 'error',
            'message' => 'Tên loại đã tồn tại. Vui lòng sử dụng tên khác.',
        );
        echo json_encode($response);
        exit();
    }
    $addType = mysqli_query($conn, "INSERT INTO `typerentalproperty`(name, description) VALUES ('$name','$description')");
    if ($addType) {
          $response = array(
                'status' => 'success',
                'message' => 'Thêm thông tin loại bất động sản thành công!',
                'path' => 'http://localhost/van_van-1p/admin/index.php?act=typeRentalProperty',
            );
            echo json_encode($response);
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Thêm loại bất động sản thất bại. Vui lòng thử lại.',
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