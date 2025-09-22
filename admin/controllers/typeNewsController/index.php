<?php

$limit = 4;
$_SESSION['sort-type-news'] = isset($_SESSION['sort-type-news']) ? $_SESSION['sort-type-news'] : 'desc';
$_SESSION['sort-status-type-news'] = isset($_SESSION['sort-status-type-news']) ? $_SESSION['sort-status-type-news'] : '2';
$_SESSION['search-type-news'] = isset($_SESSION['search-type-news']) ? $_SESSION['search-type-news'] : '';
if (isset($_POST['sort-type-news'])) {
  $_SESSION['sort-type-news'] = $_POST['sort-type-news'];
}
if (isset($_POST['search-type-news'])) {
  $_SESSION['search-type-news'] = $_POST['search-type-news'];
}
if (isset($_POST['sort-status-type-news'])) {
  $_SESSION['sort-status-type-news'] = $_POST['sort-status-type-news'];
}
$total = mysqli_query($conn, "SELECT * FROM `typenews` WHERE name LIKE '%" . $_SESSION['search-type-news'] . "%'");
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$total_page = ceil(mysqli_num_rows($total) / $limit);
if ($current_page > $total_page) {
  $current_page = $total_page;
}
if ($current_page < 1) {
  $current_page = 1;
}
$start = ($current_page - 1) * $limit;
$sql_list = "SELECT tn.*, COUNT(n.id) as newsCount
             FROM `typenews` tn
             LEFT JOIN `news` n ON tn.id = n.typeId
             WHERE tn.name LIKE '%" . $_SESSION['search-type-news'] . "%'
             GROUP BY tn.id
             ORDER BY tn.id " . $_SESSION['sort-type-news'] . "
             LIMIT $start, $limit";
$listTypeNewsResult = mysqli_query($conn, $sql_list);
if ($listTypeNewsResult) {
  $listTypeNews = mysqli_fetch_all($listTypeNewsResult, MYSQLI_ASSOC);
} else {
  error('Lấy thông tin loại tin tức thất bại!', 'index.php?act=typeNews');
}

include "./views/page/typeNews.php";
return;
