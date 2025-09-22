<?php ?>
<main class="news-detail">
    <div class="container">
        <section class="page-header" style="background: none; border: none; margin: 15px 0;">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.php">Trang chủ</a>
                    <span>/</span>
                    <a href="index.php?act=listNews">Tin tức</a>
                    <span>/</span>
                    <span><?= htmlspecialchars($newsDetail['title']) ?></span>
                </div>
            </div>
        </section>
        <div class="news-detail-layout">
            <article class="news-article">
                <header class="article-header">
                    <div class="article-category">
                        <span class="category-tag"><?= htmlspecialchars($newsDetail['typeName']) ?></span>
                    </div>
                    <h1><?= htmlspecialchars($newsDetail['title']) ?></h1>
                    <div class="article-meta">
                        <div class="author-info">
                            <img src="/placeholder.svg?height=40&width=40" alt="Tác giả">
                            <div class="author-details">
                                <span class="author-name">Admin</span>
                                <span class="author-title">Chuyên gia BĐS</span>
                            </div>
                        </div>
                        <div class="article-stats">
                            <span><i class="fas fa-calendar"></i>
                                <?= date('d/m/Y', strtotime($newsDetail['createdAt'])) ?></span>
                            <span><i class="fas fa-clock"></i> 5 phút đọc</span>
                            <span><i class="fas fa-eye"></i> <?= number_format($newsDetail['views']) ?> lượt xem</span>
                        </div>
                    </div>
                    <div class="article-actions">
                        <?php
                        // Tạo URL đầy đủ của trang hiện tại
                        $currentUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                        $shareTitle = urlencode($newsDetail['title']);
                        $shareUrl = urlencode($currentUrl);
                        ?>
                        <button class="share-btn" onclick="shareToFacebook('<?= $shareUrl ?>', '<?= $shareTitle ?>')">
                            <i class="fas fa-share"></i>
                            Chia sẻ
                        </button>
                        <button class="bookmark-btn">
                            <i class="far fa-bookmark"></i>
                            Lưu tin
                        </button>
                    </div>
                </header>

                <?php if (!empty($newsDetail['image'])) { ?>
                    <div class="article-image">
                        <img src="<?= htmlspecialchars($newsDetail['image']) ?>"
                            alt="<?= htmlspecialchars($newsDetail['title']) ?>">
                        <p class="image-caption"><?= htmlspecialchars($newsDetail['title']) ?></p>
                    </div>
                <?php } ?>

                <div class="article-content">
                    <?= $newsDetail['content'] ?>
                </div>

                <div class="article-share">
                    <h4>Chia sẻ bài viết:</h4>
                    <div class="share-buttons">
                        <button class="share-btn facebook"
                            onclick="shareToFacebook('<?= $shareUrl ?>', '<?= $shareTitle ?>')">
                            <i class="fab fa-facebook-f"></i>
                            Facebook
                        </button>
                        <button class="share-btn twitter"
                            onclick="shareToTwitter('<?= $shareUrl ?>', '<?= $shareTitle ?>')">
                            <i class="fab fa-twitter"></i>
                            Twitter
                        </button>
                        <button class="share-btn linkedin"
                            onclick="shareToLinkedIn('<?= $shareUrl ?>', '<?= $shareTitle ?>')">
                            <i class="fab fa-linkedin-in"></i>
                            LinkedIn
                        </button>
                        <button class="share-btn zalo" onclick="shareToZalo('<?= $shareUrl ?>', '<?= $shareTitle ?>')">
                            <i class="fab fa-zalo"></i>
                            Zalo
                        </button>
                        <button class="share-btn copy" onclick="copyToClipboard('<?= $currentUrl ?>')">
                            <i class="fas fa-copy"></i>
                            Copy Link
                        </button>
                    </div>
                </div>
            </article>

            <aside class="news-sidebar">
                <div class="popular-categories">
                    <h3>Danh mục phổ biến</h3>
                    <div class="categories-list">
                        <?php foreach ($popularCategories as $category) { ?>
                            <a href="index.php?act=listNews&category=<?= $category['id'] ?>" class="category-item">
                                <span><?= htmlspecialchars($category['name']) ?></span>
                                <span class="count"><?= $category['news_count'] ?></span>
                            </a>
                        <?php } ?>
                    </div>
                </div>

                <div class="newsletter-signup">
                    <h3>Đăng ký nhận tin</h3>
                    <p>Nhận tin tức BĐS mới nhất qua email</p>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Nhập email của bạn" required>
                        <button type="submit" class="btn btn-primary">Đăng ký</button>
                    </form>
                </div>
            </aside>
        </div>

        <!-- Similar News -->
        <?php if (!empty($similarNews)) { ?>
            <section class="similar-news">
                <h2>Tin tức cùng thể loại</h2>
                <div class="similar-news-grid">
                    <?php foreach ($similarNews as $similar) { ?>
                        <article class="news-card">
                            <div class="news-image">
                                <img src="<?= !empty($similar['image']) ? htmlspecialchars($similar['image']) : '/placeholder.svg?height=200&width=300' ?>"
                                    alt="<?= htmlspecialchars($similar['title']) ?>">
                                <div class="news-category"><?= htmlspecialchars($similar['typeName']) ?></div>
                            </div>
                            <div class="news-content">
                                <h3><a
                                        href="index.php?act=news&id=<?= $similar['id'] ?>"><?= htmlspecialchars($similar['title']) ?></a>
                                </h3>
                                <p><?= htmlspecialchars(substr(strip_tags($similar['content']), 0, 100)) ?>...</p>
                                <div class="news-meta">
                                    <span><i class="fas fa-calendar"></i>
                                        <?= date('d/m/Y', strtotime($similar['createdAt'])) ?></span>
                                    <span><i class="fas fa-eye"></i> <?= number_format($similar['views']) ?> lượt xem</span>
                                </div>
                            </div>
                        </article>
                    <?php } ?>
                </div>
            </section>
        <?php } ?>
    </div>
</main>

<script>
    // Chia sẻ lên Facebook
    function shareToFacebook(url, title) {
        const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}&quote=${title}`;
        window.open(facebookUrl, '_blank', 'width=600,height=400,scrollbars=yes,resizable=yes');
    }

    // Chia sẻ lên Twitter
    function shareToTwitter(url, title) {
        const twitterUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
        window.open(twitterUrl, '_blank', 'width=600,height=400,scrollbars=yes,resizable=yes');
    }

    // Chia sẻ lên LinkedIn
    function shareToLinkedIn(url, title) {
        const linkedinUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
        window.open(linkedinUrl, '_blank', 'width=600,height=400,scrollbars=yes,resizable=yes');
    }

    // Chia sẻ lên Zalo
    function shareToZalo(url, title) {
        const zaloUrl = `https://zalo.me/share/v2?url=${url}&title=${title}`;
        window.open(zaloUrl, '_blank', 'width=600,height=400,scrollbars=yes,resizable=yes');
    }

    // Copy link to clipboard
    function copyToClipboard(url) {
        navigator.clipboard.writeText(decodeURIComponent(url)).then(function () {
            alert('Đã copy link vào clipboard!');
        }, function (err) {
            console.error('Không thể copy: ', err);
            // Fallback for older browsers
            const textArea = document.createElement("textarea");
            textArea.value = decodeURIComponent(url);
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                document.execCommand('copy');
                alert('Đã copy link vào clipboard!');
            } catch (err) {
                alert('Không thể copy link!');
            }
            document.body.removeChild(textArea);
        });
    }
</script>