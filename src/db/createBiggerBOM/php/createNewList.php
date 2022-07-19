
<?php
    // increment version & remove the line_id to be re-numbered
    function createNewList( $list ) {
        $x = 0;
        $newList = [];

        foreach( $list as $item ) {
            $obj = new stdClasS();
            foreach( $item as $key => $val ) {
                if( $key === "cred_app_id" || $key === "cmpt_id" || $key === "app_id" ) {
                    $newVal = intval( $val );

                    $obj -> $key = $newVal;
                } else if( $key === "line_id" ) {
                    $obj -> $key = NULL;
                } else {
                    $obj -> $key = $val;
                }
            }

            array_push( $newList, $obj );
        }

        return $newList;
    }
?>
