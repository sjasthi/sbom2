<?php
$nav_selected = "REPORTS";
$left_selected = "REPORTSDUPLICATEVERSIONS";
$tabTitle = "SBOM - Reports (Duplicate Versions)";

include "../bom/get_scope.php";
include("../../../../index.php");
include("reports_left_menu.php");

$def = "false";
$DEFAULT_SCOPE_FOR_RELEASES = getScope($db);
$scopeArray = array();

?>

<?php
$cookie_name = 'preference';
global $pref_err;

/*----------------- FUNCTION TO GET BOMS -----------------*/
function getReports($db)
{
  $sql = "SELECT app_id, app_name, app_version, cmpt_id, cmpt_version, cmpt_name, COUNT(app_name) AS count
    FROM apps_components
    GROUP by app_name;";
  $result = $db->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
      echo '<tr>
          <td>' . $row["app_id"] . '</td>
          <td>' . $row["app_name"] . '</td>
          <td>' . $row["app_version"] . '</td>
          <td>' . $row["cmpt_id"] . '</td>
          <td>' . $row["cmpt_version"] . '</td>
          <td>' . $row["cmpt_name"] . '</td>
          <td>' . $row["count"] . '</td>
        </tr>';
    } //end while
  } //end if
  else {
    echo "0 results";
  } //end else
  $result->close();
}

function getFilterArray($db)
{
  global $scopeArray;
  global $pdo;
  global $DEFAULT_SCOPE_FOR_RELEASES;

  $sql = "SELECT * FROM releases WHERE app_id LIKE ?";
  foreach ($DEFAULT_SCOPE_FOR_RELEASES as $currentID) {
    $sqlID = $pdo->prepare($sql);
    $sqlID->execute([$currentID]);
    if ($sqlID->rowCount() > 0) {
      while ($row = $sqlID->fetch(PDO::FETCH_ASSOC)) {
        array_push($scopeArray, $row["app_id"]);
      }
    }
  }
}

//Display error if user retrieves preferences w/o any cookies set
if (isset($_POST['getpref']) && !isset($_COOKIE[$cookie_name])) {
  $pref_err = "You don't have Reports saved.";
}
echo '<p
  style="font-size: 2.5rem;
  text-align: center;
  background-color: red;
  color: white;">' . $pref_err . '</p>'
?>

<div class="wrap">
  <h3 id=scannerHeader style="color: #01B0F1;">Reports --> Duplicate Versions </h3>
  <div class="table-container">
    <table id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered datatable-style table-hover" width="100%" style="width: 100px;">
      <thead>
        <tr id="table-first-row">
          <th>App ID</th>
          <th>App Name</th>
          <th>App Version</th>
          <th>Component ID</th>
          <th>Component Version</th>
          <th>Component Name</th>
          <th>Duplicate Count</th>
        </tr>
      </thead>
      <tbody>
        <?php
        /*----------------- GET PREFERENCE COOKIE -----------------*/
        //default if preference cookie is set, display user BOM preferences
        if (isset($_COOKIE[$cookie_name]) || isset($_COOKIE[$cookie_name]) && isset($_POST['getpref'])) {
          $def = "false";
        ?>
          <?php
          $prep = rtrim(str_repeat('?,', count(json_decode($_COOKIE[$cookie_name]))), ',');
          $sql = 'SELECT * FROM applications WHERE app_id IN (' . $prep . ')';
          $pref = $pdo->prepare($sql);
          $pref->execute(json_decode($_COOKIE[$cookie_name]));

          while ($row = $pref->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>
            <td>' . $row["app_id"] . '</td>
            <td>' . $row["app_name"] . '</td>
            <td>' . $row["app_version"] . '</td>
            <td>' . $row["cmpt_id"] . '</td>
            <td>' . $row["cmpt_version"] . '</td>
            <td>' . $row["cmpt_name"] . '</td>
            <td>' . $row["count"] . '</td>
            </tr>';
          }
        } //if no preference cookie is set but user clicks "show my BOMS"
        elseif (isset($_POST['getpref']) && !isset($_COOKIE[$cookie_name])) {
          $def = "false";
          ?>
        <?php
          getReports($db);
        } //if no preference cookie is set show all BOMS
        else {
          $def = "false";
        ?>
        <?php
          getReports($db);
        }
        ?>
      </tbody>
      <tfoot>
        <tr>
          <th>App ID</th>
          <th>App Name</th>
          <th>App Version</th>
          <th>Component ID</th>
          <th>Component Version</th>
          <th>Component Name</th>
          <th>Duplicate Count</th>
        </tr>
      </tfoot>
    </table>
  </div>

  <script type="text/javascript" language="javascript">
    $(document).ready(function() {
      $('#info').DataTable({
        dom: 'lfrtBip',
        buttons: ['copy', 'excel', 'csv', 'pdf']
      });

      $('#info thead tr').clone(true).appendTo('#info thead');
      $('#info thead tr:eq(1) th').each(function(i) {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" />');

        $('input', this).on('keyup change', function() {
          if (table.column(i).search() !== this.value) {
            table
              .column(i)
              .search(this.value)
              .draw();
          }
        });
      });

      var table = $('#info').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
        retrieve: true
      });

      /*
       * If the default scope is to be used then this will iterate through
       * each row of the datatable and hide any rows whose app_id does not
       * match a release who's app is not in the default scope
       */

      var def = <?php echo json_encode($def); ?>;
      var app_id = <?php echo json_encode($scopeArray); ?>;

      if (def === "true") {
        var indexes = table.rows().indexes().filter(
          function(value, index) {
            var currentID = table.row(value).data()[1];
            var currentIDString = JSON.stringify(currentID);
            for (var i = 0; i < app_id.length; i++) {
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
    });
  </script>