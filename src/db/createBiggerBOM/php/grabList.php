
<?php
    function grabList( $result ) { // convert an object into an array
        $list = [];
    
        if( isset( $result ) ) {
          foreach( $result as $key => $val ) {
            array_push( $list, $val );
          }
        }
    
        return $list;
    }
?>
