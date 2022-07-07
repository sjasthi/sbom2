<?php
    /**
     * Purpose: API module is_safe.php provides information about the application id,
     *          application name, and application version given component information.
     *
     * Input:   supported input parameters are 'component_name, 'component_id'. Both the
     *          parameters can be used as a single input or passed as a combined unit.
     *          component_id = digits only.
     *          component_name = Alpha,digits, space and certain special characters.
     *          component_version = digits, space and certain special characters
     *
     * Output:  The module outputs data as a json object. The json object also includes HTTP
     *          response code and count of rows parameters passed and data name value pairs.
     *
     * Error Conditions: response code of http 400 is generated when system detects an error condition.
     *                   component_id, component_name, component_version can generate "Invalid request"
     *                   or "Invalid or empty request" for unsupported characters.
     *
     * Sample URL INPUTS:
     * http://localhost/sbom2/api/is_safe.php?component_id=77960664
     * http://localhost/sbom2/api/is_safe.php?component_name=kassandra%20HttpClient
     * http://localhost/sbom2/api/is_safe.php?component_name=kassandra%20HttpClient&component_version=4.5.96%20%289%29
     *
     * http://localhost/sbom2/api/is_safe.php?component_name=Commons IO&component_version=7.5
     *
     * @author Shahid Iqbal, Isaac Hentges, Nathan Lantaigne-Goetsch, Abdulsalam Geddi
     *
     * The apiUtility class is for various helper functions for the php pages.
     */
    require("./apiUtility.php");

    $apiFunctions = new apiUtility();
    $processor = $apiFunctions->get_requester_pending_tasks();
    $data = [];
    $count = 0;
    if($processor->num_rows > 0) {
        $count = $processor->num_rows;
        while($row  = $processor->fetch_assoc()){
            $data[] = $row;
        }
        response(200, $count, "Not Supported.", $data);
    }
    else {
        response(200, $count, null, null);
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