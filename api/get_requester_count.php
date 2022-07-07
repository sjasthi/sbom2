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
     *                   No data in the apps_components table n can generate "Empty Database"
     *                   message.
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
