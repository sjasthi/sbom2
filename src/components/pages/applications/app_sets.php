<?php

$nav_selected = "APPLICATIONS";
$left_selected = "APPSETS";
$tabTitle = "SBOM - APPLICATIONS";

include("../../../../index.php");
include("app_functions.php");
include("app_left_menu.php");

global $db;
$DEFAULT_SCOPE_FOR_RELEASES = getScope($db);

?>

<div class="wrap">
  <h3>Applications</h3>
  <form class="appSetForm" action="app_sets.php" method="POST">
    <!-- <button type="submit" name="submit_user_appset">Set Apps</button> -->

    <?php
    if(isset($_SESSION['admin'])){
      echo '<button type="submit" name="submit_appset_delete">Delete App Set</button>';
      echo '<button type="submit" name="submit_system_appset">Set System Apps</button>';
    }
    if(isset($_SESSION['admin'])){
      if(isset($_POST['submit_appset_delete'])){
        // setUserAppSetCookies($apps);
        if(isset($_POST['appset_radio'])){
          deleteSystemAppSet($db, $_POST['appset_radio']);
          echo '<p style="background: green; color: white; font-size: 2rem;">Deleted app set.</p>';
        } else {
          echo '<p style="background: red; color: black; font-size: 2rem;">Select an app to delete.</p>';
        }
      }
      if(isset($_POST['submit_system_appset'])){
        if(!isset($_POST['appset_radio'])){
          echo '<p style="background: red; color: black; font-size: 2rem;">Select an app set.</p>';
        } else if(setSystemAppSet($db, $_POST['appset_radio'])){
          echo '<p style="background: green; color: white; font-size: 2rem;">Set system app set.</p>';
        }
      }
    }
    ?>
    <fieldset>
      <legend>Select BOM Apps:</legend>
      <table class="datatable table">
        <thead>
          <tr id="table-first-row">
            <th></th>
            <th>App Set Name</th>
            <th>App IDs</th>
          </tr>
        </thead>
        <tbody>
          <?php
          showAppsetsAsTable($db)
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
