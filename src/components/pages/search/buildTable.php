
<?php
  function buildTable( $object ) {
    echo 
      '<div class="table-container">
        <table class="table table-striped table-bordered">';

    $x = 0; // used to find first object, not increment
    foreach( $object as $key => $val ) {
      if( $x === 0 ) { // build headers from first object
        echo '<tr>';
        foreach( $val as $col => $cell ) {
          echo '<th>'.$col.'</th>';
        }
        echo '</tr>';

        echo '<tr>';
        foreach( $val as $col => $cell ) { // apply first row values from object
          echo '<td>'.$cell.'</td>';
        }
        echo '</tr>';
      } else { // build any other rows that come after
        echo '<tr>';
        foreach( $val as $col => $cell ) {
          echo '<td>'.$cell.'</td>';
        }
        echo '</tr>';
      }

      $x++;
    }

    echo
        '</table>
      </div>';
  }
?>
