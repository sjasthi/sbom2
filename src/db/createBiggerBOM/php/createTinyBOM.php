
<?php
    function createTinyBOM() { // creates 10 rows that are copied
        $addSQL = file_get_contents('sql/app_components.sql');

        $GLOBALS['db'] -> query( "DROP TABLE `apps_components`" );
        $GLOBALS['db'] -> query(
            "CREATE TABLE `apps_components` (
                `line_id` int(10) NOT NULL,
                `red_app_id` varchar(10) NOT NULL,
                `cmpt_id` varchar(10) NOT NULL,
                `cmpt_name` varchar(100) NOT NULL,
                `cmpt_version` varchar(50) NOT NULL,
                `app_id` varchar(100) NOT NULL,
                `app_name` varchar(10) NOT NULL,
                `app_version` varchar(50) NOT NULL,
                `license` varchar(120) DEFAULT NULL,
                `status` varchar(10) DEFAULT NULL,
                `requester` varchar(50) DEFAULT NULL,
                `monitoring_id` varchar(10) DEFAULT NULL,
                `monitoring_digest` varchar(100) DEFAULT NULL,
                `issue_count` int(3) DEFAULT NULL
            )"
        );
        $GLOBALS['db'] -> query( $addSQL );

        $getSQL = 'SELECT * FROM apps_components LIMIT 100';
        $data = $GLOBALS['db'] -> query( $getSQL );

        return createNewList( grabList( $data ) );
    }
?>
