
<?php
    $nav_selected = "REPORTS";
    $left_selected = "REPORTSFOSSCOUNT";
    $tabTitle = "SBOM - Reports (FOSS Count)";

    include("../../../../index.php");
    include("reports_left_menu.php");

?>

<?php
  $cookie_name = 'preference';
  global $pref_err;

  /*----------------- FUNCTION TO GET BOMS -----------------*/
  function getReports($db) {
    $sql = "SELECT red_app_id,app_name, app_version, SUM(CASE WHEN issue_count > 0 THEN 1 ELSE 0 END) 
    as num_issue, SUM(issue_count) as total_issue_count 
    FROM apps_components 
    GROUP BY app_name;";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        echo '<tr>
          <td>'.$row["red_app_id"].'</td>
          <td>'.$row["app_name"].'</td>
          <td>'.$row["app_version"].' </span> </td>
          <td>'.$row["num_issue"].'</td>
          <td>'.$row["total_issue_count"].'</td>
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
    $pref_err = "You don't have Reports saved.";
  }
  echo '<p
  style="font-size: 2.5rem;
  text-align: center;
  background-color: red;
  color: white;">'.$pref_err.'</p>'
?>

    <div class="wrap">
      <h3  id = scannerHeader style = "color: #5E0174;">REPORT --> Security Visualization </h3>
      <table id="info" cellpadding="0" cellspacing="0" border="0"
        class="datatable table table-striped table-bordered datatable-style table-hover"
        width="100%" style="width: 100px;">
        <thead>
          <tr id="table-first-row">
          
            <th>Red App ID</th>
            <th>App Name</th>
            <th>App Version</th>
            <th>Componnent With Issue</th>
            <th>Total Issue Count</th>

          </tr>
        </thead>
      <tbody>
      <?php
        /*----------------- GET PREFERENCE COOKIE -----------------*/
        // Calls the function where the query is set above.
        getReports($db);

        //Checks our cookie for a preference, then grabs the info from the getReports function
        // and displays it in the appropriate rows and columns
        if(isset($_COOKIE[$cookie_name]) || isset($_COOKIE[$cookie_name]) && isset($_POST['getpref'])) {
          $def = "false";

          while($row = $pref->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>
            <td>'.$row["red_app_id"].'</td>
            <td>'.$row["app_name"].'</td>
            <td>'.$row["app_version"].' </span> </td>
            <td>'.$row["num_issue"].'</td>
            <td>'.$row["total_issue_count"].'</td>
            </tr>';
          }
        }
      ?>
      </tbody>
      <tfoot>
        <tr>
        <th>Red App ID</th>
        <th>App Name</th>
        <th>App Version</th>
        <th>Componnent With Issue</th>
        <th>Total Issue Count</th>
          
        </tr>
      </tfoot>
      </table>

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

    const listTable = document.querySelector('#info');
    const infoFilter = document.querySelector('#info_filter');
    let z = document.createElement('div');
    z.classList.add('table-container');

    z.append(listTable);
    infoFilter.after(z);

    $('.table-container').doubleScroll(); // assign a double scroll to this class
    } );
    </script>
  <html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['App name', 'Issue Count', 'Total Issue Count'],
          <?php
          $query = $db->query("SELECT red_app_id,app_name, app_version, SUM(CASE WHEN issue_count > 0 THEN 1 ELSE 0 END) 
          as num_issue, SUM(issue_count) as total_issue_count 
          FROM apps_components 
          GROUP BY app_name;");
          while ($query_row = $query->fetch_assoc()) {
              $app_name=$query_row['app_name'];
              $num_issue=$query_row['num_issue'];
              $total_issue_count=$query_row['total_issue_count'];
           ?>
           ['<?php echo $app_name;?>',<?php echo $num_issue;?>,<?php echo $total_issue_count;?>],   
           <?php   
            }
           ?> 
        ]);

        var options = {
          chart: {
            title: 'Security Issue Count',
            subtitle: 'App Name, Issue count, and Total Issue count',
          },
          bars: 'vertical' 
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
  </head>
  <body>
    <div id="barchart_material" style="width: 900px; height: 500px;"></div>
  </body>
</html>
