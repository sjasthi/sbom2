
<!-- checkSelectedLeftMenuLink() is in the header, so all left-menu's have access to the function -->
<div class="wrap">
    <div id="menu-left">
        <a href="<?php echo checkSelectedLeftMenuLink( "APPLIST", "app_page.php" ); ?>">
            <div <?php echo checkSelectedLeftMenu( "APPLIST" ); ?>>
                <?php include $assetsPath."svg/list.svg"; ?>
                <p>App List</p>
            </div>
        </a>
        <a href="<?php echo checkSelectedLeftMenuLink( "APPSETS", "app_sets.php" ); ?>">
            <div <?php echo checkSelectedLeftMenu( "APPSETS" ); ?>>
                <?php include $assetsPath."svg/list.svg"; ?>
                <p>App Sets</p>
            </div>
        </a>

    </div>
</div>
