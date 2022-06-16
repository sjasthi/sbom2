<?php

//test
	// Added by Shahid
  // Revamped the User Interface; Refactored the code
  // connect to DB
  require_once( 'src/db/connect.php' );

  // pages are separate from the index, so this is needed for pathing..
  if( !isset( $nav_selected ) ) { // from "index.php"
    $nav_selected = $indexPath = '';
    $tabTitle = 'Software BOM (SBOM)';
    $assetsPath = 'src/assets/';
    $componentsPath = 'src/components/';
  } else { // from "components"
    $indexPath = '../../../../';
    $assetsPath = '../../../assets/';
    $componentsPath = '../../';
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- jQuery library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-treetable/3.2.0/css/jquery.treetable.theme.default.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/dataTables.bootstrap.min.js"></script>

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- datatables/buttons -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>

    <?php
      echo '<script src="'.$assetsPath.'/jquery/jquery.treetable.js"></script>';
    ?>

    <!-- app styles -->
    <?php
      echo '<link rel="stylesheet" href="'.$componentsPath.'_shared/_variables.css">';
      echo '<link rel="stylesheet" href="'.$componentsPath.'app.css">';
      echo '<link rel="stylesheet" href="'.$componentsPath.'header/header.css">';
      echo '<link rel="stylesheet" href="'.$componentsPath.'_shared/form.css">';
      echo '<link rel="stylesheet" href="'.$componentsPath.'_shared/table.css">';
      echo '<link rel="stylesheet" href="'.$componentsPath.'_shared/left_menu.css">';
      echo '<link rel="stylesheet" href="'.$componentsPath.'pages/pages.css">';
      echo '<link rel="stylesheet" href="'.$componentsPath.'pages/bom/tree.css">';
      echo '<link rel="stylesheet" href="'.$componentsPath.'pages/login/login.css">';
    ?>

    <link rel="icon" href="<?php echo $assetsPath; ?>images/BOM.png" />
    <title><?php echo $tabTitle; ?></title>
  </head>

  <body>
    <div id="root"></div>

    <?php
      // pages will be targeted from within the header
      include "src/components/header/header.php";

      // conditional rendering for homepage
      if( $nav_selected === '' ) {
        echo 
          '<div class="wrap">
            <h3> Welcome to Software Bill Of Materials </h3>
          </div>';
      }
    ?>
  </body>
</html>
