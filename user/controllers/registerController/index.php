<?php
if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') {
    header("Location: index.php?act=home");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $password_confirm = isset($_POST['password-confirm']) ? $_POST['password-confirm'] : '';

    if ($fullName == '') {
        errorNotLoad('Họ và tên không được để trống.');
    } elseif (strlen($fullName) < 2) {
        errorNotLoad('Họ và tên phải có ít nhất 2 ký tự.');
    } elseif (strlen($fullName) > 100) {
        errorNotLoad('Họ và tên không được vượt quá 100 ký tự.');
    }

    if (empty($phone)) {
        errorNotLoad('Số điện thoại không được để trống.');
    } elseif (!preg_match('/^(0|\+84)[3|5|7|8|9][0-9]{8}$/', $phone)) {
        errorNotLoad('Số điện thoại không hợp lệ. Vui lòng nhập đúng định dạng.');
    } else {
        $stmt_check = $conn->prepare("SELECT id FROM account WHERE phoneNumber = ?");
        $stmt_check->bind_param("s", $phone);
        $stmt_check->execute();
        $result = $stmt_check->get_result();
        if ($result->num_rows > 0) {
            errorNotLoad('Số điện thoại này đã được sử dụng.');
        }
        $stmt_check->close();
    }

    if (empty($password)) {
        errorNotLoad('Mật khẩu không được để trống.');
    } elseif (strlen($password) < 6) {
        errorNotLoad('Mật khẩu phải có ít nhất 6 ký tự.');
    } elseif (strlen($password) > 255) {
        errorNotLoad('Mật khẩu không được vượt quá 255 ký tự.');
    } elseif (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)/', $password)) {
        errorNotLoad('Mật khẩu phải chứa ít nhất 1 chữ cái và 1 số.');
    }

    if (empty($password_confirm)) {
        errorNotLoad('Vui lòng nhập lại mật khẩu.');
    } elseif ($password !== $password_confirm) {
        errorNotLoad('Mật khẩu xác nhận không khớp.');
    }
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$sql= "INSERT INTO account (fullName, phoneNumber, password, role, status, createdAt, updatedAt) VALUES ('$fullName', '$phone', '$hashed_password', '1', 'active', NOW(), NOW())";
          $addAccount=mysqli_query($conn, $sql);  
            if ($addAccount) {
                success('Đăng ký thành công! Vui lòng đăng nhập để tiếp tục.', 'index.php?act=login');
                exit();
            }else{
                errorNotLoad('Có lỗi xảy ra trong quá trình đăng ký. Vui lòng thử lại.');
            }
        }
include "./views/page/register.php";
return;
