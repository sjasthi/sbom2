<?php
    /**
     * Purpose: API module get_where_used.php provides information about the application id,
     *          application name, and application version given component information.
     *
     * Input:   supported input parameters are 'app_name, 'app_id'. Both the
     *          parameters can be used as a single input or passed as a combined unit.
     *          app_id = digits only.
     *          app_name = Alpha,digits, space and certain special characters.
     *
     * SAMPLE URL INPUTS
     * http://localhost/sbom2/api/get_owner_by_app.php?app_id=76074884
     * http://localhost/sbom2/api/get_owner_by_app.php?app_id=944965237
     * http://localhost/sbom2/api/get_owner_by_app.php?app_name=LTS JSON L
     * http://localhost/sbom2/api/get_owner_by_app.php?app_name=Techno Com
     * Output:  The module outputs data as a json object. The json object also includes HTTP
     *          response code and count of rows parameters passed and data name value pairs.
     *
     * Error Conditions: response code of http 400 is generated when system detects an error condition.
     *                   component_id, component_name, component_version can generate "Invalid request"
     *                   or "Invalid or empty request" for unsupported characters.
     *
     * @author Shahid Iqbal, Isaac Hentges, Nathan Lantaigne-Goetsch, Abdulsalam Geddi
     *
     * The apiUtility class is for various helper functions for the php pages.
     */
    require("./apiUtility.php");

    if(isset($_GET['app_id'])) {
        $app_id = $_GET['app_id'];

        if(!empty($app_id) && preg_match('/^\d*$/', $app_id)) {
            $apiFunctions = new apiUtility();
            $processor = $apiFunctions->get_owner_app_id($app_id);
            $data = [];
            $count = 0;
            if($processor!==false && $processor->num_rows > 0) {
                $count = $processor->num_rows;
                while($row  = $processor->fetch_assoc()){
                    $data[] = $row;
                }
            }
            $res = [];
            response(200, $count, $app_id, $data);
        }
        else if (isset($app_id) && empty($app_id)) {
            invalidResponse("Invalid or Empty input");
        }
        else {
            invalidResponse("Invalid Request");
        }
    } else if(isset($_GET['app_name'])) {
        $app_name = $_GET['app_name'];

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
    } else {
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