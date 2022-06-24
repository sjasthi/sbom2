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
        // Begin is_safe functions
        /**
         * @param $component_id
         *
         * @return bool|mysqli_result
         */
        public function is_safe_id($component_id) {
            global $db;
            $sql = "SELECT cmpt_id, cmpt_name, cmpt_version, issue_count FROM apps_components 
                                                                       WHERE cmpt_id = $component_id";
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
            $sql = "SELECT cmpt_id, cmpt_name, cmpt_version, issue_count FROM apps_components 
                                                                       WHERE cmpt_name = '$component_name' AND cmpt_version = '$component_version'";
            return $db->query($sql);
        }

        /**
         * @param $component_name
         *
         * @return bool|mysqli_result
         */
        public function is_safe_name($component_name) {
            global $db;
            $sql = "SELECT cmpt_id, cmpt_name, cmpt_version, issue_count FROM apps_components WHERE cmpt_name = '$component_name'";
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
            $sql = "SELECT app_id,app_name,app_version FROM apps_components WHERE cmpt_id = $component_id";
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
            $sql = "SELECT app_id,app_name,app_version FROM apps_components 
                                   WHERE cmpt_name = '$component_name' AND cmpt_version = '$component_version'";
            return $db->query($sql);
        }

        /**
         * @param $component_name
         *
         * @return bool|mysqli_result
         */
        public function getWhereUsed_name($component_name) {
            global $db;
            $sql = "SELECT app_id,app_name,app_version FROM apps_components WHERE cmpt_name = '$component_name'";
            return $db->query($sql);
        }

        /**
         * @param $app_id
         *
         * @return bool|mysqli_result
         */
        public function get_owner_app_id($app_id) {
            global $db;
            $app_id = json_decode($app_id);
            $sql = "SELECT app_owner 
            FROM `ownership` 
            WHERE EXISTS\n". 
            "(SELECT app_name FROM `applications` WHERE app_id = \"$app_id\" and ownership.app_name = app_name);";
            return $db->query($sql);
        }

        /**
         * @param $app_name
         *
         * @return bool|mysqli_result
         */
        public function get_owner_app_name($app_name) {
            global $db;
            echo "$app_name";
            $sql = "SELECT app_owner
            FROM ownership
            WHERE app_owner = '$app_name'";
            return $db->query($sql);
        }

    }