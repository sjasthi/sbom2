<?php
  $nav_selected = "BOM";
  $left_buttons = "YES";
  $left_selected = "SBOMLIST";

  include "get_scope.php";
  include("../../../../index.php");
  include("bom_left_menu.php");

  //Get DB Credentials
  $DB_SERVER = constant('DB_SERVER');
  $DB_NAME = constant('DB_NAME');
  $DB_USER = constant('DB_USER');
  $DB_PASS = constant('DB_PASS');

  //PDO connection
  $pdo = new PDO("mysql:host=$DB_SERVER;dbname=$DB_NAME", $DB_USER, $DB_PASS);

  $def = "false";
  $DEFAULT_SCOPE_FOR_RELEASES = getScope($db);
  $scopeArray = array();

  require_once('calculate_color.php');
?>


<?php
  $cookie_name = 'preference';
  global $pref_err;

  /*----------------- FUNCTION TO GET BOMS -----------------*/
  function getBoms($db) {
    $sql = "SELECT * from apps_components;";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
					/*
          <td>'.$row["row_id"].'</td>
          <td><a class="btn" href="bom_sbom_tree_v2.php?id='.$row["app_id"].'">'.$row["app_id"].' </a> </td>
          <td>'.$row["app_name"].'</td>
          <td>'.$row["app_version"].'</td>
          <td>'.$row["cmp_id"].' </span> </td>
          <td>'.$row["cmp_name"].'</td>
          <td>'.$row["cmp_version"].'</td>
          <td>'.$row["cmp_type"].' </span> </td>
          <td>'.$row["app_status"].' </span> </td>
          <td>'.$row["cmp_status"].' </span> </td>
          <td>'.$row["request_id"].'</td>
          <td>'.$row["request_date"].'</td>
          <td>'.$row["request_status"].'</td>
          <td>'.$row["request_step"].'</td>
          <td>'.$row["notes"].' </span> </td>
          <td>'.$row["requester"].'</td>
          <td>'.$row["color"].'</td>
					*/
				echo '<tr>
					<td>'.$row["line_id"].'</td>
          <td>'.$row["cmpt_id"].' </span> </td>
          <td>'.$row["cmpt_name"].'</td>
          <td>'.$row["cmpt_version"].'</td>
          <td><a class="btn" href="bom_sbom_tree_v2.php?id='.$row["app_id"].'">'.$row["app_id"].' </a> </td>
          <td>'.$row["app_name"].'</td>
          <td>'.$row["app_version"].'</td>
          <td>'.$row["requester"].'</td>
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

  //Display error if user retrieves preferences w/o any cookies set
  if(isset($_POST['getpref']) && !isset($_COOKIE[$cookie_name])) {
    $pref_err = "You don't have BOMS saved.";
  }
  echo '<p
  style="font-size: 2.5rem;
  text-align: center;
  background-color: red;
  color: white;">'.$pref_err.'</p>'
?>

    <div class="wrap">
      <h3  id = scannerHeader style = "color: #01B0F1;">Scanner --> Software BOM </h3>

      <!-- Form to retrieve user preference -->
      <form id='getpref-form' name='getpref-form' method='post' action='' style='display: inline;'>
        <button type='submit' name='getpref' value='submit'
        style='background: #01B0F1;
          color: white;
          border: none;
          border-radius: 10px;
          padding: 1rem;
          margin-right: 1rem;'>Show My BOMS</button>
      </form>
      <form id='getdef-form' name='getdef-form' method='post' action='' style='display: inline;'>
        <button type='submit' name='getdef' value='submit'
        style='background: #01B0F1;
          color: white;
          border: none;
          border-radius: 10px;
          padding: 1rem;
          margin-right: 1rem;'>Show System Boms</button>
      </form>
      <form id='getall-form' name='getall-form' method='post' action='' style='display: inline;'>
        <button type='submit' name='getall' value='submit'
        style='background: #01B0F1;
          color: white;
          border: none;
          border-radius: 10px;
          padding: 1rem;'>Show All BOMS</button>
      </form>

      <h3><img src="../../../assets/images/sbom_list.png"  style="max-height: 35px;" />BOM List</h3>
      <div class="table-container">
        <table id="info" cellpadding="0" cellspacing="0" border="0"
          class="datatable table table-striped table-bordered datatable-style table-hover"
          width="100%" style="width: 100px;">
          <thead>
						<tr id="table-first-row">
              <th>Line ID</th>
              <th>Component ID</th>
              <th>Component Name</th>
              <th>Component Version</th>
              <th>Application ID</th>
              <th>Application Name</th>
              <th>Application Version</th>
              <th>Requester</th>
            </tr>
          </thead>
        <tbody>
        <?php
          /*----------------- GET PREFERENCE COOKIE -----------------*/
          //if user clicks "get all BOMS", retrieve all BOMS
          if(isset($_POST['getall'])) {
            $def = "false";
            ?>
            <script>document.getElementById("scannerHeader").innerHTML = "BOM --> Software BOM --> All BOMS";</script>
            <?php
            getBoms($db);
          //If user clicks "show system BOMS", display BOM list filtered by default system scope
          } elseif (isset($_POST['getdef'])) {
            $def = "true";
            ?>
            <script>document.getElementById("scannerHeader").innerHTML = "BOM --> Software BOM --> System BOMS";</script>
            <?php
            getBoms($db);
            getFilterArray($db);
          } //default if preference cookie is set, display user BOM preferences
          elseif(isset($_COOKIE[$cookie_name]) || isset($_COOKIE[$cookie_name]) && isset($_POST['getpref'])) {
            $def = "false";
            ?>
            <script>document.getElementById("scannerHeader").innerHTML = "BOM --> Software BOM --> My BOMS";</script>
            <?php
            $prep = rtrim(str_repeat('?,', count(json_decode($_COOKIE[$cookie_name]))), ',');
            $sql = 'SELECT * FROM sbom WHERE app_id IN ('.$prep.')';
            $pref = $pdo->prepare($sql);
            $pref->execute(json_decode($_COOKIE[$cookie_name]));

            while($row = $pref->fetch(PDO::FETCH_ASSOC)) {
								/*
                <td>'.$row["row_id"].'</td>
                <td><a class="btn" href="bom_sbom_tree_v2.php?id='.$row["app_id"].'">'.$row["app_id"].' </a> </td>
                <td>'.$row["app_name"].'</td>
                <td>'.$row["app_version"].'</td>
                <td>'.$row["cmp_id"].' </span> </td>
                <td>'.$row["cmp_name"].'</td>
                <td>'.$row["cmp_version"].'</td>
                <td>'.$row["cmp_type"].' </span> </td>
                <td>'.$row["app_status"].' </span> </td>
                <td>'.$row["cmp_status"].' </span> </td>
                <td>'.$row["request_id"].'</td>
                <td>'.$row["request_date"].'</td>
                <td>'.$row["request_status"].'</td>
                <td>'.$row["request_step"].'</td>
                <td>'.$row["notes"].' </span> </td>
                <td>'.$row["requester"].'</td>
								<td>'.$row["color"].'</td>
								*/
							echo '<tr>
					      <td>'.$row["line_id"].'</td>
						    <td>'.$row["cmpt_id"].' </span> </td>
                <td>'.$row["cmpt_name"].'</td>
							  <td>'.$row["cmpt_version"].'</td>
                <td><a class="btn" href="bom_sbom_tree_v2.php?id='.$row["app_id"].'">'.$row["app_id"].' </a> </td>
                <td>'.$row["app_name"].'</td>
                <td>'.$row["app_version"].'</td>
                <td>'.$row["requester"].'</td>
              </tr>';
            }
          }//if no preference cookie is set but user clicks "show my BOMS"
          elseif(isset($_POST['getpref']) && !isset($_COOKIE[$cookie_name])) {
            $def = "false";
            ?>
            <script>document.getElementById("scannerHeader").innerHTML = "BOM --> Software BOM --> All BOMS";</script>
            <?php
            getBoms($db);
          }//if no preference cookie is set show all BOMS
          else {
            $def = "false";
            ?>
            <script>document.getElementById("scannerHeader").innerHTML = "BOM --> Software BOM --> All BOMS";</script>
            <?php
            getBoms($db);
          }
        ?>
        </tbody>
        <tfoot>
					<tr>
            <th>Line ID</th>
            <th>Component ID</th>
            <th>Component Name</th>
            <th>Component Version</th>
            <th>Application ID</th>
            <th>Application Name</th>
            <th>Application Version</th>
            <th>Requester</th>
          </tr>
        </tfoot>
        </table>
      </div>

    <script type="text/javascript" language="javascript">
    $(document).ready( function () {
    $('#info').DataTable( {
      dom: 'lfrtBip',
      buttons: ['copy', 'excel', 'csv', 'pdf']
    } );

    $('#info thead tr').clone(true).appendTo( '#info thead' );
    $('#info thead tr:eq(1) th').each( function (i) {
      var title = $(this).text();
      $(this).html( '<input type="text" placeholder="Search '+title+'" />' );

      $( 'input', this ).on( 'keyup change', function () {
        if ( table.column(i).search() !== this.value ) {
          table
          .column(i)
          .search( this.value )
          .draw();
        }
      } );
    } );

      var table = $('#info').DataTable( {
        orderCellsTop: true,
        fixedHeader: true,
        retrieve: true
      } );

      /*
      * If the default scope is to be used then this will iterate through
      * each row of the datatable and hide any rows whose app_id does not
      * match a release who's app is not in the default scope
      */

      var def = <?php echo json_encode($def); ?>;
      var app_id = <?php echo json_encode($scopeArray); ?>;

      if (def === "true") {
        var indexes = table.rows().indexes().filter(
          function (value, index) {
            var currentID = table.row(value).data()[1];
            var currentIDString = JSON.stringify(currentID);
            for (var i = 0; i < app_id.length; i++){
            if (currentIDString.includes(app_id[i])) {
              return false;
              break;
              }
            }
            return true;
          });
        table.rows(indexes).remove().draw();
     }
    } );
  </script>
