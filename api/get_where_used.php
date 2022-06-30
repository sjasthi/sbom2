<?php
    /**
     * Purpose: API module get_where_used.php provides information about the application id,
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
     * http://localhost/sbom2/api/get_where_used.php?component_id=779496
     * http://localhost/sbom2/api/get_where_used.php?component_name=Commons IO
     * http://localhost/sbom2/api/get_where_used.php?component_name=LT
     * http://localhost/sbom2/api/get_where_used.php?component_name=General Te&component_version=96.9
     * http://localhost/sbom2/api/get_where_used.php?component_name=lt&component_version=9.9
     *
     * @author Shahid Iqbal, Isaac Hentges, Nathan Lantaigne-Goetsch, Abdulsalam Geddi
     *
     * The apiUtility class is for various helper functions for the php pages.
     */
    require("./apiUtility.php");

    if (isset($_GET['component_name'], $_GET['component_version'])) {
        $component_name = $_GET['component_name'];
        $component_version = $_GET['component_version'];

        if((!empty($component_name) && preg_match('/^[\d A-Za-z +:-]*$/', $component_name)) &&
            (!empty($component_version) && preg_match('/^[\d\/A-Za-z\-.,_)( ]*$/', $component_version))) {
            $apiFunctions = new apiUtility();
            $processor = $apiFunctions->getWhereUsed_name_version($component_name, $component_version);
            $data = [];
            $count = 0;
            // Number of rows returned by the query
            if($processor->num_rows > 0) {
                $count = $processor->num_rows;
                while($row  = $processor->fetch_assoc()){
                    $data[] = $row;
                }
            }
            response(200, $count, $component_name . ", " . $component_version, $data);
        }

        else if (isset($component_name, $component_version) && empty($component_name) && empty($component_version)) {
            invalidResponse("Invalid or Empty input");
        }

        else {
            invalidResponse("Invalid Request");
        }
    }

    else if (isset($_GET['component_id'])) {
        $component_id = $_GET['component_id'];

        if (!empty($component_id) && preg_match('/^\d*$/', $component_id)) {
            $apiFunctions = new apiUtility();
            $processor = $apiFunctions->getWhereUsed_id($component_id);
            $data = [];
            $count = 0;
            if ($processor->num_rows > 0) {
                $count = $processor->num_rows;
                while ($row = $processor->fetch_assoc()) {
                    $data[] = $row;
                }
            }
            response(200, $count, $component_id, $data);
        }
        else if (isset($component_id) && empty($component_id)) {
            invalidResponse("Invalid or Empty input");
        }
        else {
            invalidResponse("Invalid Request");
        }
    }

    else if (isset($_GET['component_name'])) {
        $component_name = $_GET['component_name'];

        if(!empty($component_name) && preg_match('/^[\d A-Za-z +:-]*$/', $component_name)) {
            $apiFunctions = new apiUtility();
            $processor = $apiFunctions->getWhereUsed_name($component_name);
            $data = [];
            $count = 0;
            if($processor!==false && $processor->num_rows > 0) {
                $count = $processor->num_rows;
                while($row  = $processor->fetch_assoc()){
                    $data[] = $row;
                }
            }
            response(200, $count, $component_name, $data);
        }
        else if (isset($component_name) && empty($component_name)) {
            invalidResponse("Invalid or Empty input");
        }
        else {
            invalidResponse("Invalid Request");
        }
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