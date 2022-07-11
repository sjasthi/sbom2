
<?php
    function json( $BOM ) { // convert array to json
        $json = json_encode( $BOM, JSON_PRETTY_PRINT );

        return $json;
    }
?>
