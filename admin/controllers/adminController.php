<?php
require_once "./connectDB.php";
require_once "./message.php";
ob_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
$vndtousd = 24385;
$itemOnePage = 10;
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 3){
  header('Location: http://localhost/thuc-tap-tot-nghiep/user/');
  exit();
}
if(isset($_POST['logout'])){
  session_destroy();
  success('Đăng xuất thành công!', 'http://localhost/thuc-tap-tot-nghiep/user/');
  exit();
}
if (isset($_GET['act'])) {
  $act = $_GET['act'];
  switch ($act) {
    case 'dashboard':
      include './controllers/dashBoardController/index.php';
      break;
    case 'account':
      include './controllers/accountController/index.php';
      break;
    case 'broker':
      include './controllers/brokerController/index.php';
      break;
    case 'rentalProperty':
      include './controllers/rentalPropertyController/index.php';
      break;
       case 'typeNews':
      include './controllers/typeNewsController/index.php';
      break;
    case 'news':
      include './controllers/newsController/index.php';
      break;
    case 'contact':
      include './controllers/contactController/index.php';
      break;
    default:
      include './controllers/dashBoardController/index.php';
  }
} else {
  include './controllers/dashBoardController/index.php';
}
