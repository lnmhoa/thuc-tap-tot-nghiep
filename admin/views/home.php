<!-- <div class="thongke">
    <h1><i class="fa-solid fa-database"></i> Tổng quan</h1>
    <div class="thongke1">
        <a class="thongke-item" href="index.php?act=listaccount">
            <div>
                <h2><i class="fa-solid fa-user"></i> Tổng số tài khoản:</h2>
                <div class="thongke-item-number">
                    <?= $totalAccount ?>
                </div>
            </div>
        </a>
        <a class="thongke-item" href="index.php?act=listjob">
            <div>
                <h2><i class="fa-solid fa-laptop-code"></i> Tổng số bài tuyển dụng:</h2>
                <div class="thongke-item-number">
                    <?= $totalJob ?>
                </div>
            </div>
        </a>
        <a class="thongke-item" href="index.php?act=listblog">
            <div>
                <h2><i class="fa-solid fa-blog"></i> Tổng số blog:</h2>
                <div class="thongke-item-number">
                    <?= $totalBlog ?>
                </div>
            </div>
        </a>
    </div>
    <h1 style="margin-top:1%"><i class="fa-solid fa-user"></i> Tài khoản:</h1>
    <?php
    $percentLocked =($totalLockedAccount / $totalAccount) * 100;
    $percent = $totalAccount - $totalLockedAccount;
    $percent1 = 100 - $percentLocked;
    ?>
    <div class="thongke1">
        <div style="width:<?= $percent1 ?>%;background-color:greenyellow;height:4vh" title="<?= $percent ?> tài khoản"></div>
        <div style="width:<?= $percentLocked ?>%;background-color:#99999999;height:4vh" title="<?= $totalLockedAccount ?> tài khoản"></div>
    </div>
    <div class="thongke1" style="margin: 2% 0 1% 0; justify-content:flex-start">
        <div style="width:20px; background-color:greenyellow;height:20px" title="<?= $percent ?> tài khoản"></div>
        <div style="margin: 0 1%">Tài khoản hữu dụng</div>
    </div>
    <div class="thongke1" style="justify-content:flex-start">
        <div style="width:20px; background-color:#99999999;height:20px" title="<?= $totalLockedAccount ?> tài khoản"></div>
        <div style="margin: 0 1%">Tài khoản bị khóa</div>
    </div>
    <h1 style="margin-top:1%"><i class="fa-solid fa-file-signature"></i> Bài tuyển dụng:</h1>
    <?php
    $JobLocked = $totalJob - count($totalJobOfEmployer);
    $percentJobLocked =($JobLocked / $totalJob) * 100;
    $Job = $totalJob - $JobLocked;
    $percentJob = 100 - $percentJobLocked;
    ?>
    <div class="thongke1">
        <div style="width:<?= $percentJob ?>%;background-color:aqua;height:4vh" title="<?= $Job ?> việc làm"></div>
        <div style="width:<?= $percentJobLocked ?>%;background-color:#99999999;height:4vh" title="<?= $JobLocked ?> việc làm"></div>
    </div>
    <div class="thongke1" style="margin: 2% 0 1% 0; justify-content:flex-start">
        <div style="width:20px; background-color:aqua;height:20px" title="<?= $Job ?> việc làm"></div>
        <div style="margin: 0 1%">việc làm hiển thị</div>
    </div>
    <div class="thongke1" style="justify-content:flex-start">
        <div style="width:20px; background-color:#99999999;height:20px" title="<?= $JobLocked ?> việc làm"></div>
        <div style="margin: 0 1%">việc làm bị ẩn</div>
    </div>
</div> -->