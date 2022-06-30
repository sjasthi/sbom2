<?php
    /**
     * Purpose: API module get_security_summary.php provides information about the application id,
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
     * http://localhost/sbom2/api/get_security_summary.php?component_id=7023876
     * http://localhost/sbom2/api/get_security_summary.php?component_name=apa
     * http://localhost/sbom2/api/get_security_summary.php?component_id=7076759&component_version=7.9%20%289%29
     *
     * http://localhost/sbom2/api/get_security_summary.php?app_name=General
     * http://localhost/sbom2/api/get_security_summary.php?app_id=76074884
     * http://localhost/sbom2/api/get_security_summary.php?app_name=General&app_version=96.9
     *
     * @author Shahid Iqbal, Isaac Hentges, Nathan Lantaigne-Goetsch, Abdulsalam Geddi
     *
     * The apiUtility class is for various helper functions for the php pages.
     */
    require("./apiUtility.php");

    /**
     *      get_security_summary with component_id, component_name, component_version
     */
    if (isset($_GET['component_id'], $_GET['component_version'])) {
        $component_id = $_GET['component_id'];
        $component_version = $_GET['component_version'];

        if((!empty($component_id) && preg_match('/^[\d A-Za-z +:-]*$/', $component_id)) &&
            (!empty($component_version) && preg_match('/^[\d\/A-Za-z\-.,_)( ]*$/', $component_version))) {
            $apiFunctions = new apiUtility();
            $processor = $apiFunctions->get_security_summary_id_version($component_id, $component_version);
            $data = [];
            $count = 0;
            if($processor->num_rows > 0) {
                $count = $processor->num_rows;
                while($row  = $processor->fetch_assoc()){
                    $data[] = $row;
                }
            }
            response(200, $count, $component_id . ", " . $component_version, $data);
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
            $processor = $apiFunctions->get_security_summary_id($component_id);
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
            $processor = $apiFunctions->get_security_summary_name($component_name);
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

    /**
     *      get_security_summary with app_id, app_name, app_version
     */
    else if (isset($_GET['app_name'], $_GET['app_version'])) {
        $app_name = $_GET['app_name'];
        $app_version = $_GET['app_version'];

        if((!empty($app_name) && preg_match('/^[\d A-Za-z +:-]*$/', $app_name)) &&
            (!empty($app_version) && preg_match('/^[\d.,_v ]*$/', $app_version))) {
            $apiFunctions = new apiUtility();
            $processor = $apiFunctions->get_security_summary_app_name_version($app_name, $app_version);
            $data = [];
            $count = 0;
            if($processor->num_rows > 0) {
                $count = $processor->num_rows;
                while($row  = $processor->fetch_assoc()){
                    $data[] = $row;
                }
            }
            response(200, $count, $app_name . ", " . $app_version, $data);
        }

        else if (isset($app_name, $app_version) && empty($app_name) && empty($app_version)) {
            invalidResponse("Invalid or Empty input");
        }

        else {
            invalidResponse("Invalid Request");
        }
    }

    else if (isset($_GET['app_id'])) {
        $app_id = $_GET['app_id'];

        if (!empty($app_id) && preg_match('/^\d*$/', $app_id)) {
            $apiFunctions = new apiUtility();
            $processor = $apiFunctions->get_security_summary_app_id($app_id);
            $data = [];
            $count = 0;
            if ($processor->num_rows > 0) {
                $count = $processor->num_rows;
                while ($row = $processor->fetch_assoc()) {
                    $data[] = $row;
                }
            }
            response(200, $count, $app_id, $data);
        }
        else if (isset($app_id) && empty($app_id)) {
            invalidResponse("Invalid or Empty input");
        }
        else {
            invalidResponse("Invalid Request");
        }
    }

    else if (isset($_GET['app_name'])) {
        $app_name = $_GET['app_name'];

        if(!empty($app_name) && preg_match('/^[\d A-Za-z +:-]*$/', $app_name)) {
            $apiFunctions = new apiUtility();
            $processor = $apiFunctions->get_security_summary_app_name($app_name);
            $data = [];
            $count = 0;
            if($processor!==false && $processor->num_rows > 0) {
                $count = $processor->num_rows;
                while($row  = $processor->fetch_assoc()){
                    $data[] = $row;
                }
            }
            response(200, $count, $app_name, $data);
        }
        else if (isset($app_name) && empty($app_name)) {
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