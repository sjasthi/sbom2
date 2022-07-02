<?php

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
  global $sql_applications_query;
  if($bom_query == ''){
    $bom_query = $sql_applications_query;
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

function displayAllAppsList($db, $app_columns, $app_query = ''){
  global $sql_applications_query;
  if($app_query == ''){
    $app_query = $sql_applications_query;
  }
  $query_applications = $db->query($app_query);
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

//Display error if user retrieves preferences w/o any cookies set
function checkUserAppsetCookie(){
  global $pref_err, $bom_app_set_cookie_name;
  if(isset($_POST['getpref']) && !isset($_COOKIE[$bom_app_set_cookie_name])) {
    global $appPagePath;
    $pref_err = 'You don\'t have BOMS saved. Select some in the <a href="'.$appPagePath.'">BOM Appset page</a>';
  }
  echo '<p
  style="font-size: 2.5rem;
  text-align: center;
  background-color: red;
  color: white;">'.$pref_err.'</p>';
}
?>