
<?php
$nav_selected = "REPORTS";
$left_selected = "REPORTSCOMPAREAPPS";
$tabTitle = "Reports - Compare Apps";

include("../../../../index.php");
include("reports_left_menu.php");

$app_list = array();
$sql_apps = "
SELECT app_name, app_id, app_version
FROM applications;
";
$query_apps = $db->query($sql_apps);
while($app = $query_apps->fetch_assoc()){
  $app_list[] = $app;
}
if(isset($_POST['appOne']) && isset($_POST['appTwo'])){
  $sql_app_q = '
  SELECT ac.red_app_id, ac.app_id , a.app_name, a.app_version, a.app_status,
  ac.cmpt_name, ac.cmpt_version, ac.status
  FROM apps_components ac JOIN applications a
  ON a.app_id = ac.red_app_id
  WHERE ac.red_app_id = ?
  ';
  $query_app = $db->prepare($sql_app_q);

  $query_app->bind_param('s', $_POST['appOne']);
  $query_app->execute();
  $results = $query_app->get_result();
  $app_components_one = array();
  while($component = $results->fetch_assoc()){
    $app_components_one[] = $component;
  }

  $query_app->bind_param('s', $_POST['appTwo']);
  $query_app->execute();
  $results = $query_app->get_result();
  $app_components_two = array();
  while($component = $results->fetch_assoc()){
    $app_components_two[] = $component;
  }
}
?>

<div class="wrap">
  <h3>Reports - Compare Apps</h3>
  <form action="reports_compare_apps.php" method="POST">
    <select class="selectAppOne" name="appOne">
      <?php
      foreach($app_list as $app){
        echo '<option value='.$app['app_id'].'>'.$app['app_name'].' ('.$app['app_version'].')'.'</option>';
      }
      ?>
    </select>
    <select class="selectAppOne" name="appTwo">
      <?php
      foreach($app_list as $app){
        echo '<option value='.$app['app_id'].'>'.$app['app_name'].' ('.$app['app_version'].')'.'</option>';
      }
      ?>
    </select>
    <br>
    <button type="submit" name="compareApps">Compare Apps</button>
  </form>
  <?php
  if(isset($_POST['appOne']) && isset($_POST['appTwo'])){
    $similar_app_comps = array();
    // $dissimilar_apps = array();
    foreach($app_components_one as $app_one_comp){
      foreach($app_components_two as $app_two_comp){
        if($app_one_comp['cmpt_name'] == $app_two_comp['cmpt_name']){
          $similar_app_comps[] = array($app_one_comp, $app_two_comp);
          $key = array_search($app_one_comp, $app_components_one, true);
          if($key !== false){
            unset($app_components_one[$key]);
          }
          $key2 = array_search($app_two_comp, $app_components_two, true);
          if($key2 !== false){
            unset($app_components_two[$key2]);
          }
          break;
        }
      }
    }
    ?>
    <style>
    tr,td,th{
      border: 1px solid grey;
      border-collapse: collapse;
    }
    th{
      text-align: center;
    }
    table {
      border:3px solid black;
    }
    </style>
    <table>
      <?php
      $first_app;
      $second_app;
      if(count($app_components_one) > 0){
        $first_app = current($app_components_one);
      } else {
        $first_app = $similar_app_comps[0][0];
      }
      if(count($app_components_two) > 0){
        $second_app = current($app_components_two);
      } else {
        $second_app = $similar_app_comps[0][1];
      }
      ?>
      <tr>
        <th colspan='2'><?php echo $first_app['app_name'] . ' - ' . $first_app['app_version']; ?></th>
        <th>-></th>
        <th colspan='2'><?php echo $second_app['app_name'] . ' - ' . $second_app['app_version']; ?></th>
      </tr>
      <tr>
        <td>Component Id</td><td>Component Version</td>
        <td></td>
        <td>Component Id</td><td>Component Version</td>

      </tr>
      <?php
      foreach($similar_app_comps as $similar_apps){

        if(strcmp($similar_apps[0]['cmpt_version'], $similar_apps[1]['cmpt_version']) !== 0){
          echo '<tr>';
          echo '<td>' . $similar_apps[0]['cmpt_name'] . '</td>';
          echo '<td>' . $similar_apps[0]['cmpt_version'] . '</td>';
          echo '<td></td>';
          echo '<td>' . $similar_apps[1]['cmpt_name'] . '</td>';
          echo '<td  style="background-color:yellow">' . $similar_apps[1]['cmpt_version'] . '</td>';
          echo '</tr>';
        }
      }
      foreach($app_components_one as $app_component){
        echo '<tr>';
        echo '<td style="background-color:red">' . $app_component['cmpt_name'] . '</td>';
        echo '<td>' . $app_component['cmpt_version'] . '</td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '</tr>';
      }
      foreach($app_components_two as $app_component2){
        echo '<tr>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td style="background-color:lime">' . $app_component2['cmpt_name'] . '</td>';
        echo '<td>' . $app_component2['cmpt_version'] . '</td>';
        echo '</tr>';
      }
      ?>
    </table>
    <?php
  }
  ?>
</div>
