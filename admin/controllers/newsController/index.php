<?php

$limit = 4;
$_SESSION['sort-news'] = isset($_SESSION['sort-news']) ? $_SESSION['sort-news'] : 'desc';
$_SESSION['sort-status-news'] = isset($_SESSION['sort-status-news']) ? $_SESSION['sort-status-news'] : '2';
$_SESSION['search-news'] = isset($_SESSION['search-news']) ? $_SESSION['search-news'] : '';
if (isset($_POST['sort-news'])) {
  $_SESSION['sort-news'] = $_POST['sort-news'];
}
if (isset($_POST['search-news'])) {
  $_SESSION['search-news'] = $_POST['search-news'];
}
if (isset($_POST['sort-status-news'])) {
  $_SESSION['sort-status-news'] = $_POST['sort-status-news'];
}
$total = mysqli_query($conn, "SELECT * FROM `news` WHERE title LIKE '%" . $_SESSION['search-news'] . "%'");
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$total_page = ceil(mysqli_num_rows($total) / $limit);
if ($current_page > $total_page) {
  $current_page = $total_page;
}
if ($current_page < 1) {
  $current_page = 1;
}
$start = ($current_page - 1) * $limit;
$sql_list = "SELECT n.*, tn.name as typeName 
             FROM `news` n 
             INNER JOIN `typenews` tn ON n.typeId = tn.id 
             WHERE n.title LIKE '%" . $_SESSION['search-news'] . "%' 
             ORDER BY n.id " . $_SESSION['sort-news'] . " 
             LIMIT $start, $limit";
$listTypeNewsResult = mysqli_query($conn, "SELECT id, name FROM `typenews`");
$listNewsResult = mysqli_query($conn, $sql_list);
if ($listNewsResult) {
  $listTypeNews = mysqli_fetch_all($listTypeNewsResult, MYSQLI_ASSOC);
  $listNews = mysqli_fetch_all($listNewsResult, MYSQLI_ASSOC);
} else {
  error('Lấy thông tin tin tức thất bại!', 'index.php?act=news');
}

include "./views/page/news.php";
return;
