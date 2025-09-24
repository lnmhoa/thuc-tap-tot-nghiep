<?php

$limit = 4;
$_SESSION['sort-news'] = isset($_SESSION['sort-news']) ? $_SESSION['sort-news'] : 'desc';
$_SESSION['sort-status-news'] = isset($_SESSION['sort-status-news']) ? $_SESSION['sort-status-news'] : '2';
$_SESSION['search-news'] = isset($_SESSION['search-news']) ? $_SESSION['search-news'] : '';
$_SESSION['filter-category'] = isset($_SESSION['filter-category']) ? $_SESSION['filter-category'] : array();
$_SESSION['filter-time'] = isset($_SESSION['filter-time']) ? $_SESSION['filter-time'] : '';

if (isset($_GET['category']) && !empty($_GET['category'])) {
  $categoryFromUrl = (int)$_GET['category'];
  if ($categoryFromUrl > 0) {
    $_SESSION['filter-category'] = array($categoryFromUrl);
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['sort-news'])) {
    $_SESSION['sort-news'] = $_POST['sort-news'];
  }
  if (isset($_POST['search-news'])) {
    $_SESSION['search-news'] = $_POST['search-news'];
  }
  if (isset($_POST['sort-status-news'])) {
    $_SESSION['sort-status-news'] = $_POST['sort-status-news'];
  }
  if (isset($_POST['filter-category'])) {
    $_SESSION['filter-category'] = $_POST['filter-category'];
  }
  if (isset($_POST['filter-time'])) {
    $_SESSION['filter-time'] = $_POST['filter-time'];
  }
  if (isset($_POST['clear-filter'])) {
    $_SESSION['filter-category'] = array();
    $_SESSION['filter-time'] = '';
    $_SESSION['search-news'] = '';
  }
  
  header('Location: index.php?act=listNews');
  exit();
}
if (isset($_POST['sort-news'])) {
  $_SESSION['sort-news'] = $_POST['sort-news'];
}
if (isset($_POST['search-news'])) {
  $_SESSION['search-news'] = $_POST['search-news'];
}
if (isset($_POST['sort-status-news'])) {
  $_SESSION['sort-status-news'] = $_POST['sort-status-news'];
}
if (isset($_POST['filter-category'])) {
  $_SESSION['filter-category'] = $_POST['filter-category'];
}
if (isset($_POST['filter-time'])) {
  $_SESSION['filter-time'] = $_POST['filter-time'];
}
if (isset($_POST['clear-filter'])) {
  $_SESSION['filter-category'] = array();
  $_SESSION['filter-time'] = '';
  $_SESSION['search-news'] = '';
}

// Xây dựng điều kiện WHERE
$whereConditions = array();
$whereConditions[] = "n.title LIKE '%" . $_SESSION['search-news'] . "%'";

// Lọc theo danh mục
if (!empty($_SESSION['filter-category'])) {
  $categoryIds = implode(',', array_map('intval', $_SESSION['filter-category']));
  $whereConditions[] = "n.typeId IN ($categoryIds)";
}

// Lọc theo thời gian
if (!empty($_SESSION['filter-time'])) {
  $timeCondition = '';
  switch ($_SESSION['filter-time']) {
    case 'today':
      $timeCondition = "DATE(n.createdAt) = CURDATE()";
      break;
    case 'week':
      $timeCondition = "YEARWEEK(n.createdAt) = YEARWEEK(NOW())";
      break;
    case 'month':
      $timeCondition = "YEAR(n.createdAt) = YEAR(NOW()) AND MONTH(n.createdAt) = MONTH(NOW())";
      break;
    case 'quarter':
      $timeCondition = "n.createdAt >= DATE_SUB(NOW(), INTERVAL 3 MONTH)";
      break;
  }
  if ($timeCondition) {
    $whereConditions[] = $timeCondition;
  }
}

$whereClause = implode(' AND ', $whereConditions);

$total = mysqli_query($conn, "SELECT * FROM `news` n WHERE $whereClause");
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$total_page = ceil(mysqli_num_rows($total) / $limit);
if ($current_page > $total_page && $total_page > 0) {
  $current_page = $total_page;
}
if ($current_page < 1) {
  $current_page = 1;
}
$start = ($current_page - 1) * $limit;

// Sửa lại ORDER BY để tin có pin = 1 luôn hiển thị đầu tiên
$sql_list = "SELECT n.*, tn.name as typeName 
             FROM `news` n 
             INNER JOIN `typenews` tn ON n.typeId = tn.id 
             WHERE $whereClause
             ORDER BY n.pin DESC, n.id " . $_SESSION['sort-news'] . " 
             LIMIT $start, $limit";

// Lấy tên danh mục hiện tại để hiển thị
$currentCategoryName = '';
if (!empty($_SESSION['filter-category']) && count($_SESSION['filter-category']) == 1) {
  $categoryId = $_SESSION['filter-category'][0];
  $categoryResult = mysqli_query($conn, "SELECT name FROM `typenews` WHERE id = $categoryId");
  if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
    $categoryData = mysqli_fetch_assoc($categoryResult);
    $currentCategoryName = $categoryData['name'];
  }
}

$listTypeNewsResult = mysqli_query($conn, "SELECT id, name FROM `typenews`");
$listNewsResult = mysqli_query($conn, $sql_list);
if ($listNewsResult) {
  $listTypeNews = mysqli_fetch_all($listTypeNewsResult, MYSQLI_ASSOC);
  $listNews = mysqli_fetch_all($listNewsResult, MYSQLI_ASSOC);
} else {
  error('Lấy thông tin tin tức thất bại!', 'index.php?act=news');
}
include "./views/page/listNews.php";
return;
