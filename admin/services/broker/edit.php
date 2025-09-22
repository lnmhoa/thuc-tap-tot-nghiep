<?php

require_once '../../connectDB.php';

if (!empty($_POST)) {
    $brokerId = $_POST['brokerId'] ?? '';
    $accountId = $_POST['accountId'] ?? '';
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
    $status = $_POST['status'] ?? '';

    if (empty($brokerId) || !is_numeric($brokerId)) {
        $response = array(
            'status' => 'error',
            'message' => 'ID tài khoản không hợp lệ. Không thể cập nhật.',
        );
        echo json_encode($response);
        exit();
    }

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

    if (!empty($password) && strlen($password) < 6) {
        $response = array(
            'status' => 'error',
            'message' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        );
        echo json_encode($response);
        exit();
    }

    $checkEmail = mysqli_query($conn, "SELECT id FROM `account` WHERE email = '$email' AND id != '$accountId'");
    if (mysqli_num_rows($checkEmail) > 0) {
        $response = array(
            'status' => 'error',
            'message' => mysqli_num_rows($checkEmail) > 0,
        );
        echo json_encode($response);
        exit();
    }

    $checkPhone = mysqli_query($conn, "SELECT id FROM `account` WHERE phoneNumber = '$phone' AND id != '$accountId'");
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
                'message' => 'Đã có lỗi xảy ra khi tải tệp ảnh đại diện.',
            );
            echo json_encode($response);
            exit();
        }
    }

    $accountUpdateSql = "UPDATE `account` SET
        fullName = '$name',
        phoneNumber = '$phone',
        status = '$status',
        email = '$email'";
        
    if (!empty($password)) {
        $newHashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $accountUpdateSql .= ", password = '$newHashedPassword'";
    }


    if ($avatar_file_name !== null) {
        $accountUpdateSql .= ", avatar = '$avatar_file_name'";
    }

    $accountUpdateSql .= " WHERE id = '$accountId'";

    $updateAccount = mysqli_query($conn, $accountUpdateSql);

    if ($updateAccount) {
  
        $updateBroker = mysqli_query($conn, "UPDATE `broker` SET
            linkFacebook = '$facebook',
            linkYoutube = '$youtube',
            linkWebsite = '$website',
            shortIntro = '$intro',
            mainArea = '$area',
            workingHours = '$hour',
            language = '$language',
            expertise = '$expertise'
            WHERE accountId = '$accountId'");
        if ($updateBroker) {
            $response = array(
                'status' => 'success',
                'message' => 'Cập nhật thông tin môi giới thành công!',
                'path' => 'http://localhost/luan_van_tot_nghiep/admin/index.php?act=broker',
            );
            echo json_encode($response);
        } else {
 
            $response = array(
                'status' => 'error',
                'message' => 'Cập nhật thông tin môi giới thất bại. Vui lòng thử lại.',
                'debug' => mysqli_error($conn)
            );
            echo json_encode($response);
        }
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Cập nhật tài khoản thất bại. Vui lòng thử lại.',
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