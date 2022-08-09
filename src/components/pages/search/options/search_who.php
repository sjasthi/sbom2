
<?php
    function search_who( $search ) {
        if( str_word_count( $search ) > 1 ) {
            $words = explode( ' ', $search );
            $searchName = array_pop( $words ); // grab last word
            $val = array_shift( $words ); // grab first word
        
            $sql =
                'SELECT * FROM Ownership
                WHERE app_type LIKE "'.$val.'"
                AND app_name LIKE "'.$searchName.'%"';

//                 echo 
//                     '<h3>
//                         <div>
//                             SELECT <span> * </span> FROM <span> Ownership </span>
//                         </div>
                        
//                         <div>
//                             WHERE <span> app_type = </span>
//                             <span><i><u>'.$val.'</u></i></span>
//                         </div>

//                         <div>
//                             AND <span> app_name = </span>
//                             <span><i><u>'.$searchName.'</u></i></span>
//                         </div>
//                     </h3>';            
        } else {
            $sql =
                'SELECT * FROM Ownership
                WHERE app_type LIKE "'.$search.'%"';
            
//             if( $search === '' ) {
//                 echo 
//                     '<h3>
//                         <div>
//                             SELECT <span> * </span> FROM <span> Ownership </span>
//                         </div>
//                     </h3>';
//             } else {
//                 echo 
//                     '<h3>
//                         <div>
//                             SELECT <span> * </span> FROM <span> Ownership </span>
//                         </div>
                        
//                         <div>
//                             WHERE <span> app_type = </span>
//                             <span><i><u>'.$search.'</u></i></span>
//                         </div>
//                     </h3>';
//             }
        }

        $data = $GLOBALS['db'] -> query( $sql );

        return $data;
    }
?>
