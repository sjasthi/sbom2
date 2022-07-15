<?php
    /**
     * Purpose: This API module get_green_unique_names.php lists just the green component names. Unique names.
     * Component version is ignored.
     * 
     * Input:  This API doesnt take any input paramaters. It displays all the unique green component names in the database
     *
     * Sample URL
     * http://localhost/sbom2/api/get_green_unique_names.php
     *
     * @author Shahid Iqbal, Isaac Hentges, Nathan Lantaigne-Goetsch, Abdulsalam Geddi
     *
     * The apiUtility class is for various helper functions for the php pages.
     */
    require("./apiUtility.php");

    $apiFunctions = new apiUtility();

     $processor = $apiFunctions->get_green_unique_names();
     $data = [];
     $count = 0;

     // Number of rows returned by the query
     if($processor->num_rows > 0) {
          $count = $processor->num_rows;
          while($row  = $processor->fetch_assoc()){
          $data[] = $row;
          }
     }
     response(200, $count, ", " , $data);

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