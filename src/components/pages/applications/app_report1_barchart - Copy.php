<?php
  $nav_selected = "APPLICATIONS";
  $left_selected = "APPREPORT1";
  $tabTitle = "APP Report 1";

  include "get_scope.php";
  include("../../../../index.php");
  include("app_left_menu.php");

  $def = "false";
  $DEFAULT_SCOPE_FOR_RELEASES = getScope($db);
  $scopeArray = array();

  require_once('calculate_color.php');
?>


                <h3>App Report 1</h3>
    <table id="info" cellpadding="0" cellspacing="0" border="0"

        class="datatable table table-striped table-bordered datatable-style table-hover"

        width="100%" style="width: 100px;">

        <thead>

          <tr id="table-first-row">

            <th>Component</th>

            <th>Count</th>

      

          </tr>

        </thead>

        <tbody>



  
    <table id="info" cellpadding="0" cellspacing="0" border="0"
        class="datatable table table-striped table-bordered datatable-style table-hover"
        width="100%" style="width: 100px;">
        <thead>
          <tr id="table-first-row">
            <th>Component</th>
            <th>Count</th>
      
          </tr>
        </thead>
        <tbody>

          <?php
           //Get DB Credentials
          $DB_SERVER = constant('DB_SERVER');
          $DB_NAME = constant('DB_NAME');
          $DB_USER = constant('DB_USER');
          $DB_PASS = constant('DB_PASS');
          //PDO connection
          $pdo = new PDO("mysql:host=$DB_SERVER;dbname=$DB_NAME", $DB_USER, $DB_PASS);

         
          $sql = "SELECT cmpt_name, app_id, COUNT(*) as frequency FROM apps_components GROUP BY cmpt_name, app_id HAVING COUNT(*) > 1 order by frequency desc LIMIT 10";
          
          $pref = $pdo->prepare($sql);
          $pref->execute();

          while($row = $pref->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>

            <td>'.$row["cmpt_name"].'</td>
            <td>'.$row["frequency"].'</td>
        
            
            </tr>';
          }
        // }
      ?>
      </tbody>
      <tfoot>
        <tr id="foot-tr">
            <th>Component</th>
            <th>Count</th>
        </tr>
      </tfoot>
      </table>

      <img src="../../../assets/images/histogram.jpg" alt="">
      

</div>



