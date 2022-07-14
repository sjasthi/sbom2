<?php
  $nav_selected = "APPLICATIONS";
  $left_selected = "APPREPORT3";
  $tabTitle = "App Report 3";

  include "../bom/get_scope.php";
  include("../../../../index.php");
  include("app_left_menu.php");
  global $db;


   /*----------------- FUNCTION TO GET APPLICATIONS -----------------*/
   function getApplications($db) {
    $sql = "SELECT * from applications;";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        echo '<tr>
     
        <td>'.$row["app_id"].'</td>
          <td>'.$row["app_name"].'</td>
          <td>'.$row["app_version"].'</td>
          <td>'.$row["app_status"].' </span> </td>
          <td>'.$row["is_eol"].'</td>
          
        </tr>';
      }//end while
    }//end if
    else {
      echo "0 results";
    }//end else
    $result->close();
  }

  function getFilterArray($db) {
    global $scopeArray;
    global $pdo;
    global $DEFAULT_SCOPE_FOR_RELEASES;

    $sql = "SELECT * FROM releases WHERE app_id LIKE ?";
    foreach($DEFAULT_SCOPE_FOR_RELEASES as $currentID){
      $sqlID = $pdo->prepare($sql);
      $sqlID->execute([$currentID]);
      if ($sqlID->rowCount() > 0) {
        while($row = $sqlID->fetch(PDO::FETCH_ASSOC)){
          array_push($scopeArray, $row["app_id"]);
        }
      }
    }
  }
?>

<h3>App Report 3</h3>

<div class="wrap">



  
  
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

         
          // $sql = "SELECT cmpt_name, app_id, COUNT(*) as frequency FROM apps_components GROUP BY cmpt_name, app_id HAVING COUNT(*) > 1 order by frequency desc LIMIT 10";
          
          // $sql = "SELECT LicenseName, SingleCount FROM licences where LicenseName like 'Apache Public License 7.0' OR LicenseName like 'Apache Public License 9.0' OR LicenseName like 'Assembly: Obligations available in PCM' OR LicenseName like 'MIT License' OR LicenseName like 'Mozilla Public License 9.9'";
          
          // $sql ="SELECT license, COUNT(*) as frequency FROM apps_components GROUP BY license HAVING COUNT(*) > 1 order by frequency desc LIMIT 10";
          $sql ="SELECT license, COUNT(*) as frequency FROM apps_components GROUP BY license HAVING COUNT(*) > 1 LIMIT 10; ";

          $pref = $pdo->prepare($sql);
          $pref->execute();

          while($row = $pref->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>

            <td>'.$row["license"].'</td>
            <td>'.$row["frequency"].'</td>
        
            
            </tr>';

            $componentname[] = $row["license"];
            $frequency[] = $row["frequency"];
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

      <canvas  id="chartjs_bar"></canvas> 


      <script src="//code.jquery.com/jquery-1.9.1.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
      
      <script type="text/javascript">
      var ctx = document.getElementById("chartjs_bar").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels:<?php echo json_encode($componentname); ?>,
                        datasets: [{
                            backgroundColor: [
                               "#5969ff",
                                "#ff407b",
                                "#25d5f2",
                                "#ffc750",
                                "#2ec551",
                                "#7040fa",
                                "#ff004e",
                                "#ff407b",
                                "#2ec551",
                                "#5969ff",
                            ],
                            data:<?php echo json_encode($frequency); ?>,
                        }]
                    },
                    options: {
                           legend: {
                        display: true,
                        position: 'bottom',
 
                        labels: {
                            fontColor: '#71748d',
                            fontFamily: 'Circular Std Book',
                            fontSize: 14,
                        }
                    },
 
 
                }
                });
    </script>
</div>