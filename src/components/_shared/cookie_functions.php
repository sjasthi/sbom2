<?php

$bom_app_set_cookie_name = "my_app_set";

// Get the client's cookie appset string
function get_user_appset_cookie_string(){
  global $bom_app_set_cookie_name;
  return $_COOKIE[$bom_app_set_cookie_name];
}

// Set the client's cookie appset string
function setUserAppSetCookies($apps){
  global $bom_app_set_cookie_name;
  $app_string = implode(',', $apps);
  setcookie($bom_app_set_cookie_name, $app_string, 2147483647, "/");
  // echo $app_string;
}

?>