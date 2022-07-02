<?php

function showAppsAsChecklist($db){
  global $app_checkbox_name;
  global $sql_applications_query;

  $option_id = 1;
  $query_applications = $db->query($sql_applications_query);
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

 ?>