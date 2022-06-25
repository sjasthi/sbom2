
<?php
  function grabList( $result ) {
    $list = [];

    if( isset( $result ) ) {
      foreach( $result as $key => $val ) {
        array_push( $list, $val );
      }
    }

    return $list;
  }
?>
