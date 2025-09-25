<?php
if (!isset($property)) {
    echo "Không tìm thấy thông tin bất động sản!";
    return;
}
?>
<section class="property-detail">
    <div class="container">
         <section class="page-header">
            <div class="breadcrumb">
              <a href="index.php">Trang chủ</a>
            <span>/</span>
           <a href="index.php?act=property">Bất động sản</a>
            <span>/</span>
            <span><?= htmlspecialchars($property['title']) ?></span>
        </div>
        </section>
       <div style="padding: 0 15px 10px 15px; margin-bottom: 20px;">
         
        <div class="property-header">
            <h1><?= htmlspecialchars($property['title']) ?></h1>
        </div>
 
        <div class="property-content">
            <div class="property-main">
                <div class="property-images">
    <?php if (!empty($propertyImages)): ?>
        <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2">
            <div class="swiper-wrapper">
                <?php foreach ($propertyImages as $image): ?>
                    <div class="swiper-slide">
                        <img src="<?= htmlspecialchars($image['imagePath']) ?>" alt="<?= htmlspecialchars($property['title']) ?>" />
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <div thumbsSlider="" class="swiper mySwiper" style="width: 738px; !imortant"> 
            <div class="swiper-wrapper">
                <?php foreach ($propertyImages as $image): ?>
                    <div class="swiper-slide">
                        <img src="<?= htmlspecialchars($image['imagePath']) ?>" alt="<?= htmlspecialchars($property['title']) ?>" />
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="main-image">
            <img src="placeholder.svg" alt="<?= htmlspecialchars($property['title']) ?>">
        </div>
    <?php endif; ?>
