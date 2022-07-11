
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <style>
            body {
                margin: 40px;
            }

            #root {
                display: flex;
                align-items: center;
            }

            input {
                cursor: pointer;
                margin: 0 20px 10px 0;
                padding: 4px 10px;
            }
        </style>

        <link rel="icon" href="../../assets/images/BOM.png" />
        <title> Create Bigger BOMS </title>
    </head>

    <body>
        <div id="root">
            <form method="POST" action="./createBiggerBOM.php">
                <input type="submit" name="button" value="100"></input>
            </form>

            <form method="POST" action="./createBiggerBOM.php">
                <input type="submit" name="button" value="1,000"></input>
            </form>

            <form method="POST" action="./createBiggerBOM.php">
                <input type="submit" name="button" value="10,000"></input>
            </form>
        </div>
    </body>
</html>

<?php
    // connect to DB
    require_once( 'connect.php' );

    // TODO;
    // take in 100 app_components and change their version & IDs for new app_componentsV2
    // should output to 3 sql files: db_small_100.sql/ db_medium_1000.sql/ db_large_10000.sql

    function grabList( $result ) { // grab an array from object
        $list = [];
    
        if( isset( $result ) ) {
          foreach( $result as $key => $val ) {
            array_push( $list, $val );
          }
        }
    
        return $list;
    }

    function createNewList( $list ) { // add version #
        $x = 0;
        $newList = [];

        foreach( $list as $item ) {
            $obj = new stdClasS();
            foreach( $item as $key => $val ) {
                if( $key === "cmpt_id" || $key === "app_id" ) {
                    $newVal = intval( $val ) + 1;

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

    function createTinyBOM() { // 10
        $sql = 'SELECT * FROM apps_components LIMIT 10';
        $data = $GLOBALS['db'] -> query( $sql );

        return createNewList( grabList( $data ) );
    }

    function factorOfTen( $list ) { // multiply any list by 10X
        $newList = [];
        $i = 0;

        for( $x = 0; $x < 10; $x++ ) {
            foreach( $list as $item ) {
                $obj = new stdClasS();

                foreach( $item as $key => $val ) {
                    if( $key === "line_id" ) {
                        $obj -> $key = $i;
                        $i++;
                    } else {
                        $obj -> $key = $val;
                    }
                }

                array_push( $newList, $obj );
            }
        }

        return $newList;
    }

    function json( $BOM ) { // console output
        $json = json_encode( $BOM, JSON_PRETTY_PRINT );

        return $json;
    }

    if( isset( $_POST['button'] ) ) {
        $button = $_POST['button'];

        switch( $button ) {
            case "100": {
                echo "Createed 100 new BOMS";
                
                $saveFile = fopen( "sql/biggerBOMS/small_100.sql", 'w' );
                fwrite( $saveFile, json( factorOfTen( createTinyBOM() ) ) );
            } break;

            case "1,000": {
                echo "Createed 1,000 new BOMS";
                
                $saveFile = fopen( "sql/biggerBOMS/medium_1000.sql", 'w' );
                fwrite( $saveFile, json( factorOfTen( factorOfTen( createTinyBOM() ) ) ) );
            } break;

            case "10,000": {
                echo "Createed 10,000 new BOMS";
                
                $saveFile = fopen( "sql/biggerBOMS/large_10000.sql", 'w' );
                fwrite( $saveFile, json( factorOfTen( factorOfTen( factorOfTen( createTinyBOM() ) ) ) ) );
            } break;
        }
    }
?>
