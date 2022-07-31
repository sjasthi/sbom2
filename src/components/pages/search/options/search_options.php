
<?php
  // default to "where" searches when nothing is provided (where/who)
  function search_options() {
    $search = $_POST["searchVal"];
    $firstWord = strtok( $search, ' ' );

    // trim off these specific words
    if( !strcasecmp( $firstWord, 'where' ) || !strcasecmp( $firstWord, 'who' ) || !strcasecmp( $firstWord, 'what' ) ) {
      $search = trim( strstr( $search, ' ' ) );
    }

    if( !strcasecmp( $firstWord, 'who' ) ) { // Ownership
      include("options/search_who.php"); // search_who();

      return search_who( $search );
    }
    else if( !strcasecmp( $firstWord, 'what' ) ) {
      include("options/search_what.php"); // search_what();

      return search_what( $search );
    }
    else { // app_components
      include("options/search_where.php"); // search_where();

      return search_where( $search );
    }
  }
?>
