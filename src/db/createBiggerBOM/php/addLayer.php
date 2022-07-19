
<?php
    /*
        red_app_id  ->  cmpt_id     -> app_id   -> layer 1
        red_app_id2 ->  cmpt_id2    -> app_id2  -> layer 2
        red_app_id3 ->  cmpt_id3    -> app_id3  -> layer 3
        ...
    */
    function addLayer( $list, $layer ) {
        $newList = [];
        $i = 0;

        foreach( $list as $item ) {
            $obj = new stdClasS();

            foreach( $item as $key => $val ) {
                if( $key === "red_app_id" || $key === "cmpt_id" || $key === "app_id" ) {
                    $newKey = $key.$layer;
                    
                    $obj -> $key = $val;
                    $obj -> $newKey = $val + ($layer - 1);
                }else {
                    $obj -> $key = $val;
                }
            }

            array_push( $newList, $obj );
        }

        return $newList;
    }
?>
