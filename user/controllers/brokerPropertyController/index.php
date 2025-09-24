<?php
// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == '') {
    header("Location: index.php?act=login");
    exit();
}

// Kiểm tra quyền truy cập - chỉ User(1) và Broker(2) mới có BĐS của mình
if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] != '1' && $_SESSION['user_role'] != '2')) {
    errorNotLoad('Bạn không có quyền truy cập trang này.');
    header("Location: index.php");
    exit();
}

$userId = $_SESSION['user_id'];

try {
    // Xử lý các action POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        $propertyId = intval($_POST['propertyId'] ?? 0);
        
        if ($propertyId > 0) {
            switch ($action) {
                case 'toggle_status':
                    $newStatus = $_POST['status'] ?? 'inactive';
                    $allowedStatus = ['active', 'inactive', 'pending'];
                    if (in_array($newStatus, $allowedStatus)) {
                        $stmt = $conn->prepare("
                            UPDATE rental_property rp 
                            INNER JOIN broker b ON rp.brokerId = b.id 
                            SET rp.status = ?, rp.updatedAt = NOW() 
                            WHERE rp.id = ? AND b.accountId = ?
                        ");
                        $stmt->bind_param("sii", $newStatus, $propertyId, $userId);
                        if ($stmt->execute()) {
                            success('Cập nhật trạng thái thành công!', '?act=brokerProperty');
                        } else {
                            errorNotLoad('Có lỗi khi cập nhật trạng thái.');
                        }
                        $stmt->close();
                    }
                    break;
                    
                case 'delete':
                    $stmt = $conn->prepare("
                        DELETE rp FROM rental_property rp 
                        INNER JOIN broker b ON rp.brokerId = b.id 
                        WHERE rp.id = ? AND b.accountId = ?
                    ");
                    $stmt->bind_param("ii", $propertyId, $userId);
                    if ($stmt->execute()) {
                        success('Xóa bất động sản thành công!', '?act=brokerProperty');
                    } else {
                        errorNotLoad('Có lỗi khi xóa bất động sản.');
                    }
                    $stmt->close();
                    break;
            }
        }
    }
    
    // Lấy brokerId từ userId
    $brokerId = null;
    if ($_SESSION['user_role'] == '2') { // Nếu là broker
        $stmt = $conn->prepare("SELECT id FROM broker WHERE accountId = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $brokerId = $row['id'];
        }
        $stmt->close();
    }
    
    // Pagination
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $limit = 12;
    $offset = ($page - 1) * $limit;
    
    // Filter
    $statusFilter = $_GET['status'] ?? 'all';
    $searchFilter = $_GET['search'] ?? '';
    
    // Build WHERE conditions
    $whereConditions = [];
    $params = [];
    $types = "";
    
    if ($brokerId) {
        $whereConditions[] = "rp.brokerId = ?";
        $params[] = $brokerId;
        $types .= "i";
    } else {
        // Nếu không phải broker, lấy properties của user (trường hợp user đăng trực tiếp)
        $whereConditions[] = "rp.userId = ?";
        $params[] = $userId;
        $types .= "i";
    }
    
    if ($statusFilter !== 'all') {
        $whereConditions[] = "rp.status = ?";
        $params[] = $statusFilter;
        $types .= "s";
    }
    
    if (!empty($searchFilter)) {
        $whereConditions[] = "(rp.title LIKE ? OR rp.address LIKE ?)";
        $searchTerm = "%$searchFilter%";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $types .= "ss";
    }
    
    $whereClause = !empty($whereConditions) ? "WHERE " . implode(" AND ", $whereConditions) : "";
    
    // Đếm tổng số properties
    $countSql = "
        SELECT COUNT(*) as total 
        FROM rental_property rp 
        LEFT JOIN broker b ON rp.brokerId = b.id
        LEFT JOIN type_rental_property t ON rp.typeId = t.id
        LEFT JOIN location l ON rp.locationId = l.id
        $whereClause
    ";
    
    $countStmt = $conn->prepare($countSql);
    if (!empty($params)) {
        $countStmt->bind_param($types, ...$params);
    }
    $countStmt->execute();
    $totalCount = $countStmt->get_result()->fetch_assoc()['total'];
    $countStmt->close();
    
    $totalPages = ceil($totalCount / $limit);
    
    // Lấy danh sách properties
    $sql = "
        SELECT 
            rp.*,
            t.name as propertyType,
            l.name as locationName,
            (SELECT imagePath FROM property_images WHERE propertyId = rp.id AND isMain = 1 LIMIT 1) as mainImage,
            (SELECT COUNT(*) FROM property_images WHERE propertyId = rp.id) as imageCount
        FROM rental_property rp 
        LEFT JOIN broker b ON rp.brokerId = b.id
        LEFT JOIN type_rental_property t ON rp.typeId = t.id
        LEFT JOIN location l ON rp.locationId = l.id
        $whereClause
        ORDER BY rp.createdAt DESC
        LIMIT ? OFFSET ?
    ";
    
    $params[] = $limit;
    $params[] = $offset;
    $types .= "ii";
    
    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $properties = [];
    
    while ($row = $result->fetch_assoc()) {
        $properties[] = $row;
    }
    $stmt->close();
    
    // Thống kê dashboard
    $stats = [
        'total' => 0,
        'active' => 0,
        'pending' => 0,
        'inactive' => 0
    ];
    
    // Đếm theo status
    $statsConditions = [];
    $statsParams = [];
    $statsTypes = "";
    
    if ($brokerId) {
        $statsConditions[] = "rp.brokerId = ?";
        $statsParams[] = $brokerId;
        $statsTypes .= "i";
    } else {
        $statsConditions[] = "rp.userId = ?";
        $statsParams[] = $userId;
        $statsTypes .= "i";
    }
    
    $statsWhere = !empty($statsConditions) ? "WHERE " . implode(" AND ", $statsConditions) : "";
    
    $statsSql = "
        SELECT rp.status, COUNT(*) as count 
        FROM rental_property rp 
        LEFT JOIN broker b ON rp.brokerId = b.id
        $statsWhere
        GROUP BY rp.status
    ";
    
    $statsStmt = $conn->prepare($statsSql);
    if (!empty($statsParams)) {
        $statsStmt->bind_param($statsTypes, ...$statsParams);
    }
    $statsStmt->execute();
    $statsResult = $statsStmt->get_result();
    
    while ($row = $statsResult->fetch_assoc()) {
        $stats[$row['status']] = intval($row['count']);
        $stats['total'] += intval($row['count']);
    }
    $statsStmt->close();

} catch (Exception $e) {
    error_log("Broker Property controller error: " . $e->getMessage());
    errorNotLoad('Có lỗi xảy ra khi tải trang. Vui lòng thử lại.');
    
    // Giá trị mặc định khi có lỗi
    $properties = [];
    $totalCount = 0;
    $totalPages = 0;
    $page = 1;
    $stats = [
        'total' => 0,
        'active' => 0,  
        'pending' => 0,
        'inactive' => 0
    ];
}

include "./views/page/brokerProperty.php";
return;