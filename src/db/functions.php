<?php

$sql_applications_query = "
  SELECT * FROM applications
";

$sql_bom_query = "
  SELECT * FROM apps_components;
";

$system_appset_pref_name = "ACTIVE_APP_SET";

function getScope ($db){
    $sql = "SELECT * FROM preferences WHERE name = 'SYSTEM_BOMS';";
    $result = $db->query($sql);
    $output = array('NULL');

    // output data of each row
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $prefString = $row["value"];

      if(!empty(trim($prefString))){
        $output = explode(",", $prefString);
      }
    }

    foreach($output as &$value){
      $value = "%$value%";
    }

    $result->close();

    return $output;
}

function setSystemAppSet($db, $app_set_id){
  global $system_appset_pref_name;
  $sql_update_system_appset = '
    UPDATE preferences
    SET value = ?
    WHERE name = "'.$system_appset_pref_name.'";
  ';
  $query_update_appsets = $db->prepare($sql_update_system_appset);
  $query_update_appsets->bind_param('s', $app_set_id);
  return $query_update_appsets->execute();
}

// Is this correct? Function is named delete, but query is only a select?
function deleteSystemAppSet($db, $app_set_id){
  global $system_appset_pref_name;
  $sql_delete_system_appset = '
    DELETE FROM app_sets
    WHERE app_set_id = '.$app_set_id.';
  ';
  return $db->query($sql_delete_system_appset);
}

function getSystemAppSetName($db){
  global $system_appset_pref_name;
  $sql_get_system_app_set_name = '
    SELECT app_set_name FROM app_sets
    WHERE app_set_id IN
    ( SELECT value FROM preferences WHERE name = "ACTIVE_APP_SET");
  ';
  $name_result = $db->query($sql_get_system_app_set_name);
  $name_associative = $name_result->fetch_all(MYSQLI_ASSOC);
  if (isset($name_associative[0]['app_set_name'])) {
		return $name_associative[0]['app_set_name'];
	} else {
    return "Not Set";
	}
}

function url_for($script_path) {
  // add the leading '/' if not present
  if($script_path[0] != '/') {
    $script_path = "/" . $script_path;
  }
  return WWW_ROOT . $script_path;
}

function u($string="") {
  return urlencode($string);
}

function raw_u($string="") {
  return rawurlencode($string);
}

function h($string="") {
  return htmlspecialchars($string);
}

function error_404() {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
  exit();
}

function error_500() {
  header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
  exit();
}

function redirect_to($location) {
  header("Location: " . $location);
  exit;
}

