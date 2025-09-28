<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản trị</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="./views/css/header.css">
    <link rel="stylesheet" href="./views/css/body.css">
    <link rel="stylesheet" href="./views/css/dashboard.css">
    <link rel="stylesheet" href="./views/css/account.css">
    <link rel="stylesheet" href="./views/css/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.28/sweetalert2.all.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.28/sweetalert2.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
</head>
<body>
    <style>
        .current-page {
            background-color: #34495e;
            border-left: 5px solid #3498db;
        }
    </style>
    <div class="layout">
    <div class="admin-container">
        <div class="sidebar">
            <div class="logo">
                <img src="../uploads/system/logo.jpg" alt="logo">
            </div>
            <nav class="navigation">
                <ul>
                    <li><a href="index.php"><i class="fa-solid fa-chart-simple"></i> Tổng quát</a></li>
                    <li><a href="?act=account"><i class="fa-solid fa-user"></i> Quản lý người dùng</a></li>
                    <li><a href="?act=broker"><i class="fa-solid fa-user-tie"></i> Quản lý nhân viên</a></li>
                    <li><a href="?act=rentalProperty"><i class="fa-solid fa-city"></i> Quản lý bất động sản</a></li>
                    <li><a href="?act=contact"><i class="fa-solid fa-phone-volume"></i>Quản lý hỗ trợ</a></li>
                    <li><a href="?act=typeNews"><i class="fa-solid fa-list"></i> Quản lý loại tin tức</a></li>
                    <li><a href="?act=news"><i class="fa-solid fa-newspaper"></i> Quản lý tin tức</a></li>
                </ul>
            </nav>
        </div>
<div style="width: 260px"></div>
<script>
    var links = document.querySelectorAll(".navigation a");
var currentURL = window.location.href;
for (var i = 0; i < links.length; i++) {
    if (links[i].href === currentURL) {
        links[i].classList.add("current-page");
    } else if (currentURL.includes("?index.php&action=account&page=")) {
        document.querySelector('.navigation a[href="?act=account"]').classList.add("current-page");
    } else if (currentURL.includes("?index.php&action=broker&page=")) {
        document.querySelector('.navigation a[href="?act=broker"]').classList.add("current-page");
    } else if (currentURL.includes("?index.php&action=rentalProperty&page=")) {
        document.querySelector('.navigation a[href="?act=rentalProperty"]').classList.add("current-page");
    } else if (currentURL.includes("?index.php&action=typeNews&page=")) {
        document.querySelector('.navigation a[href="?act=typeNews"]').classList.add("current-page");
    } else if (currentURL.includes("?index.php&action=news&page=")) {
        document.querySelector('.navigation a[href="?act=news"]').classList.add("current-page");
    }
}
</script>
