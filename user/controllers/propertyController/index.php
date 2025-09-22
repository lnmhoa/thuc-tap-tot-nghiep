<?php
// Lấy ID bất động sản từ URL
$propertyId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($propertyId <= 0) {
    error('Thông tin bất động sản không hợp lệ!', 'index.php?act=listProperty');
    return;
}

// Lấy thông tin chi tiết bất động sản
$sql_property = "SELECT rp.*, t.name as propertyType, l.name as locationName, 
                 a.fullName as brokerName, a.avatar as brokerAvatar, a.phoneNumber as brokerPhone,
                 a.email as brokerEmail, b.shortIntro as brokerIntro
                 FROM rental_property rp
                 LEFT JOIN type_rental_property t ON rp.typeId = t.id
                 LEFT JOIN location l ON rp.locationId = l.id
                 LEFT JOIN broker b ON rp.brokerId = b.id
                 LEFT JOIN account a ON b.accountId = a.id
                 WHERE rp.id = $propertyId AND rp.status = 'active'";

$propertyResult = mysqli_query($conn, $sql_property);

if (!$propertyResult || mysqli_num_rows($propertyResult) == 0) {
    error('Không tìm thấy bất động sản!', 'index.php?act=listProperty');
    return;
}

$property = mysqli_fetch_assoc($propertyResult);

// Cập nhật lượt xem
$updateViews = "UPDATE rental_property SET views = views + 1 WHERE id = $propertyId";
mysqli_query($conn, $updateViews);

// Lấy hình ảnh của bất động sản
$sql_images = "SELECT * FROM property_images WHERE propertyId = $propertyId ORDER BY isMain DESC, sortOrder ASC";
$imagesResult = mysqli_query($conn, $sql_images);
$propertyImages = mysqli_fetch_all($imagesResult, MYSQLI_ASSOC);

// Lấy bất động sản liên quan (cùng loại, cùng khu vực)
$sql_related = "SELECT rp.*, t.name as propertyType, l.name as locationName,
                pi.imagePath as mainImage
                FROM rental_property rp
                LEFT JOIN type_rental_property t ON rp.typeId = t.id
                LEFT JOIN location l ON rp.locationId = l.id
                LEFT JOIN property_images pi ON rp.id = pi.propertyId AND pi.isMain = 1
                WHERE (rp.typeId = {$property['typeId']} OR rp.locationId = {$property['locationId']})
                AND rp.id != $propertyId AND rp.status = 'active'
                ORDER BY rp.createdAt DESC
                LIMIT 6";
$relatedResult = mysqli_query($conn, $sql_related);
$relatedProperties = mysqli_fetch_all($relatedResult, MYSQLI_ASSOC);

include "./views/page/propertyDetail.php";
return;