<?php
include('bom_tree_class.php');

$sql_applications_query = "
SELECT * FROM applications
";

function displayBOMTrees($db, $sql_components){
  $query_components = $db->query($sql_components);
  $components = array();
  while($component = $query_components->fetch_assoc()){
    $components[] = new AppComponent($component);
  }
  // basicDisplayComponents($components);
  $red_apps = generateTrees($db, $components);
  displayTrees($red_apps);
}

function displayTrees($red_apps){
  $p_id = 1;
  foreach($red_apps as $red_app){
    // Only show red apps with components
    if(count($red_app->app_components) > 1){
      $red_app_id = $red_app["app_id"];
      $app_name = $red_app["app_name"];
      $app_version = $red_app["app_version"];
      $app_status = $red_app["app_status"];
      echo "<tbody class= 'redApp'>
      <tr data-tt-id = '".$p_id."' ><td class='text-capitalize'>
      <div class = 'btn parent' ><span class = 'app_name' style = 'max-width: 160em; white-space: pre-wrap; word-wrap: break-word; word-break: break-all;'>".$app_name."</span>&nbsp; &nbsp;&nbsp; &nbsp;</div></td>
      <td >".$app_version."</td><td class='text-capitalize'>".$app_status."</td></tr>";
      displayComponentTree($red_app->app_components, $p_id);
      $p_id += 1;
    }
  }
}

function displayComponentTree($components, $parent_table_id){
  $parent_c = 1;
  foreach($components as $component){
    $comp_id = $component["cmpt_id"];
    $comp_name = $component["cmpt_name"];
    $comp_version = $component["cmpt_version"];
    $comp_status = $component["status"];
    $comp_table_id=$parent_table_id."-".$parent_c;


    $has_children = count($component->children) > 0;
    $comp_color = ($has_children)?"child":"grandchild";
    $comp_class = ($has_children)?"yellowComp":"greenComp";


    echo "<tr data-tt-id = '".$comp_table_id."' data-tt-parent-id='".$parent_table_id."' class = 'component ".$comp_class."' >
    <td class='text-capitalize'> <div class = 'btn ".$comp_color."'> <span class = 'cmp_name'>".$comp_name."</span>&nbsp; &nbsp;&nbsp; &nbsp;</div></td>
    <td class = 'cmp_version'>".$comp_version."</td>";

    if($has_children){
      displayComponentTree($component->children, $comp_table_id);
    }
    $parent_c++;
  }
}

function generateTrees($db, $components){
  global $sql_applications_query;
  $red_apps = array();
  $query_applications = $db->query($sql_applications_query);
  while($red_app = $query_applications->fetch_assoc()){
    $red_apps[] = new RedApp($red_app);
  }
  foreach ($components as $component) {
    foreach($red_apps as &$red_app){
      if($red_app['app_id'] == $component['red_app_id']){
        $red_app->addAppComponent($component);
        break;
      }
    }
  }
  return $red_apps;
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

function displayAllAppsAndComponentList($db, $app_columns, $app_query = ''){
  //global $sql_applications_query;
  if($app_query == ''){
    //$app_query = $sql_applications_query;
    $app_query = '
    SELECT a.app_id, a.app_name, a.app_version,
    a_comp.cmpt_id, a_comp.cmpt_name, a_comp.cmpt_version,
    a_comp.license, a_comp.status, a_comp.requester,
    a_comp.description, a_comp.monitoring_id, a_comp.monitoring_digest,
    a_comp.issue_count
    FROM applications a INNER JOIN apps_components a_comp
    ON a.app_id = a_comp.red_app_id;
    ';
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
