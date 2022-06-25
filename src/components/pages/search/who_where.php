
<?php
  include("buildTable.php"); // buildTable();

  // default to "where" searches when nothing is provided (where/who)
  function who_where() {
    $search = $_POST["searchVal"];
    $firstWord = strtok( $search, ' ' );

    if( !strcasecmp( $firstWord, 'who' ) ) { // Ownership table
      $val = trim( strstr( $search, ' ' ) );
      $sql =
        'SELECT * from Ownership
        WHERE app_type LIKE "'.$val.'%"';
      $data = $GLOBALS['db'] -> query( $sql );

      if( $val === '' ) {
        $val = '*';
      }

      echo 
        '<h3>
          <span>Query: <i>"Ownership"</i></span>
          <div>
            WHERE <span> app_type = </span>
            <span><i><u>'.$val.'</u></i></span>
          </div>
        </h3>';

      buildTable( $data );

      return $data;
    } else { // App_Components table
      $sql =
        'SELECT * from apps_components
        WHERE cmpt_name LIKE "'.$search.'%"
        OR app_name LIKE "'.$search.'%"';
      $data = $GLOBALS['db'] -> query( $sql );

      echo 
        '<h3>
          <span>Query: <i>"app_components"</i></span>

          <div>
            WHERE <span> (cmpt_name</span> OR <span>app_name) = </span>
            <span><i><u>'.$search.'</u></i></span>
          </div>
        </h3>';
      
      buildTable( $data );

      return $data;
    }
  }
?>
