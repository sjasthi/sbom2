<?php
  $nav_selected = "APPLICATIONS";
  $left_selected = "APPLICATIONS";
  $tabTitle = "SBOM - Applications";

  include "../bom/get_scope.php";



  include("../../../../index.php");

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



<div class="wrap">

    <div id="menu-left">
   

        <form id='getdef-form' name='getdef-form' method='post' action='' style='display: inline;'>
              <button type='submit' name='getall' value='submit'>App 
              List</button>
        </form>


        <form id='getdef-form' name='getdef-form' method='post' action='' style='display: inline;'>
              <button type='submit' name='getsec' value='submit'>Security Overview</button>
        </form>
    </div>
  
    <!-- <form id='getdef-form' name='getdef-form' method='post' action='' style='display: inline;'>
        <button type='submit' name='getall' value='submit'>App List</button>
    </form>

    <form id='getdef-form' name='getdef-form' method='post' action='' style='display: inline;'>
        <button type='submit' name='getsec' value='submit'>Security Overview</button>
    </form> -->

    <table id="info" cellpadding="0" cellspacing="0" border="0"
        class="datatable table table-striped table-bordered datatable-style table-hover"
        width="100%" style="width: 100px;">
        <thead>
          <tr id="table-first-row">
            <th>App ID</th>
            <th>App Name</th>
            <th>App Version</th>
            <th>App Status</th>
            <th>Is Eol</th>
          </tr>
        </thead>
        <tbody>
      <?php
        /*----------------- GET PREFERENCE COOKIE -----------------*/
        //if user clicks "get all BOMS", retrieve all BOMS
        if(isset($_POST['getall'])) {
          $def = "false";
          
          getApplications($db);
       
        }elseif(isset($_POST['getsec'])) {
          $def = "false";
          
          ?>

          <script>

            let th=document.createElement("th");
            th.append("Issue Counts");
            document.getElementById("table-first-row").append(th); 
      
          
          </script>

          <?php
           //Get DB Credentials
          $DB_SERVER = constant('DB_SERVER');
          $DB_NAME = constant('DB_NAME');
          $DB_USER = constant('DB_USER');
          $DB_PASS = constant('DB_PASS');
          //PDO connection
          $pdo = new PDO("mysql:host=$DB_SERVER;dbname=$DB_NAME", $DB_USER, $DB_PASS);

         
          $sql = "SELECT a.app_id,a.app_name,a.app_version,a.app_status,a.is_eol,(SELECT sum(apps_components.issue_count) from apps_components WHERE apps_components.app_id=a.app_id) as 'issue_counts' FROM applications a";
          
          $pref = $pdo->prepare($sql);
          $pref->execute();

          while($row = $pref->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>

            <td>'.$row["app_id"].'</td>
            <td>'.$row["app_name"].'</td>
            <td>'.$row["app_version"].'</td>
            <td>'.$row["app_status"].' </span> </td>
            <td>'.$row["is_eol"].'</td>
            <td>'.$row["issue_counts"].'</td>
            
            </tr>';
          }
        }else {
          $def = "false";
       
          getApplications($db);
        }
      ?>
      </tbody>
      <tfoot>
        <tr id="foot-tr">
            <th>App ID</th>
            <th>App Name</th>
            <th>App Version</th>
            <th>App Status</th>
            <th>Is Eol</th>
        </tr>
      </tfoot>
      </table>

      <?php
      
        if(isset($_POST['getsec'])) {

       ?>

       <script>
        
        let thf=document.createElement("th");
            thf.append("Issue Counts");
            document.getElementById("foot-tr").append(thf);
       </script>
   
       <?php   
        }
      ?>

</div>


