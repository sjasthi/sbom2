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
      <h4>Select the current System App Set</h4>
      <br />
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

      <h4>Delete a System App Set</h4>
      <br />
      <form enctype="multipart/form-data" method="POST" role="form">
        <select id="delete_app_set" name="delete_app_set" required>
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
        <button style="background: #01B0F1; color: white;" type="submit" class="btn btn-default" name="submit" value="submit">Delete selected System App Set</button>
      </form>

      <h4>Create or replace a System App Set</h4>
      <br />
      <form enctype="multipart/form-data" method="POST" role="form">
        app_set_id: <input type="text" id="new_app_set_id" name="new_app_set_id"><br /><br />
        app_set_name: <input type="text" id="new_app_set_name" name="new_app_set_name"><br /><br />
        comma seperated list of app_id: <input type="text" id="new_app_set_app_list" name="new_app_set_app_list"><br /><br />
        <button style="background: #01B0F1; color: white;" type="submit" class="btn btn-default" name="submit" value="submit">Add or replace System App Set</button>
      </form>

    </div>
  </body>
</html>


<?php
  // Set the current system app set.
  if (isset($_POST['current_app_set'])) {
    if ( $_POST['current_app_set']  == '0' ) {
      $sys_app_sets = $db->prepare('update preferences set value = "0" where name = "ACTIVE_APP_SET";');
      if(!$sys_app_sets->execute()) {
        echo '<p style="background: red; color: white; font-size: 2rem;">ERROR: '.$db->error.'</p>';
      } else {
        echo '<p style="background: green; color: white; font-size: 2rem;">Unsetting System App Set</p>';
      }
    } else {
      $sys_app_sets = $db->prepare('update preferences set value = ? where name = "ACTIVE_APP_SET";');
      $sys_app_sets->bind_param('s',$_POST['current_app_set']);
      if(!$sys_app_sets->execute()) {
        echo '<p style="background: red; color: white; font-size: 2rem;">ERROR: '.$db->error.'</p>';
      } else {
        echo '<p style="background: green; color: white; font-size: 2rem;">Setting System App Set to: '.$_POST['current_app_set'].'</p>';
      }
    }
  }

  // Delete the select app set.
  if (isset($_POST['delete_app_set'])) {
    $delete_app_sets = $db->prepare('delete from app_sets where app_set_id = ?;');
    $delete_app_sets->bind_param('s',$_POST['delete_app_set']);
    if(!$delete_app_sets->execute()) {
      echo '<p style="background: red; color: white; font-size: 2rem;">ERROR: '.$db->error.'</p>';
    } else {
      echo '<p style="background: green; color: white; font-size: 2rem;">Deleting System App Set: '.$_POST['delete_app_set'].'</p>';
    }
  }

  // Add or replace an app set.
  if (isset($_POST['new_app_set_id'])) {
    // Delete the existing rows for that app_set_id
    $replace_app_sets = $db->prepare('delete from app_sets where app_set_id = ?;');
    $replace_app_sets->bind_param('s',$_POST['new_app_set_id']);
    if(!$replace_app_sets->execute()) {
      echo '<p style="background: red; color: white; font-size: 2rem;">ERROR: '.$db->error.'</p>';
    } else {
      echo '<p style="background: green; color: white; font-size: 2rem;">Adding or replacing System App Set: '.$_POST['new_app_set_id'].'</p>';
    }
    // Insert neccesary rows into the app_set table
    $app_id_array = explode(",", $_POST['new_app_set_app_list'] );
    foreach ($app_id_array as $each_app_id) {
      $app_sets_insert = $db->prepare('insert into app_sets ( app_set_id, app_set_name, app_id ) values ( ?, ?, ? );');
      $app_sets_insert->bind_param('sss',$_POST['new_app_set_id'],$_POST['new_app_set_name'],$each_app_id);
      if(!$app_sets_insert->execute()) {
        echo '<p style="background: red; color: white; font-size: 2rem;">ERROR: '.$db->error.'</p>';
      } else {
        echo '<p style="background: green; color: white; font-size: 2rem;">Adding '.$each_app_id.' to System App Set: '.$_POST['new_app_set_id'].'</p>';
      }
    }
  }

?>
