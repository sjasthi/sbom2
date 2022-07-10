<?php
$nav_selected = "REPORTS";
// $left_selected = "REPORTSFOSSCOUNT";
// $tabTitle = "SBOM - Reports (FOSS Count)";

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
    //your code here

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
    //your code here

}

?>

<!-- We'll need to figure out how to setup the HTML to display everything -->
<div class="wrap">
    <h3 id=scannerHeader style="color: #01B0F1;">Reports --> Comprehensive Report </h3>
    <div class="table-container">
        <table id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered datatable-style table-hover" width="100%" style="width: 100px;">

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