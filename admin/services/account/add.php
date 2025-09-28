<?php

require_once '../../connectDB.php';

if (!empty($_POST)) {
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

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
    }
    $newHashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $checkEmail = mysqli_query($conn, "SELECT * FROM `account` WHERE email = '$email'");
    if(!empty($checkEmail) && mysqli_num_rows($checkEmail) > 0) {
        $response = array(
            'status' => 'error',
            'message' => 'Email đã tồn tại. Vui lòng sử dụng email khác.',
        );
        echo json_encode($response);
        exit();
    }
    $checkPhone = mysqli_query($conn, "SELECT * FROM `account` WHERE phoneNumber = '$phone'");
    if(!empty($checkPhone) && mysqli_num_rows($checkPhone) > 0) {
        $response = array(
            'status' => 'error',
            'message' => 'Số điện thoại đã tồn tại. Vui lòng sử dụng số điện thoại khác.',
        );
        echo json_encode($response);
        exit();
    }
    $addAccount = mysqli_query($conn, "INSERT INTO `account`(fullName, phoneNumber, email, password, createdAt, role, status) VALUES ('$name', '$phone', '$email', '$newHashedPassword', NOW(), 1, 'active')");
    if ($addAccount) {
        $response = array(
            'status' => 'success',
            'message' => 'Thêm người dùng thành công!',
            'path'  => 'http://localhost/thuc-tap-tot-nghiep/admin/index.php?act=account',
        );
        echo json_encode($response);
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Thêm thất bại. Vui lòng thử lại.',
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
