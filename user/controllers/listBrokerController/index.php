<?php
$locationResult = mysqli_query($conn, "SELECT id, name FROM `location` ORDER BY id ASC");
$location = mysqli_fetch_all($locationResult, MYSQLI_ASSOC);

$expertisesResult = mysqli_query($conn, "SELECT id, name, icon FROM `expertises` ORDER BY name");
$expertises = mysqli_fetch_all($expertisesResult, MYSQLI_ASSOC);

$limit = 8;
$_SESSION['sort-broker'] = isset($_SESSION['sort-broker']) ? $_SESSION['sort-broker'] : 'rating';


$_SESSION['filter-expertise'] = isset($_SESSION['filter-expertise']) ? $_SESSION['filter-expertise'] : array();
if (is_string($_SESSION['filter-expertise'])) {
    $_SESSION['filter-expertise'] = !empty($_SESSION['filter-expertise']) ? array($_SESSION['filter-expertise']) : array();
}

$_SESSION['filter-area'] = isset($_SESSION['filter-area']) ? $_SESSION['filter-area'] : array();
if (is_string($_SESSION['filter-area'])) {
    $_SESSION['filter-area'] = !empty($_SESSION['filter-area']) ? array($_SESSION['filter-area']) : array();
}


$_SESSION['filter-language'] = isset($_SESSION['filter-language']) ? $_SESSION['filter-language'] : array();
if (is_string($_SESSION['filter-language'])) {
    $_SESSION['filter-language'] = !empty($_SESSION['filter-language']) ? array($_SESSION['filter-language']) : array();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['sort-broker'])) {
    $_SESSION['sort-broker'] = $_POST['sort-broker'];
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
  if (isset($_POST['filter-area'])) {
    $_SESSION['filter-area'] = $_POST['filter-area'];
  } else {
    $_SESSION['filter-area'] = array();
  }
  if (isset($_POST['clear-filter'])) {
    $_SESSION['filter-expertise'] = array();
    $_SESSION['filter-language'] = array();
    $_SESSION['filter-area'] = array();
  }
  
  header('Location: index.php?act=listBroker');
  exit();
}

$whereConditions = array();
$whereConditions[] = "a.status = 'active'"; 
$whereConditions[] = "a.role = 2";

if (!empty($_SESSION['filter-expertise'])) {
  $expertiseConditions = array();
  foreach ($_SESSION['filter-expertise'] as $expertise) {
    $expertise = mysqli_real_escape_string($conn, $expertise);
    $expertiseConditions[] = "b1.expertise LIKE '%$expertise%'";
  }
  $whereConditions[] = "(" . implode(' OR ', $expertiseConditions) . ")";
}

if (!empty($_SESSION['filter-language'])) {
  $languageConditions = array();
  foreach ($_SESSION['filter-language'] as $language) {
    $language = mysqli_real_escape_string($conn, $language);
    $languageConditions[] = "b1.language LIKE '%$language%'";
  }
  $whereConditions[] = "(" . implode(' OR ', $languageConditions) . ")";
}
if (!empty($_SESSION['filter-area'])) {
  $areaConditions = array();
  foreach ($_SESSION['filter-area'] as $area) {
    $area = (int)$area; // Convert to integer since location is now ID
    $areaConditions[] = "b1.location = $area";
  }
  $whereConditions[] = "(" . implode(' OR ', $areaConditions) . ")";
}

$whereClause = implode(' AND ', $whereConditions);

$countQuery = "SELECT COUNT(DISTINCT a.id) as total 
               FROM `broker` b1 
               INNER JOIN `account` a ON b1.accountId = a.id 
               LEFT JOIN `location` l ON b1.location = l.id
               INNER JOIN (
                   SELECT accountId, MAX(id) as max_id
                   FROM `broker` 
                   GROUP BY accountId
               ) b2 ON b1.accountId = b2.accountId AND b1.id = b2.max_id
               WHERE $whereClause";

$totalResult = mysqli_query($conn, query: $countQuery);
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

$orderBy = "b1.id DESC";
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

$sql_list = "SELECT b1.*, a.fullName, a.email, a.phoneNumber, a.avatar, a.createdAt, 
                    l.name as locationName, l.name as mainArea,
                    AVG(br.rating) AS avg_rating,
                    COUNT(br.rating) AS rating_count
             FROM `broker` b1 
             INNER JOIN `account` a ON b1.accountId = a.id 
             LEFT JOIN `location` l ON b1.location = l.id
             INNER JOIN (
                 SELECT accountId, MAX(id) as max_id
                 FROM `broker` 
                 GROUP BY accountId
             ) b2 ON b1.accountId = b2.accountId AND b1.id = b2.max_id
             LEFT JOIN `broker_ratings` br ON b1.id = br.brokerId
             WHERE $whereClause
             GROUP BY b1.id
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