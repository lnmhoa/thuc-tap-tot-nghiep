<?php

require_once '../../connectDB.php';

if (!empty($_POST)) {
    $title = trim($_POST['title'] ?? '');
    $content = $_POST['content'] ?? '';
    $typeId = $_POST['typeId'] ?? '';
 $checkTitle = mysqli_query($conn, "SELECT * FROM `news` WHERE title = '$title'");
    if (mysqli_num_rows($checkTitle) > 0) { 
        $response = array(
            'status' => 'error',
            'message' => 'Tiêu đề tin tức đã tồn tại. Vui lòng sử dụng tiêu đề khác.',
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
                'message' => 'Đã có lỗi xảy ra khi tải tệp ảnh của bạn lên.',
            );
            echo json_encode($response);
            exit();
        }
    }
    $addNews = mysqli_query($conn, "INSERT INTO `news`(title, image, content, createdAt, typeId) VALUES ('$title','$image_file_name','$content', NOW(), $typeId)");
    if ($addNews) {
          $response = array(
                'status' => 'success',
                'message' => 'Thêm thông tin tin tức thành công!',
                'path' => 'http://localhost/thuc-tap-tot-nghiep/admin/index.php?act=news',
            );
            echo json_encode($response);
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Thêm tin tức thất bại. Vui lòng thử lại.',
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