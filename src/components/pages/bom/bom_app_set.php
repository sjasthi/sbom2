<?php
    $nav_selected = "BOM";
    $left_selected = "BOMAPPSET";
    $tabTitle = "SBOM - BOM (APPSET)";

    include "get_scope.php";
    include("../../../../index.php");
    include("bom_left_menu.php");

    global $db;
    $DEFAULT_SCOPE_FOR_RELEASES = getScope($db);

    function showAppsAsChecklist($db){
      $sql_applications = "
        SELECT * FROM applications
      ";
      $option_id = 1;
      $query_applications = $db->query($sql_applications);
      if($query_applications->num_rows > 0){
        while($application = $query_applications->fetch_assoc()){
          // <input name="checkboxGroup" access="false" id="checkboxGroup" value="option-1" type="checkbox">
          // <label for="checkboxGroup">Option 1</label>
          echo '<input name="checkboxApp'.$option_id.'" id="checkbox'.$option_id.'" value="'.$application["app_id"].'" type="checkbox">';
          echo '<label for="checkboxApp'.$option_id.'">'.$application["app_name"].' - '.$application["app_id"].'</label>';
          echo '<br>';
        }
        $option_id++;
      }
    }
?>

<div class="wrap">
  <h3>BOM --> APP Sets.</h3>
  <form class="appSetForm" action="bom_create_appset.html" method="post">
    <div class="appSetName">
        <label for="bomSetName">BOM Set Name: </label>
        <input type="text" name="bomSetName" access="false">
    </div>
    <fieldset>
      <legend>Select BOM Apps:</legend>
      <div class="appSetCheckboxGroup">
        <?php showAppsAsChecklist($db) ?>
      </div>
    </fieldset>
    <button type="submit" name="button">Create App Set</button>
  </form>
</div>
