<?php
// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == '') {
    header("Location: index.php?act=login");
    exit();
}

$userId = $_SESSION['user_id'];

try {
    // Xử lý xóa bất động sản đã lưu
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'remove') {
        $propertyId = isset($_POST['propertyId']) ? intval($_POST['propertyId']) : 0;
        
        if ($propertyId > 0) {
            $stmt = $conn->prepare("DELETE FROM saved_properties WHERE userId = ? AND propertyId = ?");
            $stmt->bind_param("ii", $userId, $propertyId);
            
            if ($stmt->execute()) {
                success('Đã xóa bất động sản khỏi danh sách yêu thích!', '?act=saveProperty');
            } else {
                errorNotLoad('Có lỗi xảy ra khi xóa bất động sản.');
            }
            $stmt->close();
        }
    }

    // Lấy danh sách bất động sản đã lưu
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $limit = 12;
    $offset = ($page - 1) * $limit;

    // Đếm tổng số bất động sản đã lưu
    $countStmt = $conn->prepare("
        SELECT COUNT(*) as total 
        FROM saved_properties sp 
        INNER JOIN rental_property rp ON sp.propertyId = rp.id 
        WHERE sp.userId = ? AND rp.status = 'active'
    ");
    $countStmt->bind_param("i", $userId);
    $countStmt->execute();
    $countResult = $countStmt->get_result();
    $totalCount = $countResult->fetch_assoc()['total'];
    $countStmt->close();

    $totalPages = ceil($totalCount / $limit);

    // Lấy danh sách bất động sản đã lưu với thông tin chi tiết
    $stmt = $conn->prepare("
        SELECT 
            rp.id,
            rp.title,
            rp.price,
            rp.area,
            rp.address,
            rp.bedrooms,
            rp.bathrooms,
            rp.description,
            rp.transactionType,
            rp.views,
            rp.createdAt,
            sp.createdAt as savedAt,
            t.name as propertyType,
            l.name as locationName,
            a.fullName as brokerName,
            a.avatar as brokerAvatar,
            (SELECT imagePath FROM property_images WHERE propertyId = rp.id AND isMain = 1 LIMIT 1) as mainImage
        FROM saved_properties sp
        INNER JOIN rental_property rp ON sp.propertyId = rp.id
        LEFT JOIN type_rental_property t ON rp.typeId = t.id
        LEFT JOIN location l ON rp.locationId = l.id
        LEFT JOIN broker b ON rp.brokerId = b.id
        LEFT JOIN account a ON b.accountId = a.id
        WHERE sp.userId = ? AND rp.status = 'active'
        ORDER BY sp.createdAt DESC
        LIMIT ? OFFSET ?
    ");
    $stmt->bind_param("iii", $userId, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    $savedProperties = [];
    
    while ($row = $result->fetch_assoc()) {
        $savedProperties[] = $row;
    }
    $stmt->close();

    // Thống kê nhanh
    $stats = [
        'total' => $totalCount,
        'thisMonth' => 0,
        'avgPrice' => 0
    ];

    // Đếm số BĐS lưu trong tháng này
    $monthStmt = $conn->prepare("
        SELECT COUNT(*) as count
        FROM saved_properties sp 
        INNER JOIN rental_property rp ON sp.propertyId = rp.id 
        WHERE sp.userId = ? AND rp.status = 'active' 
        AND MONTH(sp.createdAt) = MONTH(CURRENT_DATE()) 
        AND YEAR(sp.createdAt) = YEAR(CURRENT_DATE())
    ");
    $monthStmt->bind_param("i", $userId);
    $monthStmt->execute();
    $monthResult = $monthStmt->get_result();
    $stats['thisMonth'] = $monthResult->fetch_assoc()['count'];
    $monthStmt->close();

    // Tính giá trung bình
    if ($totalCount > 0) {
        $avgStmt = $conn->prepare("
            SELECT AVG(rp.price) as avgPrice
            FROM saved_properties sp 
            INNER JOIN rental_property rp ON sp.propertyId = rp.id 
            WHERE sp.userId = ? AND rp.status = 'active'
        ");
        $avgStmt->bind_param("i", $userId);
        $avgStmt->execute();
        $avgResult = $avgStmt->get_result();
        $stats['avgPrice'] = $avgResult->fetch_assoc()['avgPrice'] ?? 0;
        $avgStmt->close();
    }

} catch (Exception $e) {
    error_log("Save Property controller error: " . $e->getMessage());
    errorNotLoad('Có lỗi xảy ra khi tải trang. Vui lòng thử lại.');
    
    // Giá trị mặc định khi có lỗi
    $savedProperties = [];
    $totalCount = 0;
    $totalPages = 0;
    $page = 1;
    $stats = [
        'total' => 0,
        'thisMonth' => 0,
        'avgPrice' => 0
    ];
}

include "./views/page/saveProperty.php";
return;
