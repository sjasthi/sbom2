
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
        echo 
          '<h3>
            <div>
              SELECT <span> * </span> FROM <span> Ownership </span>
            </div>
          </h3>';
      } else {
        echo 
          '<h3>
            <div>
              SELECT <span> * </span> FROM <span> Ownership </span>
            </div>
            
            <div>
              WHERE <span> app_type = </span>
              <span><i><u>'.$val.'</u></i></span>
            </div>
          </h3>';
      }

      buildTable( $data );

      return $data;
    } else { // App_Components table
      $sql =
        'SELECT * from apps_components
        WHERE cmpt_name LIKE "'.$search.'%"
        OR app_name LIKE "'.$search.'%"';
      $data = $GLOBALS['db'] -> query( $sql );

      if( $search === '' ) {
        echo 
          '<h3>
            <div>
              SELECT <span> * </span> FROM <span> app_components </span>
            </div>
          </h3>';
      } else {
        echo 
          '<h3>
            <div>
              SELECT <span> * </span> FROM <span> app_components </span>
            </div>
            <div>
              WHERE <span> (cmpt_name</span> OR <span>app_name) = </span>
              <span><i><u>'.$search.'</u></i></span>
            </div>
          </h3>';
      }
      
      buildTable( $data );

      return $data;
    }
  }
?>
