<?php
require_once "./connectDB.php";
require_once "./message.php";
ob_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
$vndtousd = 24385;
$itemOnePage = 10;

// Hàm hiển thị thời gian tương đối
function timeAgo($datetime) {
    $time = time() - strtotime($datetime);
    $time = ($time < 1) ? 1 : $time;
    $tokens = array (
        31536000 => 'năm',
        2592000 => 'tháng',
        604800 => 'tuần',
        86400 => 'ngày',
        3600 => 'giờ',
        60 => 'phút',
        1 => 'giây'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.' trước';
    }
    return 'vừa xong';
}

// if (!isset($_SESSION['user']) || $_SESSION['user']['loai'] != '3') {
//     header("Location: http://localhost/DA1/display/index.php");
//     exit();
// } else {
if (isset($_GET['act'])) {
  $act = $_GET['act'];
  switch ($act) {
    case 'home':
      include './controllers/homeController/index.php';
      break;
    case 'about':
      include './controllers/aboutController/index.php';
      break;
    case 'addProperty':
      include './controllers/addPropertyController/index.php';
      break;
    case 'broker':
      include './controllers/brokerController/index.php';
      break;
    case 'brokerProperty':
      include './controllers/brokerPropertyController/index.php';
      break;
    case 'changePassword':
      include './controllers/changePasswordController/index.php';
      break;
    case 'consultationRequest':
      include './controllers/consultationRequestController/index.php';
      break;
    case 'followBroker':
      include './controllers/followBrokerController/index.php';
      break;
    case 'news':
      include './controllers/newsController/index.php';
      break;
    case 'listProperty':
      include './controllers/listPropertyController/index.php';
      break;
    case 'listBroker':
      include './controllers/listBrokerController/index.php';
      break;
    case 'listNews':
      include './controllers/listNewsController/index.php';
      break;
    case 'profile':
      include './controllers/profileController/index.php';
      break;
    case 'property':
      include './controllers/propertyController/index.php';
      break;
    case 'review':
      include './controllers/reviewController/index.php';
      break;
    case 'saveProperty':
      include './controllers/savePropertyController/index.php';
      break;
    case 'userRentals':
      include './controllers/userRentalsController/index.php';
      break;
    case 'register':
      include './controllers/registerController/index.php';
      break;
    case 'login':
      include './controllers/loginController/index.php';
      break;
       case 'logout':
      include './controllers/logoutController/index.php';
      break;
    default:
      include './controllers/homeController/index.php';
  }
} else {
  include './controllers/homeController/index.php';
}
// }
