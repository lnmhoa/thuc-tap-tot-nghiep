<?php
$sql_pinNews = "SELECT n.id, n.title, n.image, n.content, n.createdAt, n.views, t.name FROM `news` n, `typenews` t WHERE n.pin = 1 GROUP BY n.id";
$sql_listNews = "SELECT n.id, n.title, n.image, n.content, n.createdAt, n.views, t.name FROM `news` n, `typenews` t WHERE n.typeId = t.id AND n.pin = 0 ORDER BY `createdAt` ASC LIMIT 0, 2";
$pinNews = mysqli_query($conn, $sql_pinNews);
$listNews = mysqli_query($conn, $sql_listNews);
$listNewsHome = mysqli_fetch_all($listNews, MYSQLI_ASSOC);
$pinNewsHome = mysqli_fetch_all($pinNews, MYSQLI_ASSOC);
include "./views/page/home.php";
return;
