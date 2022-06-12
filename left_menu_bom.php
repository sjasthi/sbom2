<!DOCTYPE html>
<html>
<head>

</head>
<body>

<div id="menu-left">
    <a href="bom_sbom_list.php">
        <div <?php if ($left_selected == "SBOMLIST") {
            echo 'class="menu-left-current-page"';
        } ?>>
            <img src="./images/sbom_list.png">
            <br/>BOM List<br/></div>
    </a>

    <a href="bom_sbom_tree.php">
        <div <?php if ($left_selected == "SBOMTREE") {
            echo 'class="menu-left-current-page"';
        } ?>>
            <img src="./images/sbom_tree.png">
            <br/>BOM Tree<br/></div>
    </a>
        <!-- // changed to v3 10-26-2020 -->
        <a href="bom_sbom_tree_v3.php">
        <div <?php if ($left_selected == "SBOMTREE2") {
            echo 'class="menu-left-current-page"';
        } ?>>
            <img src="./images/sbom_tree.png">
            <br/>BOM Tree V3<br/></div>
    </a>

    <a href="bom_pieChart.php">
      	<div <?php if($left_selected == "REPORTSPIECHART")
      	{ echo 'class="menu-left-current-page"'; } ?>>
      	<img src="./images/reports.png">
      	<br/>Pie Chart<br/></div>
    </a>

    <a href="bom_barChart.php">
      	<div <?php if($left_selected == "REPORTSBARCHART")
      	{ echo 'class="menu-left-current-page"'; } ?>>
      	<img src="./images/reports.png">
      	<br/>Bar Chart<br/></div>
    </a>

    <a href="bom_status.php">
      	<div <?php if($left_selected == "BOMSTATUS")
      	{ echo 'class="menu-left-current-page"'; } ?>>
      	<img src="./images/training_status.png">
      	<br/>BOM Status<br/></div>
    </a>

    <a href="bom_out_of_sync_bom_list.php">
        <div <?php if ($left_selected == "OUTOFSYNCBOMLIST") {
            echo 'class="menu-left-current-page"';
        } ?>>
            <img src="./images/sbom_list.png" alt="Import CSV">
            <br/>Out of Sync <br> BOM List<br/></div>
    </a>
    </div>
</body>

<!-- // Edit By Kevin (kevin.flanagan@my.metrostate.edu) -->
</html>
