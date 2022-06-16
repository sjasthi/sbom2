
<?php
  $nav_selected = "SEARCH";
  $tabTitle = "SBOM - Search";

  include("../../../../index.php");

  // search component name first, then app name.
  // default to "where" searches when nothing is provided (where/who)
  $searchVal = $_POST["searchVal"];
  $sql =
  'SELECT * from apps_components
  WHERE cmpt_name LIKE "'.$searchVal.'%"
  OR app_name LIKE "'.$searchVal.'%"';
  $result = $GLOBALS['db'] -> query( $sql );

  function grabList( $result ) {
    $list = [];
    foreach( $result as $key => $val ) {
      array_push( $list, $val );
    }

    return $list;
  }

  function buildTable( $object ) {
    $x = 0;
    foreach( $object as $key => $val ) { // grab first object
      if( $x === 0 ) {
        $x++;

        foreach( $val as $col => $cell ) { // but only the headers
          echo '<p>'.$col.'</p>';
        }

        return;
      }
    }
  }
?>

<!-- output -->
<div class="wrap">
  <h3> Search val: <?php echo $searchVal; ?> </h3>

  <?php
    $searchResults = grabList( $result );

    buildTable( $result );

    $json = json_encode( $searchResults, JSON_PRETTY_PRINT );
    echo '<script> console.warn("Data:"); </script>';
    echo '<script> console.warn('.$json.'); </script>';
  ?>
</div>
