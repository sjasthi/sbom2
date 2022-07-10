<?php
$nav_selected = "REPORTS";
// $left_selected = "REPORTSFOSSCOUNT";
$tabTitle = "SBOM - Reports (Comprehensive Report)";

// include "../bom/get_scope.php";
include("../../../../index.php");
// include("reports_left_menu.php");

// $def = "false";
// $DEFAULT_SCOPE_FOR_RELEASES = getScope($db);
// $scopeArray = array();
?>

<?php
$cookie_name = 'preference';
global $pref_err;

//We'll need different functions to grab the data from the db. Since we are working on the same file.
//Make sure to work on your own function for each section/table we are displaying.
//There might be a better way to do it this, if you find a way make sure to let everybody know!

function getFixPlan($db)
{
    //your code here

}

function getSecuritySummary($db)
{
    //your code here

}

function getComponentsWithPendingStatus($db)
{
    //your code here

}

function getRequestorSummary($db)
{
    //your code here

}

function getEOLComponents($db)
{
    //your code here

}

function getComponentsWithIssues($db)
{
    //your code here

}

function getDuplicateComponents($db)
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

function getComponentCount($db)
{
    //your code here

}

function getDependencyReport($db)
{
    //your code here

}

function getUniqueComponents($db)
{
    //your code here

}

function getLicenseCounts($db)
{
    $sql = "SELECT app_name, app_version, SUM(CASE WHEN license NOT LIKE '%Commercial%' THEN 1 ELSE 0 END) as oss_count, SUM(CASE WHEN license LIKE '%Commercial%' THEN 1 ELSE 0 END) as commercial_count, COUNT(license) as total
    FROM apps_components
    GROUP BY app_name;";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $oss_total = 0;
        $commercial_total = 0;
        $total = 0;

        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                <td>' . $row["app_name"] . '</td>
                <td>' . $row["app_version"] . '</td>
                <td>' . $row["oss_count"] . ' </span> </td>
                <td>' . $row["commercial_count"] . '</td>
                <td>' . $row["total"] . '</td>
                </tr>';
            $oss_total += $row["oss_count"];
            $commercial_total += $row["commercial_count"];
            $total += $row["total"];
        } //end while
        echo '<tr>
            <td>' . 'z' . '</td>
            <td><b>' . 'Total ' .  '</b></td>
            <td><b>' . $oss_total . '</b></td>
            <td><b>' . $commercial_total . '</b></td>
            <td><b>' . $total . '</b></td>
            </tr>';
    } //end if
    else {
        echo "0 results";
    } //end else
    $result->close();
}

?>

<!-- We'll need to figure out how to setup the HTML to display everything -->
<div class="wrap">
    <h3 id=scannerHeader style="color: #01B0F1;">Reports --> Comprehensive Report </h3>
    <div class="table-container">
        <h4 style="color: #01B0F1;">Fix Plan</h4>
        <table id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered datatable-style table-hover" width="100%" style="width: 100px;">
            <thead>
                <tr id="table-first-row">
                    <th>App ID</th>
                    <th>App Name</th>

                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th>App ID</th>
                    <th>App Name</th>

                </tr>
            </tfoot>
        </table>
    </div>
    <div class="table-container">
        <h4 style="color: #01B0F1;">Duplicate Components</h4>
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
                    getDuplicateComponents($db);
                } //if no preference cookie is set show all BOMS
                else {
                    $def = "false";
                ?>
                <?php
                    getDuplicateComponents($db);
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
    <div class="table-container">
        <h4 style="color: #01B0F1;">Component Count</h4>
        <table id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered datatable-style table-hover" width="100%" style="width: 100px;">
            <thead>
                <tr id="table-first-row">
                    <th>App Name</th>
                    <th>App Version</th>
                    <th>OSS Count</th>
                    <th>Commercial Count</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                /*----------------- GET PREFERENCE COOKIE -----------------*/
                // Calls the function where the query is set above.
                getComponentCount($db);

                //Checks our cookie for a preference, then grabs the info from the getReports function
                // and displays it in the appropriate rows and columns
                if (isset($_COOKIE[$cookie_name]) || isset($_COOKIE[$cookie_name]) && isset($_POST['getpref'])) {
                    $def = "false";

                    while ($row = $pref->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>
                <td>' . $row["app_name"] . '</td>
                <td>' . $row["app_version"] . '</td>
                <td>' . $row["oss_count"] . ' </span> </td>
                <td>' . $row["compenents_count"] . '</td>
                <td>' . $row["total"] . '</td>
                </tr>';
                    }
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>App Name</th>
                    <th>App Version</th>
                    <th>OSS Count</th>
                    <th>Commercial Count</th>
                    <th>Total</th>
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
</div>