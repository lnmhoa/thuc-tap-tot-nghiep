<div class="news-page">
    <section class="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">Trang chủ</a>
            <span>/</span>
            <span>Tin tức</span>
        </div>
    </div>
</section>
<main class="main-content">
    <div class="container">
        <div class="content-layout">
            <aside class="sidebar">
                <form method="POST" id="filterForm">
                    <div class="filter-section">
                        <h3>Bộ lọc tin tức</h3>

                        <div class="filter-group">
                            <label>Danh mục</label>
                            <div class="checkbox-group">
                                <?php foreach ($listTypeNews as $key => $value) { ?>
                                    <label class="checkbox-item">
                                        <input type="checkbox" name="filter-category[]" value="<?= $value['id'] ?>"
                                            <?= in_array($value['id'], $_SESSION['filter-category']) ? 'checked' : '' ?>>
                                        <span><?= $value['name'] ?></span>
                                    </label>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="filter-group">
                            <label>Thời gian</label>
                            <div class="checkbox-group">
                                <label class="checkbox-item">
                                    <input type="radio" name="filter-time" value="today"
                                        <?= $_SESSION['filter-time'] == 'today' ? 'checked' : '' ?>>
                                    <span>Hôm nay</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="radio" name="filter-time" value="week"
                                        <?= $_SESSION['filter-time'] == 'week' ? 'checked' : '' ?>>
                                    <span>Tuần này</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="radio" name="filter-time" value="month"
                                        <?= $_SESSION['filter-time'] == 'month' ? 'checked' : '' ?>>
                                    <span>Tháng này</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="radio" name="filter-time" value="quarter"
                                        <?= $_SESSION['filter-time'] == 'quarter' ? 'checked' : '' ?>>
                                    <span>3 tháng gần đây</span>
                                </label>
                            </div>
                        </div>

                        <div class="filter-actions">
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            <button type="submit" name="clear-filter" class="btn btn-outline">Xóa bộ lọc</button>
                        </div>
                    </div>
                </form>

                <!-- Popular News -->
                <div class="popular-news">
                    <h3>Tin nổi bật</h3>
                    <div class="popular-news-list">
                        <?php
                        // Hiển thị 3 tin nổi bật đầu tiên
                        $popularCount = 0;
                        foreach ($listNews as $key => $value) {
                            if ($popularCount >= 3)
                                break;
                        ?>
                            <div class="popular-news-item">
                                <div class="popular-news-content">
                                    <h4><a
                                            href="index.php?act=news&id=<?= $value['id'] ?>"><?= substr($value['title'], 0, 50) ?>...</a>
                                    </h4>
                                    <span class="news-date"><?= date('d/m/Y', strtotime($value['createdAt'])) ?></span>
                                </div>
                            </div>
                        <?php
                            $popularCount++;
                        } ?>
                    </div>
                </div>
            </aside>

            <!-- Main Content Area -->
            <div class="content-area">
                <div class="content-header">
                    <div class="results-info">
                        <span>Tìm thấy <strong><?= mysqli_num_rows($total) ?></strong> tin tức</span>
                        <?php if (!empty($_SESSION['filter-category']) || !empty($_SESSION['filter-time'])) { ?>
                            <span style="color: #666; font-size: 14px;">(Đã áp dụng bộ lọc)</span>
                        <?php } ?>
                    </div>
                    <div class="sort-options">
                        <label style="width: 100px">Sắp xếp:</label>
                        <form method="POST" style="display: inline;">
                            <select class="form-select" name="sort-news" onchange="this.form.submit()">
                                <option value="desc" <?= $_SESSION['sort-news'] == 'desc' ? 'selected' : '' ?>>Mới nhất
                                </option>
                                <option value="asc" <?= $_SESSION['sort-news'] == 'asc' ? 'selected' : '' ?>>Cũ nhất
                                </option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Featured News -->
                <?php
                // Tin nổi bật luôn là tin đầu tiên nếu có pin = 1
                $featuredNews = null;
                if (!empty($listNews) && $listNews[0]['pin'] == 1) {
                    $featuredNews = $listNews[0];
                }

                if ($featuredNews) { ?>
                    <div class="featured-news">
                        <article class="news-card-large">
                            <div class="news-image">
                                <img src="../1.jpg" alt="" style="height: 200px; object-fit: fill; width: 420px;">
                                <div class="news-category"><?= $featuredNews['typeName'] ?></div>
                            </div>
                            <div class="news-content">
                                <h2><a
                                        href="index.php?act=news&id=<?= $featuredNews['id'] ?>"><?= $featuredNews['title'] ?></a>
                                </h2>
                                <p class="news-excerpt"><?= substr(strip_tags($featuredNews['content']), 0, 200) ?>...</p>
                                <div class="news-meta">
                                    <div class="author-info">
                                        <img src="../1.jpg?height=30&width=30" alt="Tác giả">
                                        <span><?= !empty($featuredNews['author']) ? $featuredNews['author'] : 'Admin' ?></span>
                                    </div>
                                    <div class="news-stats">
                                        <span><i class="fas fa-calendar"></i>
                                            <?= date('d/m/Y', strtotime($featuredNews['createdAt'])) ?></span>
                                        <span><i class="fas fa-eye"></i>
                                            <?= !empty($featuredNews['views']) ? $featuredNews['views'] : '0' ?></span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>  <img src="<?= !empty($value['image']) ? $value['image'] : '../1.jpg' ?>" alt="<?= $value['title'] ?>">
                <?php } ?>
                              

                <!-- News Grid -->
                <div class="news-grid-list">
                    <?php
                    // Hiển thị các tin tức còn lại, bỏ qua tin nổi bật ở đầu
                    $startIndex = ($featuredNews) ? 1 : 0; // Bỏ qua tin đầu tiên nếu là tin nổi bật
                    for ($i = $startIndex; $i < count($listNews); $i++) {
                        $value = $listNews[$i];
                    ?>
                        <article class="news-card-horizontal">
                            <div class="news-image">
                                  <img src="../1.jpg" alt="" style="object-fit: fill;">
                            
                                <div class="news-category"><?= $value['typeName'] ?></div>
                            </div>
                            <div class="news-content">
                                <h3><a href="index.php?act=news&id=<?= $value['id'] ?>"><?= $value['title'] ?></a>
                                </h3>
                                <p class="news-excerpt"><?= substr(strip_tags($value['content']), 0, 150) ?>...</p>
                                <div class="news-meta">
                                    <div class="author-info">
                                        <img src="../1.jpg?height=25&width=25" alt="Tác giả">
                                        <span><?= !empty($value['author']) ? $value['author'] : 'Admin' ?></span>
                                    </div>
                                    <div class="news-stats">
                                        <span><i class="fas fa-calendar"></i>
                                            <?= date('d/m/Y', strtotime($value['createdAt'])) ?></span>
                                        <span><i class="fas fa-eye"></i>
                                            <?= !empty($value['views']) ? $value['views'] : '0' ?></span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php } ?>
                </div>

                <!-- No Results Message -->
                <?php if (empty($listNews)) { ?>
                    <div style="text-align: center; padding: 40px; color: #666;">
                        <h3>Không tìm thấy tin tức nào</h3>
                        <p>Hãy thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
                    </div>
                <?php } ?>

                <!-- Pagination -->
                <?php if ($total_page > 1) { ?>
                    <div class="pagination">
                        <?php if ($current_page > 1) { ?>
                            <a href="index.php?act=listNews&page=<?= $current_page - 1 ?>" class="page-btn"><i
                                    class="fas fa-chevron-left"></i></a>
                        <?php } else { ?>
                            <button class="page-btn" disabled><i class="fas fa-chevron-left"></i></button>
                        <?php } ?>

                        <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                            <?php if ($i == $current_page) { ?>
                                <button class="page-btn active"><?= $i ?></button>
                            <?php } else { ?>
                                <a href="index.php?act=listNews&page=<?= $i ?>" class="page-btn"><?= $i ?></a>
                            <?php } ?>
                        <?php } ?>

                        <?php if ($current_page < $total_page) { ?>
                            <a href="index.php?act=listNews&page=<?= $current_page + 1 ?>" class="page-btn"><i
                                    class="fas fa-chevron-right"></i></a>
                        <?php } else { ?>
                            <button class="page-btn" disabled><i class="fas fa-chevron-right"></i></button>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
</div>