
<?php
  function grabList( $result ) {
    $list = [];

    foreach( $result as $key => $val ) {
      array_push( $list, $val );
    }

    return $list;
  }
?>
