<?php
$_SESSION['limit'] = isset($_SESSION['limit']) ? $_SESSION['limit'] : 10;
$_SESSION['sort-property'] = isset($_SESSION['sort-property']) ? $_SESSION['sort-property'] : 'newest';
$_SESSION['search-property'] = isset($_SESSION['search-property']) ? $_SESSION['search-property'] : '';
$_SESSION['filter-type'] = isset($_SESSION['filter-type']) ? $_SESSION['filter-type'] : 0;
$_SESSION['filter-location'] = isset($_SESSION['filter-location']) ? $_SESSION['filter-location'] : 0;
$_SESSION['filter-minPrice'] = isset($_SESSION['filter-minPrice']) ? $_SESSION['filter-minPrice'] : 0;
$_SESSION['filter-maxPrice'] = isset($_SESSION['filter-maxPrice']) ? $_SESSION['filter-maxPrice'] : 0;
$_SESSION['filter-minArea'] = isset($_SESSION['filter-minArea']) ? $_SESSION['filter-minArea'] : 0;
$_SESSION['filter-maxArea'] = isset($_SESSION['filter-maxArea']) ? $_SESSION['filter-maxArea'] : 0;
$_SESSION['filter-bedrooms'] = isset($_SESSION['filter-bedrooms']) ? $_SESSION['filter-bedrooms'] : 0;
$_SESSION['filter-transactionType'] = isset($_SESSION['filter-transactionType']) ? $_SESSION['filter-transactionType'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['sort-property'])) {
        $_SESSION['sort-property'] = $_POST['sort-property'];
    }
    if (isset($_POST['search-property'])) {
        $_SESSION['search-property'] = $_POST['search-property'];
    }
    if (isset($_POST['filter-type'])) {
        $_SESSION['filter-type'] = (int)$_POST['filter-type'];
    }
    if (isset($_POST['filter-location'])) {
        $_SESSION['filter-location'] = (int)$_POST['filter-location'];
    }
    if (isset($_POST['filter-minPrice'])) {
        $_SESSION['filter-minPrice'] = (float)preg_replace('/[^\d]/', '', $_POST['filter-minPrice']);
    }
    if (isset($_POST['filter-maxPrice'])) {
        $_SESSION['filter-maxPrice'] = (float)preg_replace('/[^\d]/', '', $_POST['filter-maxPrice']);
    }
    if (isset($_POST['filter-minArea'])) {
        $_SESSION['filter-minArea'] = (float)$_POST['filter-minArea'];
    }
    if (isset($_POST['filter-maxArea'])) {
        $_SESSION['filter-maxArea'] = (float)$_POST['filter-maxArea'];
    }
    if (isset($_POST['filter-bedrooms'])) {
        $_SESSION['filter-bedrooms'] = (int)$_POST['filter-bedrooms'];
    }
    if (isset($_POST['filter-transactionType'])) {
        $_SESSION['filter-transactionType'] = $_POST['filter-transactionType'];
    }
    if (isset($_POST['clear-filter'])) {
        $_SESSION['sort-property'] = 'newest';
        $_SESSION['search-property'] = '';
        $_SESSION['filter-type'] = 0;
        $_SESSION['filter-location'] = 0;
        $_SESSION['filter-minPrice'] = 0;
        $_SESSION['filter-maxPrice'] = 0;
        $_SESSION['filter-minArea'] = 0;
        $_SESSION['filter-maxArea'] = 0;
        $_SESSION['filter-bedrooms'] = 0;
        $_SESSION['filter-transactionType'] = '';
    }

    header('Location: index.php?act=listProperty');
    exit();
}

if (isset($_GET['transactionType']) && in_array($_GET['transactionType'], ['rent', 'sale'])) {
    $_SESSION['filter-transactionType'] = $_GET['transactionType'];
}

$whereConditions = ["rp.status = 'active'"];
$whereConditions[] = "(l.status IS NULL OR l.status = 1)";
$whereConditions[] = "(a.status IS NULL OR a.status = 'active')";

