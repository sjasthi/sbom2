<?php
    /**
     * Project: FP3
     * Name: Shahid Iqbal, Isaac Hentges, Nathan Lantaigne-Goetsch, Abdulsalam Geddi
     *
     * The apiUtility class is for various helper functions for the php pages.
     */
    require("./apiUtility.php");

    if(isset($_GET['app_name'])) {
        $app_name = $_GET['app_name'];//json_decode($_GET['app_name']);
    }

    if(!empty($app_name) && preg_match('/^[\d A-Za-z +:-]*$/', $app_name)) {
        $apiFunctions = new apiUtility();
        $processor = $apiFunctions->get_owner_app_name($app_name);
        $data = [];
        $count = 0;
        if($processor!==false && $processor->num_rows > 0) {
            $count = $processor->num_rows;
            while($row  = $processor->fetch_assoc()){
                $data[] = $row;
            }
        }

        $res = [];
        response(200, $count, $app_name, $data);
    }
    else if (isset($app_name) && empty($app_name)) {
        invalidResponse("Invalid or Empty input");
    }
    else {
        invalidResponse("Invalid Request");
    }

    function invalidResponse($message) {
        response(400, $message, NULL, NULL);
    }

    function response($responseCode, $message, $string, $data) {
        // Locally cache results for two hours
        header('Cache-Control: max-age=7200');

        // JSON Header
        header('Content-type:application/json;charset=utf-8');

        http_response_code($responseCode);
        $response = array("response_code" => $responseCode, "Records" => $message, "Parameter Value" => $string, "data" => $data);
        $json = json_encode($response, JSON_PRETTY_PRINT);
        echo $json;
    }

?>