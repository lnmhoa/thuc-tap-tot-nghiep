<?php

// Validate và sanitize input parameters
function validateTransactionType($value) {
    return in_array($value, ['rent', 'sale']) ? $value : '';
}

function validateInteger($value) {
    return is_numeric($value) && $value > 0 ? intval($value) : 0;
}

function validatePrice($value) {
    if (empty($value)) return 0;
    // Remove formatting characters
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

// Initialize filters
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

// Validate ranges - swap min/max if needed
if ($filters['minPrice'] > 0 && $filters['maxPrice'] > 0 && 
    $filters['minPrice'] > $filters['maxPrice']) {
    [$filters['minPrice'], $filters['maxPrice']] = 
    [$filters['maxPrice'], $filters['minPrice']];
}

if ($filters['minArea'] > 0 && $filters['maxArea'] > 0 && 
    $filters['minArea'] > $filters['maxArea']) {
    [$filters['minArea'], $filters['maxArea']] = 
    [$filters['maxArea'], $filters['minArea']];
}

// Initialize pagination
$limit = 12;
$page = max(1, intval($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

// Build WHERE clause
$whereClauses = ["rp.status = 'active'"];

// Add additional filters for related tables
$whereClauses[] = "(t.status IS NULL OR t.status = 'active')";
$whereClauses[] = "(l.status IS NULL OR l.status = 1)";
$whereClauses[] = "(a.status IS NULL OR a.status = 'active')";

$whereParams = [];

// Transaction type filter
if (!empty($filters['transactionType'])) {
    $whereClauses[] = "rp.transactionType = '" . mysqli_real_escape_string($conn, $filters['transactionType']) . "'";
}

// Property type filter
if ($filters['propertyType'] > 0) {
    $whereClauses[] = "rp.typeId = " . $filters['propertyType'];
}

// Location filter
if ($filters['locationId'] > 0) {
    $whereClauses[] = "rp.locationId = " . $filters['locationId'];
}

// Price range filters
if ($filters['minPrice'] > 0) {
    $whereClauses[] = "rp.price >= " . $filters['minPrice'];
}

if ($filters['maxPrice'] > 0) {
    $whereClauses[] = "rp.price <= " . $filters['maxPrice'];
}

// Area range filters
if ($filters['minArea'] > 0) {
    $whereClauses[] = "rp.area >= " . $filters['minArea'];
}

if ($filters['maxArea'] > 0) {
    $whereClauses[] = "rp.area <= " . $filters['maxArea'];
}

// Bedrooms filter
if ($filters['bedrooms'] > 0) {
    if ($filters['bedrooms'] >= 4) {
        $whereClauses[] = "rp.bedrooms >= " . $filters['bedrooms'];
    } else {
        $whereClauses[] = "rp.bedrooms = " . $filters['bedrooms'];
    }
}

// Search filter
if (!empty($filters['search'])) {
    $searchTerm = mysqli_real_escape_string($conn, $filters['search']);
    $whereClauses[] = "(rp.title LIKE '%$searchTerm%' OR rp.address LIKE '%$searchTerm%' OR rp.description LIKE '%$searchTerm%')";
}

$whereClause = implode(' AND ', $whereClauses);

// Order by clause
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

// Debug: Test simple query first
$debug_sql = "SELECT COUNT(*) as total FROM rental_property WHERE status = 'active'";
$debug_result = mysqli_query($conn, $debug_sql);
if ($debug_result) {
    $debug_row = mysqli_fetch_assoc($debug_result);
    error_log("DEBUG: Found " . $debug_row['total'] . " active properties");
}

// Get properties
$sql_properties = "SELECT rp.id, rp.title, rp.address, rp.price, rp.area, rp.bedrooms, rp.bathrooms, 
                          rp.transactionType, rp.description, rp.createdAt, rp.updatedAt,
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

error_log("DEBUG: SQL Query: " . $sql_properties);

$result_properties = mysqli_query($conn, $sql_properties);
$properties = [];
if ($result_properties) {
    $properties = mysqli_fetch_all($result_properties, MYSQLI_ASSOC);
    error_log("DEBUG: Found " . count($properties) . " properties");
} else {
    error_log("DEBUG: Properties query error: " . mysqli_error($conn));
    
    // Fallback: Try simple query
    $fallback_sql = "SELECT rp.id, rp.title, rp.address, rp.price, rp.area, rp.bedrooms, rp.bathrooms, 
                            rp.transactionType, rp.description, rp.createdAt, rp.updatedAt,
                            'N/A' as propertyType, 'N/A' as locationName, 'N/A' as brokerName,
                            NULL as brokerAvatar, NULL as brokerPhone, NULL as mainImage
                     FROM rental_property rp
                     WHERE rp.status = 'active'
                     ORDER BY rp.createdAt DESC
                     LIMIT $limit OFFSET $offset";
    
    $fallback_result = mysqli_query($conn, $fallback_sql);
    if ($fallback_result) {
        $properties = mysqli_fetch_all($fallback_result, MYSQLI_ASSOC);
        error_log("DEBUG: Fallback query found " . count($properties) . " properties");
    }
}

// Get total count
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

// Get property types
$sql_types = "SELECT id, name FROM type_rental_property WHERE status = 'active' ORDER BY name ASC";
$result_types = mysqli_query($conn, $sql_types);
$propertyTypes = [];
if ($result_types) {
    $propertyTypes = mysqli_fetch_all($result_types, MYSQLI_ASSOC);
}

// Get locations
$sql_locations = "SELECT id, name FROM location WHERE status = 1 ORDER BY name ASC";
$result_locations = mysqli_query($conn, $sql_locations);
$locations = [];
if ($result_locations) {
    $locations = mysqli_fetch_all($result_locations, MYSQLI_ASSOC);
}

// Calculate stats
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

// For compatibility with view
$page = $currentPage;

error_log("DEBUG: Total properties: $total, Current page: $currentPage, Total pages: $totalPages");

// Include view
include "./views/page/listProperty.php";
return;
