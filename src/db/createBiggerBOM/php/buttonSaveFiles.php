
<?php
    // add button cases for bigger BOMs here..
    if( isset( $_POST['button'] ) ) {
        $button = $_POST['button'];

        switch( $button ) {
            case "100": {
                echo "Createed 100 new BOMS";
                
                $saveFile = fopen( "sql/small_100.sql", 'w' );
                fwrite( $saveFile, json( factorOfTen( createTinyBOM() ) ) );
            } break;

            case "1,000": {
                echo "Createed 1,000 new BOMS";
                
                $saveFile = fopen( "sql/medium_1000.sql", 'w' );
                fwrite(
                    $saveFile,
                    json(
                        addLayer( // add another layer (4 levels)
                            factorOfTen( // 1,000
                                factorOfTen( createTinyBOM() ) // 100 (default: 2 levels of depth)
                            ), 2
                        )
                    )
                );
            } break;

            case "10,000": {
                echo "Createed 10,000 new BOMS";
                
                $saveFile = fopen( "sql/large_10000.sql", 'w' );
                fwrite(
                    $saveFile,
                    json(
                        addLayer( // add another layer (6 levels)
                            addLayer( // add another layer (4 levels)
                                factorOfTen( // 10,000
                                    factorOfTen( // 1,000
                                        factorOfTen( createTinyBOM() ) // 100 (default: 2 levels of depth)
                                    )
                                ), 2
                            ), 3
                        )
                    )
                );
            } break;
        }
    }
?>
