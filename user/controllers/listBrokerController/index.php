<?php
// Lấy danh sách quận/huyện
$districtsResult = mysqli_query($conn, "SELECT id, name, type FROM `location` WHERE status = 1 ORDER BY id ASC");
$districts = mysqli_fetch_all($districtsResult, MYSQLI_ASSOC);

// Lấy danh sách chuyên môn
$expertisesResult = mysqli_query($conn, "SELECT id, name, icon FROM `expertises` WHERE status = 1 ORDER BY name");
$expertises = mysqli_fetch_all($expertisesResult, MYSQLI_ASSOC);

$limit = 8;
$_SESSION['sort-broker'] = isset($_SESSION['sort-broker']) ? $_SESSION['sort-broker'] : 'rating';

// Xử lý dữ liệu session cũ - chuyển đổi từ string sang array nếu cần
$_SESSION['filter-area'] = isset($_SESSION['filter-area']) ? $_SESSION['filter-area'] : array();
if (is_string($_SESSION['filter-area'])) {
    $_SESSION['filter-area'] = !empty($_SESSION['filter-area']) ? array($_SESSION['filter-area']) : array();
}

$_SESSION['filter-expertise'] = isset($_SESSION['filter-expertise']) ? $_SESSION['filter-expertise'] : array();
if (is_string($_SESSION['filter-expertise'])) {
    $_SESSION['filter-expertise'] = !empty($_SESSION['filter-expertise']) ? array($_SESSION['filter-expertise']) : array();
}

$_SESSION['filter-rating'] = isset($_SESSION['filter-rating']) ? $_SESSION['filter-rating'] : '';

$_SESSION['filter-language'] = isset($_SESSION['filter-language']) ? $_SESSION['filter-language'] : array();
if (is_string($_SESSION['filter-language'])) {
    $_SESSION['filter-language'] = !empty($_SESSION['filter-language']) ? array($_SESSION['filter-language']) : array();
}

// Xử lý POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['sort-broker'])) {
    $_SESSION['sort-broker'] = $_POST['sort-broker'];
  }
  if (isset($_POST['filter-area'])) {
    $_SESSION['filter-area'] = $_POST['filter-area']; // Giờ đây sẽ là mảng
  } else {
    $_SESSION['filter-area'] = array(); // Reset nếu không có checkbox nào được chọn
  }
  if (isset($_POST['filter-expertise'])) {
    $_SESSION['filter-expertise'] = $_POST['filter-expertise'];
  } else {
    $_SESSION['filter-expertise'] = array();
  }
  if (isset($_POST['filter-rating'])) {
    $_SESSION['filter-rating'] = $_POST['filter-rating'];
  }
  if (isset($_POST['filter-language'])) {
    $_SESSION['filter-language'] = $_POST['filter-language'];
  } else {
    $_SESSION['filter-language'] = array();
  }
  if (isset($_POST['clear-filter'])) {
    $_SESSION['filter-area'] = array(); // Thay đổi từ string thành array
    $_SESSION['filter-expertise'] = array();
    $_SESSION['filter-rating'] = '';
    $_SESSION['filter-language'] = array();
  }
  
  // Redirect về URL gốc sau khi xử lý POST
  header('Location: index.php?act=listBroker');
  exit();
}

// Xây dựng điều kiện WHERE
$whereConditions = array();
$whereConditions[] = "a.status = 1"; // Chỉ lấy tài khoản active
$whereConditions[] = "a.role = 2"; // Chỉ lấy tài khoản broker

// Lọc theo khu vực - cập nhật logic
if (!empty($_SESSION['filter-area'])) {
  $areaConditions = array();
  foreach ($_SESSION['filter-area'] as $area) {
    $area = mysqli_real_escape_string($conn, $area);
    $areaConditions[] = "b.mainArea LIKE '%$area%'";
  }
  $whereConditions[] = "(" . implode(' OR ', $areaConditions) . ")";
}

// Lọc theo chuyên môn
if (!empty($_SESSION['filter-expertise'])) {
  $expertiseConditions = array();
  foreach ($_SESSION['filter-expertise'] as $expertise) {
    $expertise = mysqli_real_escape_string($conn, $expertise);
    $expertiseConditions[] = "b.expertise LIKE '%$expertise%'";
  }
  $whereConditions[] = "(" . implode(' OR ', $expertiseConditions) . ")";
}

// Lọc theo đánh giá
if (!empty($_SESSION['filter-rating'])) {
  switch ($_SESSION['filter-rating']) {
    case '5':
      $whereConditions[] = "avg_rating = 5";
      break;
    case '4+':
      $whereConditions[] = "avg_rating >= 4";
      break;
    case '3+':
      $whereConditions[] = "avg_rating >= 3";
      break;
  }
}

// Lọc theo ngôn ngữ
if (!empty($_SESSION['filter-language'])) {
  $languageConditions = array();
  foreach ($_SESSION['filter-language'] as $language) {
    $language = mysqli_real_escape_string($conn, $language);
    $languageConditions[] = "b.language LIKE '%$language%'";
  }
  $whereConditions[] = "(" . implode(' OR ', $languageConditions) . ")";
}

$whereClause = implode(' AND ', $whereConditions);

// Đếm tổng số broker
$totalResult = mysqli_query($conn, "SELECT COUNT(*) as total FROM `broker` b 
                                       INNER JOIN `account` a ON b.accountId = a.id 
                                       WHERE $whereClause");
$totalData = mysqli_fetch_assoc($totalResult);
$totalBrokers = $totalData['total'];

// Phân trang
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$total_page = ceil($totalBrokers / $limit);
if ($current_page > $total_page && $total_page > 0) {
  $current_page = $total_page;
}
if ($current_page < 1) {
  $current_page = 1;
}
$start = ($current_page - 1) * $limit;

// Xây dựng ORDER BY
$orderBy = "b.id DESC";
switch ($_SESSION['sort-broker']) {
  case 'rating':
    $orderBy = "avg_rating DESC";
    break;
  case 'newest':
    $orderBy = "a.createdAt DESC";
    break;
  case 'experience':
    $orderBy = "a.createdAt ASC"; // Tài khoản cũ = kinh nghiệm nhiều
}

// Lấy danh sách broker
$sql_list = "SELECT b.*, a.fullName, a.email, a.phoneNumber, a.avatar, a.createdAt, AVG(br.rating) AS avg_rating
             FROM `broker` b 
             INNER JOIN `account` a ON b.accountId = a.id 
             LEFT JOIN `broker_ratings` br ON b.id = br.brokerId
             WHERE $whereClause
             GROUP BY b.id
             ORDER BY $orderBy 
             LIMIT $start, $limit";

$listBrokerResult = mysqli_query($conn, $sql_list);
if ($listBrokerResult) {
  $listBrokers = mysqli_fetch_all($listBrokerResult, MYSQLI_ASSOC);
} else {
  error('Lấy thông tin môi giới thất bại!', 'index.php');
}

include "./views/page/listBroker.php";
return;