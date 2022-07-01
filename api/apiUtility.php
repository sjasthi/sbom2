<?php
    /**
     * Project: FP3
     * Name: Shahid Iqbal, Isaac Hentges, Nathan Lantaigne-Goetsch, Abdulsalam Geddi
     *
     * The apiUtility class is for various helper functions for the php pages.
     */
    include '../src/db/connect.php';

    class apiUtility
    {

        // Begin get_bomlines_status functions
        /**
         * @param $app_id
         *
         * @return bool|mysqli_result
         */
        public function get_bom_status_id($app_id){
            global $db;
            $sql = "SELECT status FROM apps_components
                                  WHERE app_id = $app_id
                                  AND status != 'Approved' ";
            $result= $db->query($sql);
            if ($result->num_rows > 0) {
                echo "Status Open";
            }
                else {
                echo "Status Approved";
        }
    }


        /**
         * @param $app_name
         * @param $app_version
         *
         * @return bool|mysqli_result
         */
        public function get_bom_status_name_version($app_name, $app_version){
            global $db;
            $sql = "SELECT status FROM apps_components
                                  WHERE app_name LIKE '$app_name%'
                                  AND app_version LIKE '$app_version%'
                                  AND status != 'Approved' ";
            $result= $db->query($sql);
            if ($result->num_rows > 0) {
                echo "Status Open";
            }
                else {
                    echo "Status Approved";
        }
        }

         /**
         * @param app_name
         *
         * @return bool|mysqli_result
         */
        public function get_bom_status_name($app_name){
            global $db;
            $sql = "SELECT status FROM apps_components
                                  WHERE app_name LIKE '$app_name%'
                                  AND status != 'Approved' ";
            $result= $db->query($sql);
            if ($result->num_rows > 0) {
                echo "Status Open";
            }
                else {
                    echo "Status Approved";
        }
        }
        

        // Begin get_bomlines_pending functions
        /**
         * @param $app_id
         *
         * @return bool|mysqli_result
         */
        public function get_bomlines_pending_id($app_id){
            global $db;
            $sql = "SELECT * FROM apps_components
                             WHERE app_id = $app_id
                             AND status != 'Approved' ";
            return $db->query($sql);
        }


        /**
         * @param $app_name
         * @param $app_version
         *
         * @return bool|mysqli_result
         */
        public function get_bomlines_pending_name_version($app_name, $app_version){
            global $db;
            $sql = "SELECT * FROM apps_components
                             WHERE app_name LIKE '$app_name%'
                             AND app_version LIKE '$app_version%'
                             AND status != 'Approved' ";
            return $db->query($sql);
        }

         /**
         * @param app_name
         *
         * @return bool|mysqli_result
         */
        public function get_bomlines_pending_name($app_name){
            global $db;
            $sql = "SELECT * FROM apps_components
                             WHERE app_name LIKE '$app_name%'
                             AND status != 'Approved' ";
            return $db->query($sql);
        }


        // Begin is_safe functions
        /**
         * @param $component_id
         *
         * @return bool|mysqli_result
         */
        public function is_safe_id($component_id) {
            global $db;
            $sql = "SELECT DISTINCT cmpt_id, cmpt_name, cmpt_version, issue_count FROM apps_components 
                                                                       WHERE cmpt_id = $component_id 
                                                                       AND issue_count = 0";
            return $db->query($sql);
        }

        /**
         * @param $component_name
         * @param $component_version
         *
         * @return bool|mysqli_result
         */
        public function is_safe_name_version($component_name, $component_version) {
            global $db;
            $sql = "SELECT DISTINCT cmpt_id, cmpt_name, cmpt_version, issue_count FROM apps_components 
                                                                       WHERE cmpt_name LIKE '$component_name%' 
                                                                       AND cmpt_version = '$component_version' 
                                                                       AND issue_count = 0";
            return $db->query($sql);
        }

        /**
         * @param $component_name
         *
         * @return bool|mysqli_result
         */
        public function is_safe_name($component_name) {
            global $db;
            $sql = "SELECT DISTINCT cmpt_id, cmpt_name, cmpt_version, issue_count FROM apps_components WHERE cmpt_name LIKE '$component_name%' 
                                                                                              AND issue_count = 0";
            return $db->query($sql);
        }

        // Begin get_security_summary functions with component_id, component_name, component_version
        /**
         * @param $component_id
         *
         * @return bool|mysqli_result
         */
        public function get_security_summary_id($component_id) {
            global $db;
            $sql = "SELECT cmpt_id, cmpt_name, cmpt_version, monitoring_id, monitoring_digest, issue_count FROM apps_components 
                                                                       WHERE cmpt_id = $component_id AND issue_count > 0";
            return $db->query($sql);
        }

        /**
         * @param $component_id
         * @param $component_version
         *
         * @return bool|mysqli_result
         */
        public function get_security_summary_id_version($component_id, $component_version) {
            global $db;
            $sql = "SELECT cmpt_id, cmpt_name, cmpt_version, monitoring_id, monitoring_digest, issue_count FROM apps_components 
                                                                       WHERE cmpt_id = '$component_id' 
                                                                       AND cmpt_version = '$component_version'
                                                                       AND issue_count > 0";
            return $db->query($sql);
        }

        /**
         * @param $component_name
         *
         * @return bool|mysqli_result
         */
        public function get_security_summary_name($component_name) {
            global $db;
            $sql = "SELECT cmpt_id, cmpt_name, cmpt_version, monitoring_id, monitoring_digest, issue_count FROM apps_components WHERE cmpt_name LIKE '$component_name%'
                                                                                                                                AND issue_count > 0";
            return $db->query($sql);
        }

        // Begin get_security_summary with app_id

        /**
         * @param $component_id
         *
         * @return bool|mysqli_result
         */
        public function get_security_summary_app_id($app_id) {
            global $db;
            $sql = "SELECT * FROM apps_components WHERE red_app_id = $app_id AND issue_count > 0";
            return $db->query($sql);
        }

        /**
         * @param $app_id
         * @param $app_version
         *
         * @return bool|mysqli_result
         */
        public function get_security_summary_app_name_version($app_name, $app_version) {
            global $db;
            $sql = "SELECT * FROM apps_components WHERE app_name LIKE '$app_name%' AND app_version = '$app_version' AND issue_count > 0";
            return $db->query($sql);
        }

        /**
         * @param $app_name
         *
         * @return bool|mysqli_result
         */
        public function get_security_summary_app_name($app_name) {
            global $db;
            $sql = "SELECT * FROM apps_components WHERE app_name LIKE '$app_name%' AND issue_count > 0";
            return $db->query($sql);
        }

        // Begin getWhereUsed functions
        /**
         * getWhereUsed_id returns components based on cmpt_id parameter.
         * @param $component_id
         *
         * @return bool|mysqli_result
         */

        public function getWhereUsed_id($component_id) {
            global $db;
            $sql = "SELECT cmpt_id, cmpt_name, cmpt_version,app_id, app_name, app_version FROM apps_components WHERE cmpt_id = $component_id";
            return $db->query($sql);
        }

        /**
         * getWhereUsed_name_version returns components based on cmpt_name and cmpt_version parameters.
         * @param $component_name
         * @param $component_version
         *
         * @return bool|mysqli_result
         */
        public function getWhereUsed_name_version($component_name, $component_version) {
            global $db;
            $sql = "SELECT cmpt_id, cmpt_name, cmpt_version,app_id, app_name, app_version FROM apps_components 
                                   WHERE cmpt_name LIKE '%$component_name%' AND cmpt_version = '$component_version'";
            return $db->query($sql);
        }

        /**
         * @param $component_name
         *
         * @return bool|mysqli_result
         */
        public function getWhereUsed_name($component_name) {
            global $db;
            $sql = "SELECT cmpt_id, cmpt_name, cmpt_version,app_id, app_name, app_version FROM apps_components WHERE cmpt_name LIKE '%$component_name%'";
            return $db->query($sql);
        }

        /**
        Get the application owner given an app id
         * @param $app_id
         *
         * @return bool|mysqli_result
         */
        public function get_owner_app_id($app_id) {
            global $db;

            $sql = "SELECT app_owner FROM `ownership` WHERE EXISTS\n"

    . "(SELECT app_name FROM `applications` WHERE app_id = \"$app_id\" and ownership.app_name = app_name);";
            return $db->query($sql);
        }

        /**
        Get the application owner given an app name
         * @param $app_name
         *
         * @return bool|mysqli_result
         */
        public function get_owner_app_name($app_name) {
            global $db;
            $sql = "SELECT app_owner
            FROM ownership
            WHERE app_name = '$app_name'";
            return $db->query($sql);
        }

        /**
        Get the requester given an component id
         * @param $app_id
         *
         * @return bool|mysqli_result
         */
        public function get_owner_component_id($component_id) {
            global $db;
            $sql = "SELECT requester 
            FROM apps_components 
            WHERE cmpt_id = '$component_id'";
            return $db->query($sql);
        }

        /**
        Get the requester given an component name
         * @param $app_name
         *
         * @return bool|mysqli_result
         */
        public function get_owner_component_name($component_name) {
            global $db;
            $sql = "SELECT requester 
            FROM apps_components 
            WHERE cmpt_name = '$component_name'";
            return $db->query($sql);
        }


        /**
        Get the requester given an component version
         * @param $app_name
         *
         * @return bool|mysqli_result
         */
        public function get_owner_component_version($component_version) {
            global $db;
            $sql = "SELECT requester 
            FROM apps_components 
            WHERE cmpt_version = '$component_version'";
            return $db->query($sql);
        }

        // Begin get_bom_list functions
        /**
         * get_bom_list returns rows based on red_app_id parameter.
         * @param $app_id
         *
         * @return bool|mysqli_result
         */
        public function get_bom_list_id($app_id) {
            global $db;
            $sql = "SELECT * FROM apps_components WHERE app_id =  $app_id";
            return $db->query($sql);
        }

        /**
         * get_bom_list returns rows based on app_name parameter.
         * @param $app_name
         *
         * @return bool|mysqli_result
         */
        public function get_bom_list_name($app_name) {
            global $db;
            $sql = "SELECT * FROM apps_components WHERE app_name LIKE '%$app_name%'";
            return $db->query($sql);
        }

        /**
         * get_bom_list_name_version returns rows based on app_name and app_version parameters.
         * @param $app_name
         * @param $app_version
         *
         * @return bool|mysqli_result
         */
        public function get_bom_list_name_version($app_name, $app_version) {
            global $db;
            $sql = "SELECT * FROM apps_components 
                                   WHERE app_name LIKE '%$app_name%' AND app_version = '$app_version'";
            return $db->query($sql);
        }

        // Begin get_bom_list_unique functions
        /**
         * get_bom_list_unique returns rows based on app_id parameter.
         * @param $app_id
         *
         * @return bool|mysqli_result
         */

        public function get_bom_list_unique_id($app_id) {
            global $db;
            $sql = "SELECT DISTINCT * FROM apps_components WHERE app_id =  $app_id GROUP BY `cmpt_name`";
            return $db->query($sql);
        }

        /**
         * get_bom_list_unique_name returns rows based on app_name parameter
         * @param $app_name
         *
         * @return bool|mysqli_result
         */
        public function get_bom_list_unique_name($app_name) {
            global $db;
            $sql = "SELECT DISTINCT * FROM apps_components WHERE app_name LIKE '%$app_name%' GROUP BY `cmpt_name`";
            return $db->query($sql);
        }

        /**
         * get_bom_list_unique_name_version returns rows based on app_name and app_version parameters.
         * @param $app_name
         * @param $app_version
         *
         * @return bool|mysqli_result
         */
        public function get_bom_list_unique_name_version($app_name, $app_version) {
            global $db;
            $sql = "SELECT DISTINCT * 
                    FROM apps_components 
                    WHERE app_name LIKE '%$app_name%' AND app_version = '$app_version' 
                    GROUP BY `cmpt_name`";
            return $db->query($sql);
        }

        // Begin get_bom_list_duplicate functions
        /**
         * get_bom_list_unique returns rows based on app_id parameter.
         * @param $app_id
         *
         * @return bool|mysqli_result
         */

        public function get_bom_list_duplicate_id($app_id) {
            global $db;
            $sql = "SELECT * 
                    FROM apps_components 
                    WHERE app_id = $app_id AND cmpt_name IN    (SELECT `cmpt_name` 
                            FROM `apps_components` 
                            WHERE app_id = $app_id 
                            GROUP BY `cmpt_name` 
                            HAVING COUNT(`cmpt_name`) > 1) ORDER BY `cmpt_name`";
            return $db->query($sql);
        }

        /**
         * get_bom_list_duplicate_name returns rows based on app_name parameter
         * @param $app_name
         *
         * @return bool|mysqli_result
         */
        public function get_bom_list_duplicate_name($app_name) {
            global $db;
            $sql = "SELECT * 
                    FROM apps_components 
                    WHERE app_name LIKE '%$app_name%' AND        cmpt_name IN
                            (SELECT `cmpt_name` 
                            FROM `apps_components` 
                            WHERE app_name LIKE         '%$app_name%' 
                            GROUP BY `cmpt_name` 
                            HAVING COUNT(`cmpt_name`) > 1)
                            ORDER BY `cmpt_name`";
            return $db->query($sql);
        }

        /**
         * get_bom_list_duplicate_name_version returns rows based on app_name and app_version parameters.
         * @param $app_name
         * @param $app_version
         *
         * @return bool|mysqli_result
         */
        public function get_bom_list_duplicate_name_version($app_name, $app_version) {
            global $db;
            $sql = "SELECT * 
                    FROM apps_components 
                    WHERE app_name LIKE '%$app_name%' 
                    AND   app_version = '$app_version' AND   cmpt_name IN
                            (SELECT `cmpt_name` 
                            FROM `apps_components` 
                            WHERE app_name LIKE '%$app_name%' AND app_version = '$app_version' 
                            GROUP BY `cmpt_name` 
                            HAVING COUNT(`cmpt_name`) > 1)
                            ORDER BY `cmpt_name`";
            return $db->query($sql);
        }

    }