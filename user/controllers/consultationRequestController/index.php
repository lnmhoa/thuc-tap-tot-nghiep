<?php
// Kiểm tra đăng nhập
if (!isset($_SESSION['user']['id']) || $_SESSION['user']['id'] == '') {
    header("Location: index.php?act=login");
    exit();
}

$userId = $_SESSION['user']['id'];

try {
    // Xử lý hủy yêu cầu tư vấn
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'cancel') {
        $requestId = isset($_POST['requestId']) ? intval($_POST['requestId']) : 0;
        
        if ($requestId > 0) {
            $stmt = $conn->prepare("UPDATE contact_requests SET status = 'closed' WHERE id = ? AND userId = ?");
            $stmt->bind_param("ii", $requestId, $userId);
            
            if ($stmt->execute()) {
                success('Đã hủy yêu cầu tư vấn!', '?act=consultationRequest');
            } else {
                errorNotLoad('Có lỗi xảy ra khi hủy yêu cầu.');
            }
            $stmt->close();
        }
    }

    // Lấy danh sách yêu cầu tư vấn của user
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    // Đếm tổng số yêu cầu
    $countStmt = $conn->prepare("SELECT COUNT(*) as total FROM contact_requests WHERE userId = ?");
    $countStmt->bind_param("i", $userId);
    $countStmt->execute();
    $countResult = $countStmt->get_result();
    $totalCount = $countResult->fetch_assoc()['total'];
    $countStmt->close();

    $totalPages = ceil($totalCount / $limit);

    // Lấy danh sách yêu cầu tư vấn với thông tin broker
    $stmt = $conn->prepare("
        SELECT 
            cr.*,
            a.fullName as brokerName,
            a.avatar as brokerAvatar,
            a.phoneNumber as brokerPhone
        FROM contact_requests cr
        LEFT JOIN broker b ON cr.brokerId = b.id
        LEFT JOIN account a ON b.accountId = a.id
        WHERE cr.userId = ?
        ORDER BY cr.createdAt DESC
        LIMIT ? OFFSET ?
    ");
    $stmt->bind_param("iii", $userId, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    $consultationRequests = [];
    
    while ($row = $result->fetch_assoc()) {
        $consultationRequests[] = $row;
    }
    $stmt->close();

    // Thống kê
    $stats = [
        'total' => $totalCount,
        'pending' => 0,
        'contacted' => 0,
        'closed' => 0
    ];

    // Đếm theo trạng thái
    $statusStmt = $conn->prepare("
        SELECT status, COUNT(*) as count 
        FROM contact_requests 
        WHERE userId = ? 
        GROUP BY status
    ");
    $statusStmt->bind_param("i", $userId);
    $statusStmt->execute();
    $statusResult = $statusStmt->get_result();
    
    while ($row = $statusResult->fetch_assoc()) {
        $stats[$row['status']] = intval($row['count']);
    }
    $statusStmt->close();

} catch (Exception $e) {
    error_log("Consultation Request controller error: " . $e->getMessage());
    errorNotLoad('Có lỗi xảy ra khi tải trang. Vui lòng thử lại.');
    
    // Giá trị mặc định khi có lỗi
    $consultationRequests = [];
    $totalCount = 0;
    $totalPages = 0;
    $page = 1;
    $stats = [
        'total' => 0,
        'pending' => 0,
        'contacted' => 0,
        'closed' => 0
    ];
}

include "./views/page/consultationRequest.php";
return;
