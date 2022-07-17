<?php

$nav_selected = "APPLICATIONS";
$left_selected = "APPSETS";
$tabTitle = "SBOM - APPLICATIONS";

include("../../../../index.php");
include("app_functions.php");
include("app_left_menu.php");

global $db;
$DEFAULT_SCOPE_FOR_RELEASES = getScope($db);

function showAppsetsAsTable($db){
    $sql_query_appsets = '
      SELECT a_set.app_set_id, a_set.app_set_name, a_set.app_id, a.app_name, a.app_version
      FROM app_sets a_set JOIN applications a
      ON a_set.app_id = a.app_id
      ORDER BY a_set.app_set_id ASC;
    ';
    $query_appsets_result = $db->query($sql_query_appsets);
    if($query_appsets_result->num_rows < 1){
      // show err
      return;
    }
    $appset_id = NULL;
    $appset_list = [];
    while($app_from_appset = $query_appsets_result->fetch_assoc()){
      if($appset_id != $app_from_appset['app_set_id']){
        echo '<tr>';
        $appset_id = $app_from_appset['app_set_id'];
        echo '<td><input id="'.$app_from_appset['app_set_id'].'" type="radio" name="appset_radio" value="'.$app_from_appset['app_set_id'].'"></td>';
        echo'<td>'.$app_from_appset['app_set_name'].'</td>';
      } else {
        echo '<td></td>';
        echo '<td></td>';
      }
      echo'<td>'.$app_from_appset['app_id'].'</td>';
      echo'<td>'.$app_from_appset['app_name'].'</td>';
      echo'<td>'.$app_from_appset['app_version'].'</td>';
      echo '</tr>';
      $appset_list[] = $app_from_appset['app_id'];
    }
}
?>

<div class="wrap">
  <h3>Applications</h3>
  <form class="appSetForm" action="app_sets.php" method="POST">
    <!-- <button type="submit" name="submit_user_appset">Set Apps</button> -->

    <?php
    if(isset($_SESSION['admin'])){
      echo '<button type="submit" name="submit_appset_delete">Delete App Set</button>';
      echo '<button type="submit" name="submit_system_appset">Set System App Set</button>';
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
    echo "<h4><span style='font-weight: bold; color: #01B0F1; background: #bbbbbb; padding: 6px;'>Current App Set: </span><span style='padding: 6px; background: #bbbbbb;'>".getSystemAppSetName($db)."</span></h4>";
    ?>
    <br />
    <fieldset>
      <legend>Select BOM Apps:</legend>
      <table class="datatable table">
        <thead>
          <tr id="table-first-row">
            <th></th>
            <th>App Set Name</th>
            <th>App IDs</th>
            <th>App Name</th>
            <th>App Version</th>
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
