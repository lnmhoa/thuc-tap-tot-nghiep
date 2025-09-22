<?php

$limit = 4;

$_SESSION['sort-rental-property-admin'] = $_SESSION['sort-rental-property-admin'] ?? 'desc';
$_SESSION['sort-status-rental-property-admin'] = $_SESSION['sort-status-rental-property-admin'] ?? '2';
$_SESSION['sort-rental-property-location-admin'] = $_SESSION['sort-rental-property-location-admin'] ?? 'all';
$_SESSION['sort-rental-property-expertises-admin'] = $_SESSION['sort-rental-property-expertises-admin'] ?? 'all';
if (isset($_POST['sort-rental-property-admin'])) {
  $_SESSION['sort-rental-property-admin'] = $_POST['sort-rental-property-admin'];
}
if (isset($_POST['sort-rental-property-location-admin'])) {
  $_SESSION['sort-rental-property-location-admin'] = $_POST['sort-rental-property-location-admin'];
}
if (isset($_POST['sort-rental-property-expertises-admin'])) {
  $_SESSION['sort-rental-property-expertises-admin'] = $_POST['sort-rental-property-expertises-admin'];
}
if (isset($_POST['sort-status-rental-property-admin'])) {
  $_SESSION['sort-status-rental-property-admin'] = $_POST['sort-status-rental-property-admin'];
}

$where_clauses = ["p.status = 'active'"];

if ($_SESSION['sort-rental-property-location-admin'] != 'all') {
  $where_clauses[] = "p.locationId = " . (int)$_SESSION['sort-rental-property-location-admin'];
}

if ($_SESSION['sort-rental-property-expertises-admin'] != 'all') {
  $where_clauses[] = "p.typeId = " . (int)$_SESSION['sort-rental-property-expertises-admin'];
}

$where_sql = count($where_clauses) > 0 ? "WHERE " . implode(" AND ", $where_clauses) : "";

$total_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM `rental_property` AS p " . $where_sql);
$total_row = mysqli_fetch_assoc($total_query);
$total = $total_row['total'];

$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$total_page = ceil($total / $limit);
if ($current_page > $total_page) {
  $current_page = $total_page;
}
if ($current_page < 1) {
  $current_page = 1;
}
$start = ($current_page - 1) * $limit;

$sql_location = "SELECT id, name FROM `location`";
$listLocationResult = mysqli_query($conn, $sql_location);
$sql_expertises = "SELECT id, name FROM `expertises`";
$listExpertisesResult = mysqli_query($conn, $sql_expertises);
$sql_property_amenities = "SELECT * FROM `property_amenities`";
$listPropertyAmenitiesResult = mysqli_query($conn, $sql_property_amenities);

$sql_list = "
SELECT
    p.id,
    p.title,
    p.address,
    p.transactionType,
    p.price,
    p.priceUnit,
    p.area,
    p.bedrooms,
    p.bathrooms,
    p.floors,
    p.frontage,
    p.direction,
    p.legalStatus,
    p.furniture,
    p.views,
    p.status,
    p.createdAt,
    p.updatedAt,
    tp.name AS property_type_name,
    l.name AS location_name,
    a.fullName AS broker_name,
    a.avatar AS broker_avatar,
    GROUP_CONCAT(
        JSON_OBJECT(
            'imagePath', pi.imagePath,
            'isMain', pi.isMain,
            'sortOrder', pi.sortOrder
        )
        ORDER BY pi.sortOrder ASC
    ) AS images
FROM
    rental_property AS p
LEFT JOIN
    type_rental_property AS tp ON p.typeId = tp.id
LEFT JOIN
    location AS l ON p.locationId = l.id
LEFT JOIN
    broker AS b ON p.brokerId = b.id
LEFT JOIN
    account AS a ON b.accountId = a.id
LEFT JOIN
    property_images AS pi ON p.id = pi.propertyId
{$where_sql}
GROUP BY
    p.id
ORDER BY
    p.createdAt " . $_SESSION['sort-rental-property-admin'] . " 
LIMIT $start, $limit;
";

$listRentalPropertyResult = mysqli_query($conn, $sql_list);

if ($listRentalPropertyResult) {
  $listLocation = mysqli_fetch_all($listLocationResult, MYSQLI_ASSOC);
  $listExpertises = mysqli_fetch_all($listExpertisesResult, MYSQLI_ASSOC);
  $listPropertyAmenities = mysqli_fetch_all($listPropertyAmenitiesResult, MYSQLI_ASSOC);
  $listRentalProperty = mysqli_fetch_all($listRentalPropertyResult, MYSQLI_ASSOC);
} else {
  error('Lấy thông tin tin tức thất bại!', 'index.php?act=rentalProperty');
}

include "./views/page/rentalProperty.php";
return;
