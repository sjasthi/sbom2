
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
    SELECT * FROM apps_components
    WHERE red_app_id = ?
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
    ?>
    <p>App One</p>
    <?php
    foreach ($app_components_one as $app) {
      echo $app['cmpt_name'] . '-' . $app['cmpt_version'] . '<br>';
    }
    ?>
    <p>App Two</p>
    <?php
    foreach ($app_components_two as $app) {
      echo $app['cmpt_name'] . '-' . $app['cmpt_version'] . '<br>';
    }
  }
  ?>


</div>
