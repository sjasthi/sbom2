<?php
    /**
     * Purpose: API module get_requester_count.php provides information about the number
     * of applications being requested by each requester in the database(specific to apps_components)
     *
     *
     *
     * SAMPLE INPUT
     * Retrieves all applications requested by each requester in apps_components
     * http://localhost/sbom2/api/get_requester_count.php
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

    $apiFunctions = new apiUtility();
    $processor = $apiFunctions->get_requester_count();
    $data = [];
    $count = 0;
    if($processor!==false && $processor->num_rows > 0) {
        $count = $processor->num_rows;
        while($row  = $processor->fetch_assoc()){
            $data[] = $row;
        }
    } else{
        invalidResponse("Empty Database");
    }
    $res = [];
    response(200, $count, $component_id, $data);

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

    /*
    if(isset($_GET['component_id'])) {
        $component_id = $_GET['component_id'];

        if(!empty($component_id) && preg_match('/^\d*$/', $component_id)) {
            $apiFunctions = new apiUtility();
            $processor = $apiFunctions->get_owner_component_id($component_id);
            $data = [];
            $count = 0;
            if($processor!==false && $processor->num_rows > 0) {
                $count = $processor->num_rows;
                while($row  = $processor->fetch_assoc()){
                    $data[] = $row;
                }
            }
            $res = [];
            response(200, $count, $component_id, $data);
        }
        else if (isset($component_id) && empty($component_id)) {
            invalidResponse("Invalid or Empty input");
        }
        else {
            invalidResponse("Invalid Request");
        }
    } else{
        invalidResponse("Invalid Request");
    }
    */