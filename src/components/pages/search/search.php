
<?php
  $nav_selected = "SEARCH";
  $tabTitle = "SBOM - Search";
  $autoFocus = 'autofocus';

  include("../../../../index.php");
?>

<!-- HTML -->
<div class="wrap">
  <?php
    include("who_where.php"); // who_where();

    // search table based on "who" or "what" keyword
    $resultsObject = who_where();
  ?>

  <!-- added functionality -->
  <script>
    $('.table-container').doubleScroll(); // assign a double scroll to this class
  </script>
</div>

<!-- output to console -->
<?php
  include("grabList.php"); // grabList();

  $resultsArray = grabList( $resultsObject );
  $json = json_encode( $resultsArray, JSON_PRETTY_PRINT );
  
  echo '<script> console.warn("Data:"); </script>';
  echo '<script> console.warn('.$json.'); </script>';
?>
