<?php
// Kiểm tra nếu user đã đăng nhập
if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != '') {
    header("Location: index.php?act=home");
    exit();
}

// Xử lý đăng ký
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    
    // Lấy và làm sạch dữ liệu input
    $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $password_confirm = isset($_POST['password-confirm']) ? $_POST['password-confirm'] : '';

    // Validation chi tiết
    // Kiểm tra họ và tên
    if (empty($fullname)) {
        $errors[] = 'Họ và tên không được để trống.';
    } elseif (strlen($fullname) < 2) {
        $errors[] = 'Họ và tên phải có ít nhất 2 ký tự.';
    } elseif (strlen($fullname) > 100) {
        $errors[] = 'Họ và tên không được vượt quá 100 ký tự.';
    } elseif (!preg_match('/^[a-zA-ZàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđĐ\s]+$/u', $fullname)) {
        $errors[] = 'Họ và tên chỉ được chứa chữ cái và khoảng trắng.';
    }

    // Kiểm tra số điện thoại
    if (empty($phone)) {
        $errors[] = 'Số điện thoại không được để trống.';
    } elseif (!preg_match('/^(0|\+84)[3|5|7|8|9][0-9]{8}$/', $phone)) {
        $errors[] = 'Số điện thoại không hợp lệ. Vui lòng nhập đúng định dạng (0xxxxxxxxx).';
    } else {
        // Kiểm tra số điện thoại đã tồn tại
        $stmt_check = $conn->prepare("SELECT id FROM account WHERE phoneNumber = ?");
        $stmt_check->bind_param("s", $phone);
        $stmt_check->execute();
        $result = $stmt_check->get_result();
        if ($result->num_rows > 0) {
            $errors[] = 'Số điện thoại này đã được sử dụng.';
        }
        $stmt_check->close();
    }

    // Kiểm tra mật khẩu
    if (empty($password)) {
        $errors[] = 'Mật khẩu không được để trống.';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự.';
    } elseif (strlen($password) > 255) {
        $errors[] = 'Mật khẩu không được vượt quá 255 ký tự.';
    } elseif (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)/', $password)) {
        $errors[] = 'Mật khẩu phải chứa ít nhất 1 chữ cái và 1 số.';
    }

    // Kiểm tra xác nhận mật khẩu
    if (empty($password_confirm)) {
        $errors[] = 'Vui lòng nhập lại mật khẩu.';
    } elseif ($password !== $password_confirm) {
        $errors[] = 'Mật khẩu xác nhận không khớp.';
    }

    // Nếu không có lỗi, thực hiện đăng ký
    if (empty($errors)) {
        try {
            // Bắt đầu transaction
            $conn->autocommit(FALSE);
            
            // Hash mật khẩu
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Chèn account mới với role mặc định là 3 (User)
            $stmt = $conn->prepare("INSERT INTO account (fullName, phoneNumber, password, role, status, createdAt, updatedAt) VALUES (?, ?, ?, '3', 'active', NOW(), NOW())");
            $stmt->bind_param("sss", $fullname, $phone, $hashed_password);
            
            if ($stmt->execute()) {
                // Commit transaction
                $conn->commit();
                $stmt->close();
                
                success('Đăng ký thành công! Vui lòng đăng nhập để tiếp tục.', 'index.php?act=login');
                exit();
            } else {
                throw new Exception('Lỗi khi tạo tài khoản: ' . $stmt->error);
            }
            
        } catch (Exception $e) {
            // Rollback transaction nếu có lỗi
            $conn->rollback();
            error_log("Registration error: " . $e->getMessage());
            $errors[] = 'Có lỗi xảy ra trong quá trình đăng ký. Vui lòng thử lại.';
        } finally {
            $conn->autocommit(TRUE);
        }
    }
    
    // Hiển thị lỗi đầu tiên nếu có
    if (!empty($errors)) {
        errorNotLoad($errors[0]);
    }
}

include "./views/page/register.php";
return;
