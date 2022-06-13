
<div class="wrap">
    <div id="menu-left">
        <a href="<?php echo checkSelectedLeftMenuLink( "RELEASESLIST", "releases_releases_list.php" ); ?>">
            <div <?php if ($left_selected == "RELEASESLIST") {
                echo 'class="menu-left-current-page"';
            } ?>>
                <?php include $assetsPath.'svg/tableChart.svg'; ?>
                <p> Releases List </p></div>
        </a>

        <a href="<?php echo checkSelectedLeftMenuLink( "RELEASESGANTT", "releases_releases_gantt.php" ); ?>">
            <div <?php if ($left_selected == "RELEASESGANTT") {
                echo 'class="menu-left-current-page"';
            } ?>>
                <?php include $assetsPath.'svg/backupTable.svg'; ?>
                <p> Releases Gantt </p></div>
        </a>
    </div>
</div>
