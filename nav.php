<?php
  require_once('initialize.php');
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="styles/main_style.css" type="text/css">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- jQuery library -->
        <!-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script>-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="jquery.treetable.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.css"/>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.js"></script>
        
        <link rel="stylesheet" href="styles/custom_nav.css" type="text/css">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-treetable/3.2.0/css/jquery.treetable.theme.default.css" />
        <title>Software BOM (SBOM)</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>

        <link rel="stylesheet" href="./mainStyleSheet.css">
        <link rel="stylesheet" href="tree_style.css" />
    </head>

<body class="body_background">
<div id="wrap">
    <div id="nav">
        <ul>
            <a href="index.php">
              <li class="horozontal-li-logo">
              <img src ="./images/sbom_main.png">
              <br/>Software BOM</li>
            </a>

            <a href="index.php">
              <li <?php if($nav_selected == "HOME"){ echo 'class="current-page"'; } ?>>
              <img src="./images/home.png">
              <br/>Home</li>
            </a>

            <a href="releases_releases_list.php">
              <li <?php if($nav_selected == "RELEASES"){ echo 'class="current-page"'; } ?>>
                <img src="./images/list.png">
                <br/>Releases</li>
            </a>
			
			 <a href="app_list.php">
              <li <?php if($nav_selected == "APPLICATIONS"){ echo 'class="current-page"'; } ?>>
                <img src="./images/apps.png">
                <br/>Applications</li>
            </a>
			
			

            <a href="bom_sbom_list.php">
              <li <?php if($nav_selected == "BOM"){ echo 'class="current-page"'; } ?>>
              <img src="./images/sbom_list.png">
              <br/>BOM List</li>
            </a>
			
			<a href="bom_sbom_tree.php">
              <li <?php if($nav_selected == "BOM"){ echo 'class="current-page"'; } ?>>
              <img src="./images/bom_tree.png">
              <br/>BOM Tree</li>
            </a>
			
			<a href="sla_payload.php">
              <li <?php if($nav_selected == "BOM"){ echo 'class="current-page"'; } ?>>
              <img src="./images/sla_payload.png">
              <br/>SLA Payload</li>
            </a>
			
			<a href="reports.php">
              <li <?php if($nav_selected == "BOM"){ echo 'class="current-page"'; } ?>>
              <img src="./images/reports.png">
              <br/>Reports</li>
            </a>
			
			<a href="ownership.php">
              <li <?php if($nav_selected == "BOM"){ echo 'class="current-page"'; } ?>>
              <img src="./images/ownership.png">
              <br/>Ownership</li>
            </a>

            <a href="setup_system_preference.php">
              <li <?php if($nav_selected == "SETUP"){ echo 'class="current-page"'; } ?>>
                <img src="./images/setup.png">
                <br/>Setup</li>
            </a>

            <a href="help.php">
              <li <?php if($nav_selected == "HELP"){ echo 'class="current-page"'; } ?>>
                <img src="./images/help.png">
                <br/>help</li>
            </a>

      </ul>
      <br />
    </div>


    <table style="width:1250px">
      <tr>
        <?php
            if ($left_buttons == "YES") {
        ?>

        <td style="width: 120px;" valign="top">
        <?php
            if ($nav_selected == "HOME") {
                include("./index.php");
            } elseif ($nav_selected == "RELEASES") {
                include("./left_menu_releases.php");
            } elseif ($nav_selected == "BOM") {
                include("./left_menu_bom.php");
            } elseif ($nav_selected == "REPORTS") {
                include("./left_menu_reports.php");
            } elseif ($nav_selected == "ADMIN") {
              include("./left_menu_admin.php");
            }elseif ($nav_selected == "SETUP") {
            include("./left_menu_setup.php");
            } elseif ($nav_selected == "ABOUT") {
             include("./left_menu_about.php");
            }elseif ($nav_selected == "HELP") {
                include("./left_menu_help.php");
            } else {
                include("./left_menu.php");
            }
        ?>
        </td>
        <td style="width: 1100px;" valign="top">
        <?php
          } else {
        ?>
        <td style="width: 100%;" valign="top">
        <?php
          }
        ?>
