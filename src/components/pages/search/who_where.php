
<?php
  // default to "where" searches when nothing is provided (where/who)
  function who_where() {
    include("buildTable.php"); // buildTable();

    $search = $_POST["searchVal"];
    $firstWord = strtok( $search, ' ' );

    if( !strcasecmp( $firstWord, 'who' ) ) { // Ownership table
      $val = strstr( $search, ' ' );

      echo 
      '<h3>
        <span>Query: <i>"Ownership"</i></span>

        <div>
          WHERE <span> app_name = </span>
          <span><i><u>'.$val.'</u></i></span>
        </div>
      </h3>';

      $data = array( 0 => array( 'who' => $val ) );
      buildTable( $data );

      return $data;
    } else { // App_Components table
      // search component name first, then app name.
      $sql =
      'SELECT * from apps_components
      WHERE cmpt_name LIKE "'.$search.'%"
      OR app_name LIKE "'.$search.'%"';

      echo 
        '<h3>
          <span>Query: <i>"app_components"</i></span>

          <div>
            WHERE <span> (cmpt_name</span> OR <span>app_name) = </span>
            <span><i><u>'.$search.'</u></i></span>
          </div>
        </h3>';
      
      $data = $GLOBALS['db'] -> query( $sql );
      buildTable( $data );

      return $data;
    }
  }
?>
