<main class="news-detail">
    <section class="page-header">
        <div class="breadcrumb">
            <a href="index.php">Trang chủ</a>
            <span>/</span>
            <a href="index.php?act=listNews">Tin tức</a>
            <span>/</span>
            <span><?= htmlspecialchars($newsDetail['title']) ?></span>
        </div>
    </section>
    <div class="news-detail-layout">
    <?php if($newsDetail['pin'] === '1') echo '<div>' ?>
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
                            <span><i class="fas fa-eye"></i> <?= number_format($newsDetail['views']) ?> lượt xem</span>
                        </div>
                    </div>
                </header>
                <?php if (!empty($newsDetail['image'])) { ?>
                    <div class="article-image">
                        <img src="<?= htmlspecialchars($newsDetail['image']) ?>"
                            alt="<?= htmlspecialchars($newsDetail['title']) ?>">
                    </div>
                <?php } ?>

                <div class="article-content">
                    <?= $newsDetail['content'] ?>
                     <div class="article-share">
                    <h4>Chia sẻ bài viết:</h4>
                    <div class="share-buttons">
                        <button class="share-btn facebook"
                            onclick="shareToFacebook('<?= $shareUrl ?>', '<?= $shareTitle ?>')">
                            <i class="fab fa-facebook-f"></i>
                            Facebook
                        </button>
                        <button class="share-btn linkedin"
                            onclick="shareToLinkedIn('<?= $shareUrl ?>', '<?= $shareTitle ?>')">
                            <i class="fab fa-linkedin-in"></i>
                            LinkedIn
                        </button>
        
                    </div>
                </div>
                </div>
 
              
            </article>
            <aside class="news-sidebar">
                <?php if (!empty($similarNews)) { ?>
                    <div class="sidebar-widget">
                        <h3>Tin tức liên quan</h3>
                        <div class="related-news">
                            <?php foreach ($similarNews as $similar) { ?>
                                <div class="related-item">
                                    <div class="related-image">
                                        <img src="<?= !empty($similar['image']) ? htmlspecialchars($similar['image']) : '/placeholder.svg?height=200&width=300' ?>"
                                            alt="<?= htmlspecialchars($similar['title']) ?>">
                                    </div>
                                    <div class="related-content">
                                        <h4><a href="index.php?act=news&id=<?= $similar['id'] ?>"><?= htmlspecialchars($similar['title']) ?></a></h4>
                                        <div class="related-meta">
                                            <span><i class="fas fa-calendar"></i> <?= date('d/m/Y', strtotime($similar['createdAt'])) ?></span>
                                            <span><i class="fas fa-eye"></i> <?= number_format($similar['views']) ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

                <div class="sidebar-widget">
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

            </aside>
        </div>
        <?php if($newsDetail['pin'] === '1') echo '</div>' ?>
</main>

<script>
    function shareToFacebook(url, title) {
        const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}&quote=${title}`;
        window.open(facebookUrl, '_blank', 'width=600,height=400,scrollbars=yes,resizable=yes');
    }

    function shareToLinkedIn(url, title) {
        const linkedinUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
        window.open(linkedinUrl, '_blank', 'width=600,height=400,scrollbars=yes,resizable=yes');
    }
</script>