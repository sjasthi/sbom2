<div class="wrap">
    <div id="menu-left">
        <a href="bom_sbom_list.php">
            <div <?php if (isset($left_selected) && $left_selected == "SBOMLIST") {echo 'class="menu-left-current-page"';} ?>>
                <img src="../../../assets/images/sbom_list.png">
                <p>BOM List</p>
            </div>
        </a>

        <a href="bom_sbom_tree.php">
            <div <?php if (isset($left_selected) && $left_selected == "SBOMTREE") {echo 'class="menu-left-current-page"';} ?>>
                <img src="../../../assets/images/sbom_tree.png">
                <p>BOM Tree</p>
            </div>
        </a>
            <!-- // changed to v3 10-26-2020 -->
            <a href="bom_sbom_tree_v3.php">
            <div <?php if (isset($left_selected) && $left_selected == "SBOMTREE2") {echo 'class="menu-left-current-page"';} ?>>
                <img src="../../../assets/images/sbom_tree.png">
                <p>BOM Tree V3</p>
            </div>
        </a>

        <a href="bom_pieChart.php">
            <div <?php if(isset($left_selected) && $left_selected == "REPORTSPIECHART"){ echo 'class="menu-left-current-page"'; } ?>>
                <img src="../../../assets/images/reports.png">
                <p>Pie Chart</p>
            </div>
        </a>

        <a href="bom_barChart.php">
            <div <?php if(isset($left_selected) && $left_selected == "REPORTSBARCHART"){ echo 'class="menu-left-current-page"'; } ?>>
                <img src="../../../assets/images/reports.png">
                <p>Bar Chart</p>
            </div>
        </a>

        <a href="bom_status.php">
            <div <?php if(isset($left_selected) && $left_selected == "BOMSTATUS"){ echo 'class="menu-left-current-page"'; } ?>>
                <img src="../../../assets/images/training_status.png">
                <p>BOM Status</p>
            </div>
        </a>

        <a href="bom_out_of_sync_bom_list.php">
            <div <?php if (isset($left_selected) && $left_selected == "OUTOFSYNCBOMLIST") {echo 'class="menu-left-current-page"';} ?>>
                <img src="../../../assets/images/sbom_list.png" alt="Import CSV">
                <p>Out of Sync</p>
                <p>BOM List</p>
            </div>
        </a>
    </div>
</div>
