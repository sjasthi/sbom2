<?php
  $nav_selected = "APPLICATIONS";
  $tabTitle = "SBOM - APPLICATIONS";
  $app_checkbox_name = "checkboxApps";

  include("../../../../index.php");
  include("app_functions.php");

  global $db;
  $DEFAULT_SCOPE_FOR_RELEASES = getScope($db);

?>

<div class="wrap">
  <h3>Applications</h3>
  <form class="appSetForm" action="app_page.php" method="POST">
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
          <?php
            showAppsAsChecklist($db)
          ?>
        </tbody>
      </table>
    </fieldset>
    <button type="submit" name="submit">Set Apps</button>
    <?php
      if($_SESSION['admin']){
        echo '<button type="submit" name="system_submit">Set System Apps</button>';
      }
     ?>
  </form>
  <?php
    if(isset($_POST['submit'])){
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
