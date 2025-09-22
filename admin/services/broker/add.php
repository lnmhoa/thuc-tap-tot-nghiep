<?php

require_once '../../connectDB.php';

if (!empty($_POST)) {
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $facebook = $_POST['facebook'] ?? '';
    $youtube = $_POST['youtube'] ?? '';
    $website = $_POST['website'] ?? '';
    $intro = $_POST['intro'] ?? '';
    $area = $_POST['area'] ?? '';
    $hour = $_POST['hour'] ?? '';
    $language = $_POST['language'] ?? '';
    $expertise = $_POST['expertise'] ?? '';

    if (!preg_match('/^[0-9]{10,11}$/', $phone)) {
        $response = array(
            'status' => 'error',
            'message' => 'Số điện thoại không hợp lệ.',
        );
        echo json_encode($response);
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = array(
            'status' => 'error',
            'message' => 'Email không hợp lệ.',
        );
        echo json_encode($response);
        exit();
    }
    if (strlen($password) < 6) {
        $response = array(
            'status' => 'error',
            'message' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        );
        echo json_encode($response);
        exit();
    }   $checkEmail = mysqli_query($conn, "SELECT * FROM `account` WHERE email = '$email'");
    if (mysqli_num_rows($checkEmail) > 0) { 
        $response = array(
            'status' => 'error',
            'message' => 'Email đã tồn tại. Vui lòng sử dụng email khác.',
        );
        echo json_encode($response);
        exit();
    }
    $checkPhone = mysqli_query($conn, "SELECT * FROM `account` WHERE phoneNumber = '$phone'");
    if (mysqli_num_rows($checkPhone) > 0) {
        $response = array(
            'status' => 'error',
            'message' => 'Số điện thoại đã tồn tại. Vui lòng sử dụng số điện thoại khác.',
        );
        echo json_encode($response);
        exit();
    }
    $avatar_file_name = null;

    if (isset($_FILES["avatar"]) && $_FILES["avatar"]["error"] == 0) {
        $target_dir = "../../uploads/broker/";
        $file_extension = strtolower(pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION));
        $new_file_name = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $new_file_name;

        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
            $avatar_file_name = $new_file_name;
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Đã có lỗi xảy ra khi tải tệp ảnh của bạn lên.',
            );
            echo json_encode($response);
            exit();
        }
    }
 
   $newHashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $addAccount = mysqli_query($conn, "INSERT INTO `account`(fullName, phoneNumber, email, password, createdAt, role, status, avatar) VALUES ('$name', '$phone', '$email', '$newHashedPassword', NOW(), 2, 1, '$avatar_file_name')");
    if ($addAccount) {
        $account_id = mysqli_insert_id($conn);
        $addBroker = mysqli_query($conn, "INSERT INTO `broker`(accountId, linkFacebook, linkYoutube, linkWebsite, shortIntro, mainArea, workingHours, language, expertise) VALUES ('$account_id', '$facebook', '$youtube', '$website', '$intro', '$area', '$hour', '$language', '$expertise')");
        if ($addBroker) {
            $response = array(
                'status' => 'success',
                'message' => 'Thêm thông tin môi giới thành công!',
                'path' => 'http://localhost/luan_van_tot_nghiep/admin/index.php?act=broker',
            );
            echo json_encode($response);
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Thêm thông tin môi giới thất bại. Vui lòng thử lại.',
            );
            echo json_encode($response);
        }
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Thêm tài khoản thất bại. Vui lòng thử lại.',
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