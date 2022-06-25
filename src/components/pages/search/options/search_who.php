
<?php
    function search_who( $search ) {
        $sql =
            'SELECT * from Ownership
            WHERE app_type LIKE "'.$search.'%"';
        $data = $GLOBALS['db'] -> query( $sql );

        if( $search === '' ) {
            echo 
            '<h3>
                <div>
                    SELECT <span> * </span> FROM <span> Ownership </span>
                </div>
            </h3>';
        } else {
            echo 
            '<h3>
                <div>
                    SELECT <span> * </span> FROM <span> Ownership </span>
                </div>
                
                <div>
                    WHERE <span> app_type = </span>
                    <span><i><u>'.$search.'</u></i></span>
                </div>
            </h3>';
        }

        return $data;
    }
?>
