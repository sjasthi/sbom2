<?php

$default_bom_query = "
  SELECT * FROM applications
";

$sql_applications_query = "
  SELECT * FROM applications
";

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

// Function to show the BOM components and their dependencies
function displayComponents($db, $parent_component_query, $parent_table_id) {
  $parent_c = 1;
  while($component = $parent_component_query->fetch_assoc()){
    $comp_id = $component["cmpt_id"];
    $comp_name = $component["cmpt_name"];
    $comp_version = $component["cmpt_version"];
    $comp_status = $component["status"];
    $comp_table_id=$parent_table_id."-".$parent_c;

    $sql_components = "
    SELECT * FROM apps_components
    WHERE app_id = '".$comp_id."'
    ";
    $query_component_children = $db->query($sql_components);
    $has_children = $query_component_children->num_rows > 0;
    $comp_color = ($has_children)?"child":"grandchild";
    $comp_class = ($has_children)?"yellowComp":"greenComp";


    echo "<tr data-tt-id = '".$comp_table_id."' data-tt-parent-id='".$parent_table_id."' class = 'component ".$comp_class."' >
    <td class='text-capitalize'> <div class = 'btn ".$comp_color."'> <span class = 'cmp_name'>".$comp_name."</span>&nbsp; &nbsp;&nbsp; &nbsp;</div></td>
    <td class = 'cmp_version'>".$comp_version."</td>
    <td class='text-capitalize'>".$comp_status."</td>";

    if($has_children){
      displayComponents($db, $query_component_children, $comp_table_id);
    }
    $parent_c++;
  }
}
// Function to show applications and their dependencies
function displayBomsAsTable($db, $bom_query='') {
  global $default_bom_query;
  if($bom_query == ''){
    $bom_query = $default_bom_query;
  }
  $p_id = 1;
  $query_applications = $db->query($bom_query);
  if($query_applications->num_rows > 0){
    while($application = $query_applications->fetch_assoc()){
      $red_app_id = $application["app_id"];
      $app_name = $application["app_name"];
      $app_version = $application["app_version"];
      $app_status = $application["app_status"];
      echo "<tbody class= 'redApp'>
      <tr data-tt-id = '".$p_id."' ><td class='text-capitalize'>
      <div class = 'btn parent' ><span class = 'app_name' style = 'max-width: 160em; white-space: pre-wrap; word-wrap: break-word; word-break: break-all;'>".$app_name."</span>&nbsp; &nbsp;&nbsp; &nbsp;</div></td>
      <td >".$app_version."</td><td class='text-capitalize'>".$app_status."</td><td/><td>".$red_app_id."<td/><td/><td/></tr>";

      $sql_components = "
      SELECT * FROM apps_components
      WHERE app_id = '".$red_app_id."'
      ";
      $query_components = $db->query($sql_components);
      displayComponents($db, $query_components, $p_id);
      $query_components->close();
      $p_id++;
    }
  }
}

function displayAllAppsList($db, $app_columns){
  $bom_app_query = "
    SELECT * FROM sbom;
  ";
  $query_applications = $db->query($bom_app_query);
  if($query_applications->num_rows > 0){
    while($row = $query_applications->fetch_assoc()){
      echo '<tr>';
      foreach($app_columns as $column){
        echo '<td>'.$row[$column].'</td>';
      }
      echo '</tr>';
    }
  }

}
?>