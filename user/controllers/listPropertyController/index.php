<?php

function validateTransactionType($value) {
    return in_array($value, ['rent', 'sale']) ? $value : '';
}
function validateInteger($value) {
    return is_numeric($value) && $value > 0 ? intval($value) : 0;
}
function validatePrice($value) {
    if (empty($value)) return 0;
    $cleanValue = preg_replace('/[^\d]/', '', $value);
    return floatval($cleanValue);
}
function validateArea($value) {
    return is_numeric($value) && $value > 0 ? floatval($value) : 0;
}
function validateSortBy($value) {
    $allowed = ['newest', 'oldest', 'price-low', 'price-high', 'area-small', 'area-large'];
    return in_array($value, $allowed) ? $value : 'newest';
}
function validateSearch($value) {
    return trim(strip_tags($value));
}

$filters = [
    'transactionType' => validateTransactionType($_GET['transactionType'] ?? ''),
    'propertyType' => validateInteger($_GET['propertyType'] ?? 0),
    'locationId' => validateInteger($_GET['locationId'] ?? 0),
    'minPrice' => validatePrice($_GET['minPrice'] ?? ''),
    'maxPrice' => validatePrice($_GET['maxPrice'] ?? ''),
    'minArea' => validateArea($_GET['minArea'] ?? ''),
    'maxArea' => validateArea($_GET['maxArea'] ?? ''),
    'bedrooms' => validateInteger($_GET['bedrooms'] ?? 0),
    'sortBy' => validateSortBy($_GET['sortBy'] ?? 'newest'),
    'search' => validateSearch($_GET['search'] ?? '')
];
$limit = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$whereClauses = ["rp.status = 'active'"];
$whereClauses[] = "(l.status IS NULL OR l.status = 1)";
$whereClauses[] = "(a.status IS NULL OR a.status = 'active')";
if (!empty($filters['transactionType'])) {
    $whereClauses[] = "rp.transactionType = '" . $filters['transactionType'] . "'";
}
if ($filters['propertyType'] > 0) {
    $whereClauses[] = "rp.typeId = " . $filters['propertyType'];
}
if ($filters['locationId'] > 0) {
    $whereClauses[] = "rp.locationId = " . $filters['locationId'];
}
if ($filters['minPrice'] > 0) {
    $whereClauses[] = "rp.price >= " . $filters['minPrice'];
}
if ($filters['maxPrice'] > 0) {
    $whereClauses[] = "rp.price <= " . $filters['maxPrice'];
}
if ($filters['minArea'] > 0) {
    $whereClauses[] = "rp.area >= " . $filters['minArea'];
}
if ($filters['maxArea'] > 0) {
    $whereClauses[] = "rp.area <= " . $filters['maxArea'];
}
if ($filters['bedrooms'] > 0) {
    if ($filters['bedrooms'] >= 4) {
        $whereClauses[] = "rp.bedrooms >= " . $filters['bedrooms'];
    } else {
        $whereClauses[] = "rp.bedrooms = " . $filters['bedrooms'];
    }
}
if (!empty($filters['search'])) {
    $searchTerm = $filters['search'];
    $whereClauses[] = "rp.title LIKE '%$searchTerm%'";
}
$whereClause = implode(' AND ', $whereClauses);

$orderBy = "rp.createdAt DESC";
switch ($filters['sortBy']) {
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

$sql_properties = "SELECT rp.id, rp.title, rp.address, rp.price, rp.area, rp.bedrooms, rp.bathrooms, 
                            rp.transactionType, rp.description, rp.createdAt, rp.updatedAt, rp.views,
                            t.name as propertyType, 
                            l.name as locationName,
                            a.fullName as brokerName, 
                            a.avatar as brokerAvatar, a.phoneNumber as brokerPhone,
                            pi.imagePath as mainImage
                    FROM rental_property rp
                    LEFT JOIN type_rental_property t ON rp.typeId = t.id
                    LEFT JOIN location l ON rp.locationId = l.id
                    LEFT JOIN broker b ON rp.brokerId = b.id
                    LEFT JOIN account a ON b.accountId = a.id
                    LEFT JOIN property_images pi ON rp.id = pi.propertyId AND pi.isMain = 1
                    WHERE $whereClause
                    ORDER BY $orderBy
                    LIMIT $limit OFFSET $offset";

$result_properties = mysqli_query($conn, $sql_properties);
$properties = [];
if ($result_properties) {
    $properties = mysqli_fetch_all($result_properties, MYSQLI_ASSOC);
}

$sql_count = "SELECT COUNT(DISTINCT rp.id) as total 
              FROM rental_property rp
              LEFT JOIN type_rental_property t ON rp.typeId = t.id
              LEFT JOIN location l ON rp.locationId = l.id
              LEFT JOIN broker b ON rp.brokerId = b.id
              LEFT JOIN account a ON b.accountId = a.id
              WHERE $whereClause";

$result_count = mysqli_query($conn, $sql_count);
$total = 0;
if ($result_count) {
    $row = mysqli_fetch_assoc($result_count);
    $total = intval($row['total']);
}

$sql_locations = "SELECT id, name FROM location WHERE status = 1 ORDER BY name ASC";
$result_locations = mysqli_query($conn, $sql_locations);
$locations = [];
if ($result_locations) {
    $locations = mysqli_fetch_all($result_locations, MYSQLI_ASSOC);
}

$totalPages = ceil($total / $limit);
$currentPage = $page;
$stats = [
    'total' => $total,
    'current_showing' => count($properties),
    'page_start' => $offset + 1,
    'page_end' => min($offset + $limit, $total),
    'current_page' => $currentPage,
    'total_pages' => $totalPages
];
$page = $currentPage;
include "./views/page/listProperty.php";
return;