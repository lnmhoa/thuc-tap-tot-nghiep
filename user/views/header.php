<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-HOME - Trang chủ</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="./views/css/index.css">
    <link rel="stylesheet" href="./views/css/home.css">
    <link rel="stylesheet" href="./views/css/header.css">
    <link rel="stylesheet" href="./views/css/footer.css">
    <link rel="stylesheet" href="./views/css/brokerDetail.css">
    <link rel="stylesheet" href="./views/css/broker.css">
    <link rel="stylesheet" href="./views/css/news.css">
    <link rel="stylesheet" href="./views/css/newsDetail.css">
    <link rel="stylesheet" href="./views/css/user-profile.css">
    <link rel="stylesheet" href="./views/css/properties.css">
    <link rel="stylesheet" href="./views/css/propertyDetail.css">
    <link rel="stylesheet" href="./views/css/addProperty.css">
    <link rel="stylesheet" href="./views/css/brokerProperty.css">
    <link rel="stylesheet" href="./views/css/consultationRequest.css">
    <link rel="stylesheet" href="./views/css/auth.css">
    <link rel="stylesheet" href="./views/css/about.css">
    <link rel="stylesheet" href="./views/css/contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.28/sweetalert2.all.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.28/sweetalert2.css">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div style="display: flex; gap: 20px; align-items: center;">
                    <div class="logo" style="line-height: 1;">
                        <img src="../uploads/system/logo.jpg" alt="logo" onclick="window.location.href='index.php'" style="cursor: pointer;">
                    </div>
                    <nav class="nav">
                        <ul>
                            <li><a href="index.php">Trang chủ</a></li>
                            <li><a href="?act=listProperty">Bất động sản</a></li>
                            <li><a href="?act=listBroker">Môi giới</a></li>
                            <li><a href="?act=listNews">Tin tức</a></li>
                            <li><a href="?act=contact">Tư vấn</a></li>
                            <li><a href="?act=about">Giới thiệu</a></li>
                        </ul>
                    </nav>
                </div>
                <?php if(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') { ?>
                    <div class="user-menu">
                        <div class="dropdown">
                            <button class="dropdown-btn">
                                <i class="fas fa-user"></i>
                                <?php echo htmlspecialchars($_SESSION['user']['fullName'] ?? $_SESSION['user']['fullName'] ?? 'Người dùng'); ?>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="dropdown-content">
                                <a href="?act=profile"><i class="fas fa-user-circle"></i> Hồ sơ cá nhân</a>

                                <?php if(isset($_SESSION['user']['role']) && ($_SESSION['user']['role'] == '2' )): ?>
                                    <a href="?act=brokerProperty"><i class="fas fa-building"></i> BĐS của tôi</a>
                                    <a href="?act=addProperty"><i class="fas fa-plus-circle"></i> Đăng tin mới</a>
                                <?php endif; ?>
                                
                                <a href="?act=saveProperty"><i class="fas fa-heart"></i> BĐS đã lưu</a>
                                <a href="?act=consultationRequest"><i class="fas fa-headset"></i> Yêu cầu tư vấn</a>
                                <a href="?act=changePassword"><i class="fas fa-key"></i> Đổi mật khẩu</a>
                                <a href="?act=logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div onclick="window.location.href='?act=login'" class="login-btn">
                        Đăng nhập
                    </div>
                <?php } ?>
            </div>
        </div>
    </header>
