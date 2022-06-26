<?php
  // set the current page to one of the main buttons
  $nav_selected = "ADMIN";
  // make the left menu buttons visible; options: YES, NO
  //$left_buttons = "YES"; // Commented in effort to work with upstream
  // set the left menu button selected; options will change based on the main selection
  //$left_selected = "ADMIN";
  $left_selected = "SYSAPPSETS";
  $tabTitle =  "Admin --> System App Sets";

  include("../../../../index.php");
  include("admin_left_menu.php");

  if(!isset($_SESSION)){
    session_start();
  }

  $cookie_name = 'sysappsets';
  $expire = strtotime('+1 year');

  //if cookie is set, decode cookie into array
  if(isset($_COOKIE[$cookie_name])) {
    $cookie_map = json_decode($_COOKIE[$cookie_name]);
  }

?>

<html>
  <body>
    <div class="wrap">
    <h3>Admin --> System App Sets</h3>
    <div id='list'>
      <p>Select the current System App Set</p>
      <form enctype="multipart/form-data" method="POST" role="form">
        <select id="current_app_set" name="current_app_set" required>
          <option value="0">Unset System App Set</option>
<?php
  $current_app_sets = $db->prepare('select distinct app_set_id, app_set_name from app_sets');
  if(!$current_app_sets->execute()) {
    echo '<p style="background: red; color: white; font-size: 2rem;">ERROR: '.$db->error.'</p>';
  } else {
    $current_app_sets->bind_result($id, $name);
    while ($row = $current_app_sets->fetch()) {
      echo '          <option value="'.$id.'">'.$id." - ".$name.'</option>\n';
    }
  }
?>
        </select>
        <br />
        <br />
        <button style="background: #01B0F1; color: white;" type="submit" class="btn btn-default" name="submit" value="submit">Set System App Set</button>
      </form>
    </div>
  </body>
</html>


<?php
  if (isset($_POST['current_app_set'])) {
    if ( $_POST['current_app_set']  == '0' ) {
      $sys_app_set = $db->prepare('update preferences set value = "0" where name = "ACTIVE_APP_SET";');
      if(!$current_app_sets->execute()) {

      } else {
        echo '<p style="background: green; color: white; font-size: 2rem;">Unsetting System App Set</p>';
      }
    } else {
      $sys_app_set = $db->prepare('update preferences set value = ? where name = "ACTIVE_APP_SET";');
      $sys_app_set->bind_param('s',$_POST['current_app_set']);
      if(!$current_app_sets->execute()) {

      } else {
        echo '<p style="background: green; color: white; font-size: 2rem;">Setting System App Set to: '.$_POST['current_app_set'].'</p>';
      }
    }
  }

?>
