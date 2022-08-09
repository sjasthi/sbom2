
<?php
    function search_what( $search ) {
        $sql =
            'SELECT * from apps_components
            WHERE app_name LIKE "'.$search.'%"
            AND issue_count > 0';
        $data = $GLOBALS['db'] -> query( $sql );

//         if( $search === '' ) {
//             echo 
//             '<h3>
//                 <div>
//                     SELECT <span> * </span> FROM <span> app_components </span>
//                 </div>
//             </h3>';
//         } else {
//             echo 
//             '<h3>
//                 <div>
//                     SELECT <span> * </span> FROM <span> app_components </span>
//                 </div>

//                 <div>
//                     WHERE <span> app_name = </span>
//                     <span><i><u>'.$search.'</u></i></span>
//                 </div>

//                 <div>
//                     AND <span> issue_count > 0 </span>
//                 </div>
//             </h3>';
//         }
        
        return $data;
    }
?>
