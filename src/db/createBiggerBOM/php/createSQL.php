
<?php
    function createSQL( $BOM ) { // convert array to INSERT sql
        $headers = "INSERT INTO `apps_components` (";
        $values = "";
        $x = 0;
        $i = 0;
        
        foreach( $BOM as $item ) {
            $a = 0;
            $x++;

            $values .= "(";
            foreach( $item as $key => $obj ) {
                $a++;

                if( $a === count((array)$item) && $x === count((array)$BOM) ) {
                    $values .= $obj.");";
                } else if ( $a === count((array)$item) ) {
                    $values .= $obj."), \n";
                } else {
                    if( $a === 1 ) {
                        $values .= $obj.", ";
                    } else {
                        $values .= "'".$obj."', ";

                    }
                }

                if( $x === 1 ) {
                    $i++;

                    if ( $i === count((array)$item) ) {
                        $headers .= "`".$key."`) VALUES";
                    } else {
                        $headers .= "`".$key."`, ";
                    }
                }
            }
        }

        return $headers."\n".$values;
    }
?>
