<?php
require_once "./connectDB.php";
require_once "./message.php";
ob_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
$vndtousd = 24385;
$itemOnePage = 10;


 if(isset($_POST['save-property'])) {
  $propertie = $_POST['property_id'];
        if(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') {
              $currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
              $checkSaveProperty = mysqli_query($conn, "SELECT * FROM saved_properties WHERE userId = ".$_SESSION['user']['id']." AND propertyId = $propertie");
              if(mysqli_num_rows($checkSaveProperty) >0) {
                $deleteSaveProperty = mysqli_query($conn, "DELETE FROM saved_properties WHERE userId = ".$_SESSION['user']['id']." AND propertyId = $propertie");
                success('Đã bỏ lưu bất động sản!', $currentUrl);
  
              }else{
                $insertSaveProperty = mysqli_query($conn, "INSERT INTO saved_properties (userId, propertyId, createdAt) VALUES (".$_SESSION['user']['id'].", $propertie, NOW())");
                success('Đã lưu bất động sản!', $currentUrl);
  
              }
        }else{
            header("Location: index.php?act=login");
        }
    }
    if(isset($_POST['follow-broker'])) {
  $brokerId = $_POST['broker_id'];
        if(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') {
              $currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
              $checkFollowBroker = mysqli_query($conn, "SELECT * FROM follow_broker WHERE idUser = ".$_SESSION['user']['id']." AND idBroker = $brokerId");
              if(mysqli_num_rows($checkFollowBroker) >0) {
                $deleteFollowBroker = mysqli_query($conn, "DELETE FROM follow_broker WHERE idUser = ".$_SESSION['user']['id']." AND idBroker = $brokerId");
                success('Đã bỏ theo dõi môi giới!', $currentUrl);
              }else{
                $insertFollowBroker = mysqli_query($conn, "INSERT INTO follow_broker (idUser, idBroker) VALUES (".$_SESSION['user']['id'].", $brokerId)");
                success('Đã theo dõi môi giới!', $currentUrl);
  
              }
        }else{
            header("Location: index.php?act=login");
        }
    }

if (isset($_GET['act'])) {
  $act = $_GET['act'];
  switch ($act) {
    case 'home':
      include './controllers/homeController/index.php';
      break;
    case 'about':
      include './controllers/aboutController/index.php';
      break;
    case 'broker':
      include './controllers/brokerController/index.php';
      break;
    case 'changePassword':
      include './controllers/changePasswordController/index.php';
      break;
    case 'consultationRequest':
      include './controllers/consultationRequestController/index.php';
      break;
    case 'contact':
      include './controllers/contactController/index.php';
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
    case 'myProperty':
      include './controllers/myPropertyController/index.php';
      break;
    case 'addProperty':
      include './controllers/addPropertyController/index.php';
      break;
    case 'editProperty':
      include './controllers/editPropertyController/index.php';
      break;
    case 'contactRequest':
      include './controllers/contactRequestController/index.php';
      break;
     case 'editContactRequest':
      include './controllers/editContactRequestController/index.php';
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
