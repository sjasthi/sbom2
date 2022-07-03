<?php

$nav_selected = "APPLICATIONS";
$left_selected = "APPLIST";
$tabTitle = "SBOM - APPLICATIONS";
$app_checkbox_name = "checkboxApps";

include("../../../../index.php");
include("app_functions.php");
include("app_left_menu.php");

global $db;
$DEFAULT_SCOPE_FOR_RELEASES = getScope($db);

?>

<div class="wrap">
  <h3>Select BOM Apps:</h3>
  <form class="appSetForm" action="app_page.php" method="POST">
    <button type="submit" name="user_submit">Set My Apps</button>
    <?php
    if(isset($_SESSION['admin'])){
      echo '<button type="submit" name="system_submit">Set System Apps</button>';
      echo '<button type="submit" name="appset_submit">Create Appset</button>';
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
      <table class="datatable table">
        <thead>
          <tr id="table-first-row">
            <th><input id="check-all" type="checkbox" style="width:20px;height:20px;"></th>
            <th>App Name</th>
            <th>App ID</th>
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
  </script>
</div>
