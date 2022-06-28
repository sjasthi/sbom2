<?php
  $nav_selected = "BOM";
  $left_selected = "BOMAPPSET";
  $tabTitle = "SBOM - BOM (APPSET)";
  $bom_app_set_cookie_name = "user_bom_app_set";
  $app_checkbox_name = "checkboxApps";

  include "get_scope.php";
  include("../../../../index.php");
  include("bom_left_menu.php");

  global $db;
  $DEFAULT_SCOPE_FOR_RELEASES = getScope($db);

  function showAppsAsChecklist($db){
    global $app_checkbox_name;
    $sql_applications = "
    SELECT * FROM applications
    ";
    $option_id = 1;
    $query_applications = $db->query($sql_applications);
    if($query_applications->num_rows > 0){
      while($application = $query_applications->fetch_assoc()){
        echo '<tr>';
        echo '<td><input class="appCheckbox" name="'.$app_checkbox_name.'[]" id="checkbox'.$option_id.'" value="'.$application["app_id"].'" style="width:20px;height:20px;" type="checkbox"></td>';
        echo '<td>'.$application["app_name"].'</td>';
        echo '<td>'.$application["app_id"].'</td>';
        echo '</tr>';
        $option_id++;
      }
    }
  }

  function userFormSubmit(){
    if(isset($_POST['submit'])){
      return true;
    }
    return false;
  }

  function setUserAppSetCookies($apps){
    global $bom_app_set_cookie_name;
    $app_string = '';
    if(isset($apps) && count($apps) != 0){
      foreach($apps as $checked_item) {
        // echo $checked_item;
        $app_string = $app_string . $checked_item.',';
      }
    }
    setcookie($bom_app_set_cookie_name, $app_string, 2147483647, "/");
    echo $app_string;
  }
?>

<div class="wrap">
  <h3>BOM --> APP Sets.</h3>
  <form class="appSetForm" action="bom_app_set.php" method="POST">
    <fieldset>
      <legend>Select BOM Apps:</legend>
      <table class="datatable table">
        <thead>
          <tr id="table-first-row">
            <th><input id="check-all" type="checkbox" style="width:20px;height:20px;"></th>
            <th>App Name</th>
            <th>App ID</th>
          </tr>
        </thead>
        <tbody>
          <?php showAppsAsChecklist($db) ?>
        </tbody>
      </table>
    </fieldset>
    <button type="submit" name="submit">Set Apps</button>
  </form>
  <?php
    if(userFormSubmit()){
      isset($_POST[$app_checkbox_name]) ? $apps = $_POST[$app_checkbox_name] : $apps = [];
      setUserAppSetCookies($apps);
    }
   ?>
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