function is_post_request() {
  return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_get_request() {
  return $_SERVER['REQUEST_METHOD'] == 'GET';
}

function display_errors($errors=array()) {
    $output = '';
    if(!empty($errors)) {
        $output .= "<div class=\"errors\">";
        $output .= "Please fix the following errors:";
        $output .= "<ul>";
        foreach($errors as $error) {
            $output .= "<li>" . h($error) . "</li>";
        }
        $output .= "</ul>";
        $output .= "</div>";
    }
    return $output;
}

//------------------------------------------------------------------------
//	Used to convert a user-created URL into an embeddable URL.
//	Example: The typical URL pasted in from users will look like this: https://www.youtube.com/watch?v=CgSs3OvTnUQ
// 			 But this will not work in an embedded iFrame and so must be converted to: https://www.youtube.com/embed/CgSs3OvTnUQ
//
function mangleurl($url, $urltype = "") {
	if (strcasecmp($urltype, 'url') == 0 and strcasecmp(substr($url, 0, 3), 'http') != 0) {
		$url = 'http://' . $url;
	}
	$urlchunks = parse_url(trim($url));

	if (DEBUG_MODE == 'ONxx') {
		echo 'DEBUG MODE: ' . dirname(__FILE__).'.mangleurl()<br/>';
		echo var_dump($url) . '<br/>';
		echo var_dump($urlchunks) . '<br/>';
		echo '<br/>';
		}

	$baseurl = $url;		// in case we don't need to do anything, send back what we were given

	if (strpos(strtolower($urlchunks['host']), 'youtube') > 0) {
	    $baseurl = $urlchunks['scheme']."://".$urlchunks['host']."/embed/";
		if (strtolower(substr($urlchunks['query'], 0, 2)) == "v=") {
			$youtubeid = substr($urlchunks['query'], 2);
		}
		else {
			$youtubeid = $urlchunks['query'];
		}

		return $baseurl.$youtubeid;
	}

	if (strcasecmp(strtolower($urlchunks['host']), 'drive.google.com') == 0) {
		if (strcasecmp($urltype, 'image') == 0) {
			$baseurl  = $urlchunks['scheme']."://".$urlchunks['host']."/thumbnail?";
			$baseurl .= $urlchunks['query'].'&sz=w400-h400';
		}
		else {
			$baseurl = 'https://docs.google.com/document/d/' . substr($urlchunks['query'], 3) . '/edit';
		}
	}

	return $baseurl;
}


//------------------------------------------------------------------------
//	An item entry from the DB might have multiple URLs sepearated by ';' characters
//	This function takes that string and returns an array of those items
//	it will always return an array that is at least one item in size
//	Example https://www.youtube.com/watch?v=Md0CGAtOPEw;https://www.youtube.com/watch?v=0uPQjgfjl2Q;https://www.youtube.com/watch?v=yA83mhXV3iU;https://www.youtube.com/watch?v=pwFy7eP-IGA

function handlemultipleitems($item) {
	$urlarray = explode(';',$item);

	// if (DEBUG_MODE == 'ON') {
		// echo 'DEBUG MODE: ' . dirname(__FILE__).'.handlemultipleitems()<br/>';
		// echo var_dump($urlarray);
		// echo '<br/>';
		// }

	return $urlarray;
}

//------------------------------------------------------------------------
//	An item entry from the DB might have multiple URLs sepearated by ';' characters
//	This function counts how many items are in that long string
//	it can return 0 if the string is empty
//	Example https://www.youtube.com/watch?v=Md0CGAtOPEw;https://www.youtube.com/watch?v=0uPQjgfjl2Q;https://www.youtube.com/watch?v=yA83mhXV3iU;https://www.youtube.com/watch?v=pwFy7eP-IGA

function countitems($item) {
	$urlarray = explode(';',$item);
	$ctr = 0;

	 // if (DEBUG_MODE == 'ON') {
		// echo 'DEBUG MODE: ' . dirname(__FILE__).'.countitems()<br/>';
		// echo var_dump($urlarray);
		// echo count($urlarray);
		// echo '<br/>';
		// }

	foreach ($urlarray as $subitem) {
		if (trim($subitem) != '') {
			$ctr += 1;
		}
	}

	return $ctr;
}

  function is_logged_in() {
    // Having a admin_id in the session serves a dual-purpose:
    // - Its presence indicates the admin is logged in.
    // - Its value tells which admin for looking up their record.
    if (!isset($_SESSION['logged_in'])) {return false;}
	if ($_SESSION['logged_in'] != true) {return false;}
	return true;
  }

  function is_super_admin() {
    // Having a admin_id in the session serves a dual-purpose:
    // - Its presence indicates the admin is logged in.
    // - Its value tells which admin for looking up their record.
	if (!isset($_SESSION['logged_in'])) {return false;}
	if (!isset($_SESSION['role'])) {return false;}
    return ($_SESSION['logged_in'] == true and $_SESSION['role'] == 'SUPER-ADMIN');
  }

  function is_admin() {
    // Having a admin_id in the session serves a dual-purpose:
    // - Its presence indicates the admin is logged in.
    // - Its value tells which admin for looking up their record.
	if (!isset($_SESSION['logged_in'])) {return false;}
	if (!isset($_SESSION['role'])) {return false;}
	if (is_super_admin() == true) {return true;}
    return ($_SESSION['logged_in'] == true and $_SESSION['role'] == 'ADMIN');
  }

  function is_user() {
    // Having a admin_id in the session serves a dual-purpose:
    // - Its presence indicates the admin is logged in.
    // - Its value tells which admin for looking up their record.
	if (is_super_admin() == true) {return true;}
	if (is_admin() == true) {return true;}
	if (!isset($_SESSION['logged_in'])) {return true;}
	if (!isset($_SESSION['role'])) {
		$_SESSION['role'] = 'USER';
		return true;
		}
    return ($_SESSION['logged_in'] == true and $_SESSION['role'] == 'USER');
  }


function show_flash_message() {
  if (isset($_SESSION['action_message'])) {
    $message = $_SESSION['action_message'];
    unset($_SESSION['action_message']);
    return $message;
  }
  return NULL;
}

?>
