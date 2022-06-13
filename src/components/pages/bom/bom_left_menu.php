
<!-- checkSelectedLeftMenuLink() is in the header, so all left-menu's have access to the function -->
<div class="wrap">
    <div id="menu-left">
        <a href="<?php echo checkSelectedLeftMenuLink( "SBOMLIST", "bom_sbom_list.php" ); ?>">
            <div <?php if (isset($left_selected) && $left_selected == "SBOMLIST") {echo 'class="menu-left-current-page"';} ?>>
                <?php include $assetsPath."svg/list.svg"; ?>
                <p>BOM List</p>
            </div>
        </a>

        <a href="<?php echo checkSelectedLeftMenuLink( "SBOMTREE", "bom_sbom_tree.php" ); ?>">
            <div <?php if (isset($left_selected) && $left_selected == "SBOMTREE") {echo 'class="menu-left-current-page"';} ?>>
                <?php include $assetsPath."svg/treeV1.svg"; ?>
                <p>BOM Tree</p>
            </div>
        </a>

        <!-- // changed to v3 10-26-2020 -->
        <a href="<?php echo checkSelectedLeftMenuLink( "SBOMTREE2", "bom_sbom_tree_v3.php" ); ?>">
            <div <?php if (isset($left_selected) && $left_selected == "SBOMTREE2") {echo 'class="menu-left-current-page"';} ?>>
                <?php include $assetsPath."svg/treeV2.svg"; ?>
                <p>BOM Tree V3</p>
            </div>
        </a>

        <a href="<?php echo checkSelectedLeftMenuLink( "REPORTSPIECHART", "bom_pieChart.php" ); ?>">
            <div <?php if(isset($left_selected) && $left_selected == "REPORTSPIECHART"){ echo 'class="menu-left-current-page"'; } ?>>
                <?php include $assetsPath."svg/pieChart.svg"; ?>
                <p>Pie Chart</p>
            </div>
        </a>

        <a href="<?php echo checkSelectedLeftMenuLink( "REPORTSBARCHART", "bom_barChart.php" ); ?>">
            <div <?php if(isset($left_selected) && $left_selected == "REPORTSBARCHART"){ echo 'class="menu-left-current-page"'; } ?>>
                <?php include $assetsPath."svg/barChart.svg"; ?>
                <p>Bar Chart</p>
            </div>
        </a>

        <a href="<?php echo checkSelectedLeftMenuLink( "BOMSTATUS", "bom_status.php" ); ?>">
            <div <?php if(isset($left_selected) && $left_selected == "BOMSTATUS"){ echo 'class="menu-left-current-page"'; } ?>>
                <?php include $assetsPath."svg/status.svg"; ?>
                <p>BOM Status</p>
            </div>
        </a>

        <a href="<?php echo checkSelectedLeftMenuLink( "OUTOFSYNCBOMLIST", "bom_out_of_sync_bom_list.php" ); ?>">
            <div <?php if (isset($left_selected) && $left_selected == "OUTOFSYNCBOMLIST") {echo 'class="menu-left-current-page"';} ?>>
                <?php include $assetsPath."svg/outOfSync.svg"; ?>
                <p>Out of Sync</p>
                <p>BOM List</p>
            </div>
        </a>
    </div>
</div>
