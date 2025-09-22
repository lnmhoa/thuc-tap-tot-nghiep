<?php
include_once "../../connectDB.php";

// Lấy id bất động sản từ URL
$property_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($property_id <= 0) {
    echo "Không tìm thấy bất động sản!";
    exit;
}

// Lấy thông tin bất động sản
$sql = "SELECT * FROM property WHERE id = $property_id";
$result = mysqli_query($conn, $sql);
$property = mysqli_fetch_assoc($result);
if (!$property) {
    echo "Không tìm thấy bất động sản!";
    exit;
}

// Hiển thị view
include "../../views/page/propertyDetail.php";
return;