if (!empty($_SESSION['search-property'])) {
    $searchTerm = $_SESSION['search-property'];
    $whereConditions[] = "rp.title LIKE '%$searchTerm%'";
}
if (!empty($_SESSION['filter-transactionType'])) {
    $whereConditions[] = "rp.transactionType = '" . $_SESSION['filter-transactionType'] . "'";
}
if ($_SESSION['filter-type'] > 0) {
    $whereConditions[] = "rp.typeId = " . $_SESSION['filter-type'];
}
if ($_SESSION['filter-location'] > 0) {
    $whereConditions[] = "rp.locationId = " . $_SESSION['filter-location'];
}
if ($_SESSION['filter-minPrice'] > 0) {
    $whereConditions[] = "rp.price >= " . $_SESSION['filter-minPrice'];
}
if ($_SESSION['filter-maxPrice'] > 0) {
    $whereConditions[] = "rp.price <= " . $_SESSION['filter-maxPrice'];
}
if ($_SESSION['filter-minArea'] > 0) {
    $whereConditions[] = "rp.area >= " . $_SESSION['filter-minArea'];
}
if ($_SESSION['filter-maxArea'] > 0) {
    $whereConditions[] = "rp.area <= " . $_SESSION['filter-maxArea'];
}
if ($_SESSION['filter-bedrooms'] > 0) {
    if ($_SESSION['filter-bedrooms'] >= 4) {
        $whereConditions[] = "rp.bedrooms >= " . $_SESSION['filter-bedrooms'];
    } else {
        $whereConditions[] = "rp.bedrooms = " . $_SESSION['filter-bedrooms'];
    }
}

$whereClause = implode(' AND ', $whereConditions);

$orderBy = "rp.createdAt DESC";
switch ($_SESSION['sort-property']) {
    case 'oldest':
        $orderBy = "rp.createdAt ASC";
        break;
    case 'price-low':
        $orderBy = "rp.price ASC, rp.createdAt DESC";
        break;
    case 'price-high':
        $orderBy = "rp.price DESC, rp.createdAt DESC";
        break;
    case 'area-small':
        $orderBy = "rp.area ASC, rp.createdAt DESC";
        break;
    case 'area-large':
        $orderBy = "rp.area DESC, rp.createdAt DESC";
        break;
}

$limit = $_SESSION['limit'];
$totalSql = "SELECT COUNT(DISTINCT rp.id) as total FROM rental_property rp 
             LEFT JOIN type_rental_property t ON rp.typeId = t.id
             LEFT JOIN location l ON rp.locationId = l.id
             LEFT JOIN broker b ON rp.brokerId = b.id
             LEFT JOIN account a ON b.accountId = a.id
             WHERE $whereClause";
$totalResult = mysqli_query($conn, $totalSql);
$totalRecords = 0;
if ($totalResult) {
    $row = mysqli_fetch_assoc($totalResult);
    $totalRecords = (int)$row['total'];
}
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$totalPage = ceil($totalRecords / $limit);
if ($currentPage > $totalPage && $totalPage > 0) {
    $currentPage = $totalPage;
}
if ($currentPage < 1) {
    $currentPage = 1;
}
$start = ($currentPage - 1) * $limit;

$sqlList = "SELECT rp.id, rp.title, rp.address, rp.price, rp.area, rp.bedrooms, rp.bathrooms, 
            rp.transactionType, rp.description, rp.createdAt, rp.updatedAt, rp.views,
            t.name as propertyType, l.name as locationName,
            a.fullName as brokerName, a.avatar as brokerAvatar, a.phoneNumber as brokerPhone,
            pi.imagePath as mainImage
            FROM rental_property rp
            LEFT JOIN type_rental_property t ON rp.typeId = t.id
            LEFT JOIN location l ON rp.locationId = l.id
            LEFT JOIN broker b ON rp.brokerId = b.id
            LEFT JOIN account a ON b.accountId = a.id
            LEFT JOIN property_images pi ON rp.id = pi.propertyId AND pi.isMain = 1
            WHERE $whereClause
            ORDER BY $orderBy
            LIMIT $start, $limit";

$listPropertiesResult = mysqli_query($conn, $sqlList);
$properties = [];
if ($listPropertiesResult) {
    $properties = mysqli_fetch_all($listPropertiesResult, MYSQLI_ASSOC);
}

$sqlLocations = "SELECT id, name FROM location WHERE status = 1 ORDER BY name ASC";
$resultLocations = mysqli_query($conn, $sqlLocations);
$locations = [];
if ($resultLocations) {
    $locations = mysqli_fetch_all($resultLocations, MYSQLI_ASSOC);
}
$sqlPropertyTypes = "SELECT id, name FROM type_rental_property";
$resultPropertyTypes = mysqli_query($conn, $sqlPropertyTypes);
$propertyTypes = [];
if ($resultPropertyTypes) {
    $propertyTypes = mysqli_fetch_all($resultPropertyTypes, MYSQLI_ASSOC);
}
include "./views/page/listProperty.php";
return;