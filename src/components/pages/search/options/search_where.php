
<?php
    function search_where( $search ) {
        $sql =
            'SELECT * from apps_components
            WHERE cmpt_name LIKE "'.$search.'%"
            OR app_name LIKE "'.$search.'%"';
        $data = $GLOBALS['db'] -> query( $sql );

        if( $search === '' ) {
            echo 
            '<h3>
                <div>
                    SELECT <span> * </span> FROM <span> app_components </span>
                </div>
            </h3>';
        } else {
            echo 
            '<h3>
                <div>
                    SELECT <span> * </span> FROM <span> app_components </span>
                </div>

                <div>
                    WHERE <span> (cmpt_name</span> OR <span>app_name) = </span>
                    <span><i><u>'.$search.'</u></i></span>
                </div>
            </h3>';
        }
        
        return $data;
    }
?>
