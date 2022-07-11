
<?php
    function createTinyBOM() { // creates 10 rows that are copied
        $sql = 'SELECT * FROM apps_components LIMIT 10';
        $data = $GLOBALS['db'] -> query( $sql );

        return createNewList( grabList( $data ) );
    }
?>
