<?php

$connection = new mysqli ("localhost", "root", "", "sbom");

if(!empty($_GET['id'])){//given app_id
     $sql = "SELECT requester
     FROM apps_components
     WHERE `app_id` = $_GET[id];";
}
elseif(!empty($_GET['id']) && !empty($_GET['version'])){//given app_id & app_version
     $sql = "SELECT requester
     FROM apps_components
     WHERE `app_id` = $_GET[id] and `app_version` = $_GET[version]'";
}
elseif(!empty($_GET['name'])){//given app_name
     $sql = "SELECT requester
     FROM apps_components;";
}
else {//error response if the given input does not match above
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
    	$uses = "Requester: ".$item['requester']."\n";
    	echo $uses."<br>";
    }
}