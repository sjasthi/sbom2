<?php
  $nav_selected = "APPLICATIONS";
  $left_selected = "APPLIST";
  $tabTitle = "Application";

  include "get_scope.php";
  include("../../../../index.php");
  include("app_left_menu.php");

  $def = "false";
  $DEFAULT_SCOPE_FOR_RELEASES = getScope($db);
  $scopeArray = array();

  require_once('calculate_color.php');
?>


<?php

$tabTitle = "SBOM - APPLICATIONS";


include("../../../../index.php");
include("app_functions.php");
include("app_left_menu.php");

global $db;
$DEFAULT_SCOPE_FOR_RELEASES = getScope($db);
$BARGRAPH_LENGTH = 300;

function showAppsAsChecklist($db){
  global $app_checkbox_name;
  $sql_applications_components_query = "
    SELECT a.app_id,a.app_name,monitoring_digest, a.app_version, a.app_status,
    a.is_eol, ac.red_app_id
    FROM applications a JOIN apps_components ac
    ON a.app_id = ac.red_app_id
    ORDER BY a.app_id;
  ";


  $option_id = 1;
  $query_applications = $db->query($sql_applications_components_query);
  if($query_applications->num_rows > 0){
    global $BARGRAPH_LENGTH;
    $last_app_id = '';
    $last_app_name = '';
    // $total_security_issues = 0;
    $security_issues = [0,0,0];
    $debug_msg = array();
    while($application = $query_applications->fetch_assoc()){
      if($last_app_id != $application['app_id'] && $last_app_id != ''){
        echo '<tr>';
        echo '<td><input class="appCheckbox" name="'.$app_checkbox_name.'[]" id="checkbox'.$option_id.'" value="'.$application["app_id"].'" style="width:20px;height:20px;" type="checkbox"></td>';
        echo '<td>'.$application["app_name"].'</td>';
        echo '<td>'.$application["app_id"].'</td>';
        echo '<td>'.$application["app_version"].'</td>';
        echo '<td>'.$application["app_status"].'</td>';
        echo '<td>'.$application["is_eol"].'</td>';
        echo '<td><div class="bargraph" style="width:320px">';
        $total_security_issues = $security_issues[0] + $security_issues[1] + $security_issues[2];
        $multi = 0;
        if($total_security_issues != 0){
          $multi = $BARGRAPH_LENGTH / ($total_security_issues);
        }
        echo '<span class="graphBar" style="background-color:red; width:'.($security_issues[0] * $multi).'px;text-align:center;">'.(($security_issues[0] > 0)? $security_issues[0]:"").'</span>';
        echo '<span class="graphBar" style="background-color:orange; width:'.($security_issues[1] * $multi).'px;text-align:center;">'.(($security_issues[1] > 0)? $security_issues[1]:"").'</span>';
        echo '<span class="graphBar" style="background-color:yellow; width:'.($security_issues[2] * $multi).'px;text-align:center;">'.(($security_issues[2] > 0)? $security_issues[2]:"").'</span>';
        echo '</div></td>';
        echo '</tr>';
        $security_issues = [0,0,0];
      } else {
        preg_match('/([0-9]*) critical, ([0-9]*) major, ([0-9]*) minor/', $application['monitoring_digest'], $security_count);
        if(count($security_count) == 4){
          $security_issues[0] += $security_count[1];
          $security_issues[1] += $security_count[2];
          $security_issues[2] += $security_count[3];
        }
      }
      $last_app_id = $application['app_id'];
      $last_app_name = $application['app_name'];
      $option_id++;
    }
  }
}
?>

<div class="wrap">
  <h3>Select BOM Apps:</h3>
  <form class="appSetForm" action="app_page.php" method="POST">
    <button type="submit" name="user_submit">Set My Apps</button>
    <?php
    if(isset($_SESSION['admin'])){
      echo '<button type="submit" name="system_submit">Set System Apps</button>';
      echo '<button type="submit" name="appset_submit">Create Appset</button>';
      echo '<span> </span>';
      echo '<input type="text" name="appset_name" placeholder="appset name">';
    }
    isset($_POST[$app_checkbox_name]) ? $apps = $_POST[$app_checkbox_name] : $apps = [];

    if(isset($_POST['user_submit'])){
      setUserAppSetCookies($apps);
    }
    if(isset($_SESSION['admin'])){
      if(isset($_POST['system_submit'])){
        if(setSystemAppSet($db, implode(',', $apps))){
          echo '<p style="background: green; color: white; font-size: 2rem;">Set system app set.</p>';
        } else {
          echo '<p style="background: red; color: black; font-size: 2rem;">Error setting system app set.</p>';
        }
      } else if (isset($_POST['appset_submit'])){
        if(!isset($_POST['appset_name']) || $_POST['appset_name'] == ''){
          echo '<p style="background: red; color: black; font-size: 2rem;">Specify an app set name.</p>';
        } else {
          if(createSystemAppset($db, $apps, $_POST['appset_name'])){
            echo '<p style="background: green; color: white; font-size: 2rem;">Created new system app set.</p>';
          } else {
            echo '<p style="background: red; color: black; font-size: 2rem;">Error creating a new system app set.</p>';
          }
        }
      }
    }

    ?>
    <fieldset>
      <table class="datatable table" id="info">
        <thead>
          <tr id="table-first-row">
            <th><input id="check-all" type="checkbox" style="width:20px;height:20px;"></th>
            <th>App Name</th>
            <th>App ID</th>
            <th>App Version</th>
            <th>App Status</th>
            <th>End of Life?</th>
            <th>App Security</th>
          </tr>
        </thead>
        <tbody>
          <?php
          showAppsAsChecklist($db)
          ?>
        </tbody>
      </table>
    </fieldset>
  </form>
  <script type="text/javascript">
  $('#check-all').click(function(){
    if($('#check-all')[0].checked){
      $('.appCheckbox').prop('checked', true);
    } else {
      $('.appCheckbox').prop('checked', false);
    }
  });
  $(document).ready( function () {
    $('#info').DataTable();
  });
  </script>
</div>