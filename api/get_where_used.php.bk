<?php

$connection = new mysqli ("localhost", "root", "", "sbom");

if(!empty($_GET['id'])){
     $sql = "SELECT app_id,app_name,app_version
     FROM apps_components
     WHERE `cmpt_id` = $_GET[id];";
}
elseif(!empty($_GET['name']) && !empty($_GET['version'])){
     $sql = "SELECT app_id,app_name,app_version
     FROM apps_components
     WHERE `cmpt_name` = '$_GET[name]' and `cmpt_version` = '$_GET[version]'";
}
elseif(!empty($_GET['name'])){
     $sql = "SELECT app_id,app_name,app_version
     FROM apps_components
     WHERE `cmpt_name` = '$_GET[name]'";
}
else {
     $error = array("error" => "Invalid input");
     echo json_encode($error);
     exit;
}



$result = $connection->query($sql);

if($result->num_rows == 0){
     $input = implode(",", $_GET);
     $error = array("error" => $input." Not found.");
     echo json_encode($error);
     exit;
}

$apps = array();

while ($app = $result->fetch_assoc()){
     $apps[] = $app;
}

echo json_encode($apps)."<br>";
printArray($apps);	//The function to print each row from the $apps result

//Prints out each data entry from the $apps on its own line(function to read data easier)
function printArray( $array ){
	foreach($array as $item) {
    	$uses = "app_id:".$item['app_id']."\napp_name:".$item['app_name']."\napp_version:".$item['app_version'];
    	echo $uses."<br>";
    }
}



function to_utf8( $string ) {
// From http://w3.org/International/questions/qa-forms-utf-8.html
    if ( preg_match('%^(?:
      [\x09\x0A\x0D\x20-\x7E]            # ASCII
    | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
    | \xE0[\xA0-\xBF][\x80-\xBF]         # excluding overlongs
    | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
    | \xED[\x80-\x9F][\x80-\xBF]         # excluding surrogates
    | \xF0[\x90-\xBF][\x80-\xBF]{2}      # planes 1-3
    | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
    | \xF4[\x80-\x8F][\x80-\xBF]{2}      # plane 16
)*$%xs', $string) ) {
        return $string;
    } else {
        return iconv( 'CP1252', 'UTF-8', $string);
    }
}

?>

