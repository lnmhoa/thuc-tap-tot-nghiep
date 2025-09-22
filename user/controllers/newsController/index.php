<?php
// Lấy ID tin tức từ URL
$newsId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($newsId <= 0) {
    error('ID tin tức không hợp lệ!', 'index.php?act=listNews');
    return;
}

// Lấy thông tin chi tiết tin tức
$sql_news = "SELECT n.*, tn.name as typeName 
             FROM `news` n 
             INNER JOIN `typenews` tn ON n.typeId = tn.id 
             WHERE n.id = $newsId";
$newsResult = mysqli_query($conn, $sql_news);

if (!$newsResult || mysqli_num_rows($newsResult) == 0) {
    error('Không tìm thấy tin tức!', 'index.php?act=listNews');
    return;
}

$newsDetail = mysqli_fetch_assoc($newsResult);

// Cập nhật lượt xem
$updateViews = "UPDATE `news` SET views = views + 1 WHERE id = $newsId";
mysqli_query($conn, $updateViews);

// Lấy tin tức liên quan (cùng danh mục, khác ID)
$sql_related = "SELECT n.*, tn.name as typeName 
                FROM `news` n 
                INNER JOIN `typenews` tn ON n.typeId = tn.id 
                WHERE n.typeId = {$newsDetail['typeId']} AND n.id != $newsId 
                ORDER BY n.createdAt DESC 
                LIMIT 4";
$relatedResult = mysqli_query($conn, $sql_related);
$relatedNews = mysqli_fetch_all($relatedResult, MYSQLI_ASSOC);

// Lấy tin tức cùng thể loại (để hiển thị ở cuối trang)
$sql_similar = "SELECT n.*, tn.name as typeName 
                FROM `news` n 
                INNER JOIN `typenews` tn ON n.typeId = tn.id 
                WHERE n.typeId = {$newsDetail['typeId']} AND n.id != $newsId 
                ORDER BY n.views DESC 
                LIMIT 3";
$similarResult = mysqli_query($conn, $sql_similar);
$similarNews = mysqli_fetch_all($similarResult, MYSQLI_ASSOC);

// Lấy danh mục phổ biến
$sql_categories = "SELECT tn.*, COUNT(n.id) as news_count 
                   FROM `typenews` tn 
                   LEFT JOIN `news` n ON tn.id = n.typeId 
                   GROUP BY tn.id 
                   ORDER BY news_count DESC 
                   LIMIT 5";
$categoriesResult = mysqli_query($conn, $sql_categories);
$popularCategories = mysqli_fetch_all($categoriesResult, MYSQLI_ASSOC);

include "./views/page/news.php";
return;
