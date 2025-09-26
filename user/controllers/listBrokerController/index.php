<?php
$districtsResult = mysqli_query($conn, "SELECT id, name, type FROM `location` ORDER BY id ASC");
$districts = mysqli_fetch_all($districtsResult, MYSQLI_ASSOC);

$expertisesResult = mysqli_query($conn, "SELECT id, name, icon FROM `expertises` WHERE status = 1 ORDER BY name");
$expertises = mysqli_fetch_all($expertisesResult, MYSQLI_ASSOC);

$limit = 8;
$_SESSION['sort-broker'] = isset($_SESSION['sort-broker']) ? $_SESSION['sort-broker'] : 'rating';

$_SESSION['filter-area'] = isset($_SESSION['filter-area']) ? $_SESSION['filter-area'] : array();
if (is_string($_SESSION['filter-area'])) {
    $_SESSION['filter-area'] = !empty($_SESSION['filter-area']) ? array($_SESSION['filter-area']) : array();
}

$_SESSION['filter-expertise'] = isset($_SESSION['filter-expertise']) ? $_SESSION['filter-expertise'] : array();
if (is_string($_SESSION['filter-expertise'])) {
    $_SESSION['filter-expertise'] = !empty($_SESSION['filter-expertise']) ? array($_SESSION['filter-expertise']) : array();
}

$_SESSION['filter-language'] = isset($_SESSION['filter-language']) ? $_SESSION['filter-language'] : array();
if (is_string($_SESSION['filter-language'])) {
    $_SESSION['filter-language'] = !empty($_SESSION['filter-language']) ? array($_SESSION['filter-language']) : array();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['sort-broker'])) {
    $_SESSION['sort-broker'] = $_POST['sort-broker'];
  }
  if (isset($_POST['filter-area'])) {
    $_SESSION['filter-area'] = $_POST['filter-area']; 
  } else {
    $_SESSION['filter-area'] = array();
  }
  if (isset($_POST['filter-expertise'])) {
    $_SESSION['filter-expertise'] = $_POST['filter-expertise'];
  } else {
    $_SESSION['filter-expertise'] = array();
  }
  if (isset($_POST['filter-language'])) {
    $_SESSION['filter-language'] = $_POST['filter-language'];
  } else {
    $_SESSION['filter-language'] = array();
  }
  if (isset($_POST['clear-filter'])) {
    $_SESSION['filter-area'] = array();
    $_SESSION['filter-expertise'] = array();
    $_SESSION['filter-language'] = array();
  }
  
  header('Location: index.php?act=listBroker');
  exit();
}

$whereConditions = array();
$whereConditions[] = "a.status = 1"; 
$whereConditions[] = "a.role = 2";

if (!empty($_SESSION['filter-area'])) {
  $areaConditions = array();
  foreach ($_SESSION['filter-area'] as $area) {
    $area = mysqli_real_escape_string($conn, $area);
    $areaConditions[] = "b.mainArea LIKE '%$area%'";
  }
  $whereConditions[] = "(" . implode(' OR ', $areaConditions) . ")";
}

if (!empty($_SESSION['filter-expertise'])) {
  $expertiseConditions = array();
  foreach ($_SESSION['filter-expertise'] as $expertise) {
    $expertise = mysqli_real_escape_string($conn, $expertise);
    $expertiseConditions[] = "b.expertise LIKE '%$expertise%'";
  }
  $whereConditions[] = "(" . implode(' OR ', $expertiseConditions) . ")";
}

if (!empty($_SESSION['filter-language'])) {
  $languageConditions = array();
  foreach ($_SESSION['filter-language'] as $language) {
    $language = mysqli_real_escape_string($conn, $language);
    $languageConditions[] = "b.language LIKE '%$language%'";
  }
  $whereConditions[] = "(" . implode(' OR ', $languageConditions) . ")";
}

$whereClause = implode(' AND ', $whereConditions);

$countQuery = "SELECT COUNT(DISTINCT b.id) as total 
               FROM `broker` b 
               INNER JOIN `account` a ON b.accountId = a.id 
               WHERE $whereClause";

$totalResult = mysqli_query($conn, $countQuery);
$totalData = mysqli_fetch_assoc($totalResult);
$totalBrokers = $totalData['total'];

$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$total_page = ceil($totalBrokers / $limit);
if ($current_page > $total_page && $total_page > 0) {
  $current_page = $total_page;
}
if ($current_page < 1) {
  $current_page = 1;
}
$start = ($current_page - 1) * $limit;

$orderBy = "b.id DESC";
switch ($_SESSION['sort-broker']) {
  case 'rating':
    $orderBy = "avg_rating DESC";
    break;
  case 'newest':
    $orderBy = "a.createdAt DESC";
    break;
  case 'experience':
    $orderBy = "a.createdAt ASC";
}

$sql_list = "SELECT b.*, a.fullName, a.email, a.phoneNumber, a.avatar, a.createdAt, AVG(br.rating) AS avg_rating
             FROM `broker` b 
             INNER JOIN `account` a ON b.accountId = a.id 
             LEFT JOIN `broker_ratings` br ON b.id = br.brokerId
             WHERE $whereClause
             GROUP BY b.id, a.fullName, a.email, a.phoneNumber, a.avatar, a.createdAt
             ORDER BY $orderBy 
             LIMIT $start, $limit";

$listBrokerResult = mysqli_query($conn, $sql_list);
if ($listBrokerResult) {
  $listBrokers = mysqli_fetch_all($listBrokerResult, MYSQLI_ASSOC);
  if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') {
    $userId = $_SESSION['user']['id'];
    foreach ($listBrokers as &$broker) {
      $checkFollow = mysqli_query($conn, "SELECT id FROM follow_broker WHERE idUser = $userId AND idBroker = {$broker['id']}");
      $broker['isFollowed'] = mysqli_num_rows($checkFollow) > 0;
    }
  } else {
    foreach ($listBrokers as &$broker) {
      $broker['isFollowed'] = false;
    }
  }
} else {
  error('Lấy thông tin môi giới thất bại!', 'index.php');
}

include "./views/page/listBroker.php";
return;