<?php

require_once '../../connectDB.php';

if (!empty($_POST) && isset($_POST['typeId'])) {
    $typeId = $_POST['typeId'];
    $checkNews = mysqli_query($conn, "SELECT * FROM `news` WHERE typeId = '$typeId'");
    if (mysqli_num_rows($checkNews) > 0) {
        $response = array(
            'status' => 'error',
            'message' => 'Thể loại còn chứa tin tức. Vui lòng xóa tin tức trước khi xóa thể loại này.',
        );
        echo json_encode($response);
        exit();
    }
    $stmt = $conn->prepare("DELETE FROM `typenews` WHERE id = ?");
    $stmt->bind_param("i", $typeId);

    if ($stmt->execute()) {
        $response = array(
            'status' => 'success',
            'message' => 'Xóa loại tin tức thành công!',
            'path' => 'http://localhost/luan_van_tot_nghiep/admin/index.php?act=typeNews',
        );
        echo json_encode($response);
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Xóa loại tin tức thất bại. Vui lòng thử lại.',
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