</div>

                <div class="property-info">
                    <div class="price-section">
                        <h2 class="price">
                            <?= number_format($property['price'], 0, ',', '.') ?> VNĐ
                            <?= $property['transactionType'] === 'rent' ? '/tháng' : '' ?>
                        </h2>
                    </div>

                    <div class="details-grid">
                        <div class="detail-item">
                            <strong>Diện tích:</strong>
                            <span><?= $property['area'] ?? 'N/A' ?> m²</span>
                        </div>
                        <?php if ($property['bedrooms'] > 0): ?>
                            <div class="detail-item">
                                <strong>Phòng ngủ:</strong>
                                <span><?= $property['bedrooms'] ?> phòng</span>
                            </div>
                        <?php endif; ?>
                        <?php if ($property['bathrooms'] > 0): ?>
                            <div class="detail-item">
                                <strong>Phòng tắm:</strong>
                                <span><?= $property['bathrooms'] ?> phòng</span>
                            </div>
                        <?php endif; ?>
                        <?php if ($property['floors'] > 0): ?>
                            <div class="detail-item">
                                <strong>Số tầng:</strong>
                                <span><?= $property['floors'] ?> tầng</span>
                            </div>
                        <?php endif; ?>
                        <div class="detail-item">
                            <strong>Loại hình:</strong>
                            <span><?= htmlspecialchars($property['propertyType']) ?></span>
                        </div>
                        <div class="detail-item">
                            <strong>Khu vực:</strong>
                            <span><?= htmlspecialchars($property['locationName']) ?></span>
                        </div>
                         <div class="detail-item">
                            <strong>ĐC:</strong>
                            <span><?= htmlspecialchars($property['address']) ?></span>
                        </div>
                         <div class="detail-item">
                            <strong>Loại hình:</strong>
                            <span>  <?= $property['transactionType'] === 'sale' ? 'Bán' : 'Cho thuê' ?></span>
                        </div>
                    </div>
                    <?php if (!empty($property['description'])): ?>
                        <div class="description">
                            <h3>Mô tả chi tiết</h3>
                            <div class="description-content">
                                <?= nl2br(htmlspecialchars($property['description'])) ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="property-sidebar">
                <div class="broker-card">
                    <div class="broker-info">
                        
                            <img src="<?= htmlspecialchars($property['brokerAvatar']) ?>" 
                                 alt="<?= htmlspecialchars($property['brokerName']) ?>" 
                                 class="broker-avatar">
                        <div class="broker-details">
                            <h4><a href="index.php?act=broker&id=<?= $property['brokerId'] ?>"><?= htmlspecialchars($property['brokerName']) ?></a></h4>
                            <?php if (!empty($property['brokerIntro'])): ?>
                                <p><?= htmlspecialchars($property['brokerIntro']) ?></p>
                            <?php endif; ?>
                            <div class="broker-contact">
                                    <?php if(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') { ?>
                                    <span><?= htmlspecialchars($property['brokerPhone']) ?></span>
                                    <?php } else { ?>
                                   <span><?= substr($property['brokerPhone'], 0 , 7) ?>***</span>
                                    <?php } ?>
                                <?php if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') { ?>
                                    <p><i class="fas fa-envelope"></i> <?= htmlspecialchars($property['brokerEmail']) ?></p>
                                <?php }else{ ?>
                                    <p><i class="fas fa-envelope"></i>****@***.***</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary contact-btn" onclick="window.location.href='index.php?act=broker&id=<?= $property['brokerId'] ?>'">Liên hệ ngay</button>
                </div>

                <div class="quick-actions">
                <?php if(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') { ?>
                     <form action="" method="post" style="display: inline;">
                            <input type="hidden" name="property_id" value="<?= $property['id'] ?>">
                            <button type="submit" name="save-property" class="btn <?= $property['isSaved'] ? 'btn-success' : 'btn-outline' ?> save-property" title="<?= $property['isSaved'] ? 'Đã lưu - Click để bỏ lưu' : 'Lưu tin' ?>">
                                <i class="<?= $property['isSaved'] ? 'fas fa-heart' : 'far fa-heart' ?>"></i> <?= $property['isSaved'] ? 'Đã lưu' : 'Lưu tin' ?>
                            </button>
                        </form>
                        
                    <?php } else { ?>
                    <button class="btn btn-outline save-property" onclick="alert('Vui lòng đăng nhập để sử dụng chức năng này!')">
                        <i class="far fa-heart"></i> Lưu tin
                    </button>
                    <?php } ?>
                    <button class="btn btn-outline share-property">
                        <i class="fas fa-share"></i> Chia sẻ
                    </button>
                </div>
            </div>
        </div>

        <?php if (!empty($relatedProperties)): ?>
            <div class="related-properties">
                <h2>Bất động sản liên quan</h2>
                <div class="properties-grid">
                    <?php foreach (array_slice($relatedProperties, 0, 4) as $item): ?>
                        <div class="property-card">
                            <div class="property-image">
                                <img src="<?= !empty($item['mainImage']) ? $item['mainImage'] : 'placeholder.svg' ?>" 
                                     alt="<?= htmlspecialchars($item['title']) ?>">
                                <div class="property-badge<?= $item['transactionType']==='sale' ? ' sale' : '' ?>">
                                    <?= $item['transactionType']==='sale' ? 'Bán' : 'Cho thuê' ?>
                                </div>
                            </div>
                            <div class="property-info">
                                <h3><a href="index.php?act=property&id=<?= $item['id'] ?>">
                                    <?= htmlspecialchars($item['title']) ?>
                                </a></h3>
                                <p class="location"><?= htmlspecialchars($item['locationName']) ?></p>
                                <p class="price">
                                    <?= number_format($item['price'], 0, ',', '.') ?> VNĐ
                                    <?= $item['transactionType'] === 'rent' ? '/tháng' : '' ?>
                                </p>
                                <div class="property-features">
                                    <span><?= $item['area'] ?? 0 ?> m²</span>
                                    <?php if ($item['bedrooms'] > 0): ?>
                                        | <span><?= $item['bedrooms'] ?> PN</span>
                                    <?php endif; ?>
                                    <?php if ($item['bathrooms'] > 0): ?>
                                        | <span><?= $item['bathrooms'] ?> WC</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
       </div>
    </div>
</section>
 <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <script>
    var swiper = new Swiper(".mySwiper", {
      spaceBetween: 10,
      slidesPerView: 4,
      freeMode: true,
      watchSlidesProgress: true,
    });
    var swiper2 = new Swiper(".mySwiper2", {
      spaceBetween: 10,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      thumbs: {
        swiper: swiper,
      },
    });
  </script>