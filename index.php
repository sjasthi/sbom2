<?php
  // connect to DB
  require_once( 'src/db/connect.php' );
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

      <title> Software BOM (SBOM) </title>

      <!-- styles -->
      <?php
        if( !isset( $nav_selected ) ) { // separate paths, based on relation to other pages..
          echo '<script src="src/assets/jquery/jquery.treetable.js"></script>';
          echo '<link rel="stylesheet" href="src/index.css">';
        } else {
          echo '<script src="../../../assets/jquery/jquery.treetable.js"></script>';
          echo '<link rel="stylesheet" href="../../../index.css">';
        }
      ?>
  </head>

  <body>
      <div class="wrap">
          <?php
            include "src/components/header/header.php";

            if( !isset( $nav_selected ) ) {
              echo '<h3> Welcome to Software Bill Of Materials </h3>';
            }
          ?>
      </div>
  </body>
</html>
