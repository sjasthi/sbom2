
<?php
    function factorOfTen( $list, $factor = 10 ) { // multiply any list by 10X
        $newList = [];
        $i = 0;

        for( $x = 0; $x < $factor; $x++ ) {
            foreach( $list as $item ) {
                $obj = new stdClasS();

                foreach( $item as $key => $val ) {
                    if( $key === "line_id" ) {
                        $i++;

                        $obj -> $key = $i;
                    }else {
                        $obj -> $key = $val;
                    }
                }

                array_push( $newList, $obj );
            }
        }

        return $newList;
    }
?>
