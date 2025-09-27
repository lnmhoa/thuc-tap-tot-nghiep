<?php
if (!isset($_SESSION['user']['id']) || $_SESSION['user']['id'] == '') {
    header("Location: index.php?act=login");
    exit();
}

$userId = $_SESSION['user']['id'];

if(isset($_SESSION['user']['id']) && $_SESSION['user']['role'] == 2) {
   $sql_location = 'SELECT * FROM location';
   $listLocationResult = mysqli_query($conn, $sql_location);
   $listLocation = mysqli_fetch_all($listLocationResult, MYSQLI_ASSOC);
}

if(isset($_POST['update_profile'])) {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $address = $_POST['address'];
    $checkPhoneNumber=mysqli_query($conn, "SELECT * FROM `account` WHERE `phoneNumber`='$phoneNumber' AND `id` != $userId");
        if (mysqli_num_rows($checkPhoneNumber) > 0) {
            error('Số điện thoại đã tồn tại. Vui lòng sử dụng số điện thoại khác.', 'index.php?act=profile');
            exit();
        }
    $checkEmail = mysqli_query($conn, "SELECT * FROM `account` WHERE `email`='$email' AND `id` != $userId");
        if (mysqli_num_rows($checkEmail) > 0) {
            error('Email đã tồn tại. Vui lòng sử dụng email khác.', 'index.php?act=profile');
            exit();
        }
    if (isset($_FILES['avatar'] ) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['avatar']['tmp_name'];
        $fileName = $_FILES['avatar']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $allowedfileExtensions = array('jpg', 'png');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = './uploads/avatar/';
            $dest_path = $uploadFileDir . $newFileName;

            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                $sql_update = "UPDATE `account` SET `fullName`='$fullName', `email`='$email', `phoneNumber`='$phoneNumber', `address`='$address', `avatar`='$newFileName' WHERE `id`='$userId'";
                if (mysqli_query($conn, $sql_update)) {
                    $_SESSION['user']['fullName'] = $fullName;
                    $_SESSION['user']['email'] = $email;
                    $_SESSION['user']['phoneNumber'] = $phoneNumber;
                    $_SESSION['user']['address'] = $address;
                    $_SESSION['user']['avatar'] = $newFileName;
                    include "./views/page/profile.php";
                    success('Cập nhật hồ sơ thành công!', 'index.php?act=profile');
                     exit();
                } else {
                    include "./views/page/profile.php";
                    error('Cập nhật hồ sơ thất bại!', 'index.php?act=profile');
                     exit();
                }
            } else {
                include "./views/page/profile.php";
                error('Có lỗi xảy ra khi tải lên ảnh đại diện. Vui lòng thử lại.', 'index.php?act=profile');
                exit();
            }
        }
    } else {
        $sql_update = "UPDATE `account` SET `fullName`='$fullName', `email`='$email', `phoneNumber`='$phoneNumber', `address`='$address' WHERE `id`='$userId'";
        if (mysqli_query($conn, $sql_update)) {
            $_SESSION['user']['fullName'] = $fullName;
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['phoneNumber'] = $phoneNumber;
            $_SESSION['user']['address'] = $address;
            include "./views/page/profile.php";
            success('Cập nhật hồ sơ thành công!', 'index.php?act=profile');
            exit();
        } else {
            include "./views/page/profile.php";
            error('Cập nhật hồ sơ thất bại!', 'index.php?act=profile');
            exit();
        }
    }
}

include "./views/page/profile.php";
return;
