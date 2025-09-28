<?php

require_once '../../connectDB.php';

if (!empty($_POST)) {
    $newsId = $_POST['newsId'] ?? '';
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $typeId = $_POST['typeId'] ?? '';
    if (empty($newsId) || !is_numeric($newsId)) {
        $response = array(
            'status' => 'error',
            'message' => 'Mã tin tức không hợp lệ. Không thể cập nhật.',
        );
        echo json_encode($response);
        exit();
    }

    $checkTitle = mysqli_query($conn, "SELECT id FROM `news` WHERE title = '$title' AND id != '$newsId'");
    if (mysqli_num_rows($checkTitle) > 0) {
        $response = array(
            'status' => 'error',
            'message' => 'Tiêu đề đã tồn tại. Vui lòng sử dụng tên khác.',
        );
        echo json_encode($response);
        exit();
    }

    $image_file_name = null;
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $target_dir = "../../../uploads/news/";
        $file_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $new_file_name = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $new_file_name;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_file_name = $new_file_name;
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Đã có lỗi xảy ra khi tải tệp ảnh bìa.',
            );
            echo json_encode($response);
            exit();
        }
    }
    $newsUpdateSql = "UPDATE `news` SET
        title = '$title',
        content = '$content',
        typeId = '$typeId'";
    if ($image_file_name !== null) {
        $newsUpdateSql .= ", image = '$image_file_name'";
    }

    $newsUpdateSql .= " WHERE id = '$newsId'";

    $updateAccount = mysqli_query($conn, $newsUpdateSql);
    if ($newsUpdateSql) {
        $response = array(
            'status' => 'success',
            'message' => 'Cập nhật thông tin tin tức thành công!',
            'path' => 'http://localhost/thuc-tap-tot-nghiep/admin/index.php?act=news',
        );
        echo json_encode($response);
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Cập nhật thông tin tin tức thất bại. Vui lòng thử lại.',
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
