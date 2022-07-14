
<!-- checkSelectedLeftMenuLink() is in the header, so all left-menu's have access to the function -->
<div class="wrap">
    <div id="menu-left">
        <a href="<?php echo checkSelectedLeftMenuLink( "APPLIST", "app_page.php" ); ?>">
            <div <?php echo checkSelectedLeftMenu( "APPLIST" ); ?>>
                <?php include $assetsPath."svg/list.svg"; ?>
                <p>Application</p>
            </div>
        </a>

        <a href="<?php echo checkSelectedLeftMenuLink( "APP_SECURITY", "app_security.php" ); ?>">
            <div <?php echo checkSelectedLeftMenu( "APP_SECURITY" ); ?>>
                <?php include $assetsPath."svg/treeV1.svg"; ?>
                <p>App Security</p>
            </div>
        </a>

        <a href="<?php echo checkSelectedLeftMenuLink( "APPREPORT1", "app_report1_barchart.php" ); ?>">
            <div <?php echo checkSelectedLeftMenu( "APPREPORT1" ); ?>>
                <?php include $assetsPath."svg/barChart.svg"; ?>
                <p>App Report 1</p>
            </div>
        </a>

        <!-- // changed to v3 10-26-2020 -->
        <a href="<?php echo checkSelectedLeftMenuLink( "APPREPORT2", "app_report2_barchart.php" ); ?>">
            <div <?php echo checkSelectedLeftMenu( "APPREPORT2" ); ?>>
                <?php include $assetsPath."svg/barChart.svg"; ?>
                <p>App Report 2</p>
            </div>
        </a>

        <a href="<?php echo checkSelectedLeftMenuLink( "APPREPORT3", "app_report3_barchart.php" ); ?>">
            <div <?php echo checkSelectedLeftMenu( "APPREPORT3" ); ?>>
                <?php include $assetsPath."svg/barChart.svg"; ?>
                <p>App Report 3</p>
            </div>
        </a>

        <a href="<?php echo checkSelectedLeftMenuLink( "APPREPORT4", "app_report4_barchart.php" ); ?>">
            <div <?php echo checkSelectedLeftMenu( "APPREPORT4" ); ?>>
                <?php include $assetsPath."svg/barChart.svg"; ?>
                <p>App Report 4</p>
            </div>
        </a>

        <a href="<?php echo checkSelectedLeftMenuLink( "APP_ID", "app_id.php" ); ?>">
            <div <?php echo checkSelectedLeftMenu( "APP_ID" ); ?>>
                <?php include $assetsPath."svg/barChart.svg"; ?>
                <p>Comprehensive Report</p>
            </div>
        </a>
                
            </div>
        </a>
    </div>
</div>
