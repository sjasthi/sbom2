<?php
    $nav_selected = "APPLICATIONS";
    $left_selected = "REPORTSPIECHART";
    $tabTitle = "SBOM - Applications(Pie Chart)";

    include("../../../../index.php");
    include("applications_left_menu.php");
    // ini_set('display_errors', 1);

    global $db;
?>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <script type="text/javascript">

    function createPieChart(pieChart){
        let name = pieChart[0];
        let columnTitle = pieChart[1];

        let queryArray = [[columnTitle, 'Count', {role:'annotation'}]];

        switch(name){
            case 'Application':
                <?php
                $query = $db->query("SELECT app_status, COUNT(app_status) AS occurrences FROM applications GROUP by app_status;");
                while($query_row = $query->fetch_assoc()) {
                    echo 'queryArray.push(["'.$query_row["app_status"].'", '.$query_row["occurrences"].', "'.$query_row["app_status"].'"]);';
                }
                ?>
                break;
        }

        return queryArray;
    }

    let pieCharts = [['Application', 'Application Status']];
    for(let i = 0; i < pieCharts.length; i++){
        pieCharts[i] = createPieChart(pieCharts[i]);
    }
    </script>

    <!-- Google Pie Chart API Code -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawPieCharts);

    function drawPieCharts() {
        pieCharts.forEach(queryArray => drawPieChart(queryArray));
    }

    function drawPieChart(queryArray){
        var data = google.visualization.arrayToDataTable(queryArray);

        let title = queryArray[0][0] + ' Report';

        var options = {
            title: title,
            width: 500,
            height: 500
        };

        var chart = new google.visualization.PieChart(document.getElementById(title.replace(/ /g, '')));

        google.visualization.events.addListener(chart, 'select', selectHandler);

        chart.draw(data, options);

        function selectHandler(){
            var selectedItem = chart.getSelection()[0];

            if (selectedItem) {
                var statusSelection = data.getValue(selectedItem.row, 0);
                var reportName = queryArray[0][0].toLowerCase().replace(/ /g, '');

                document.cookie = encodeURI("app_status_cookie=");
                switch(reportName){
                    case "applicationstatus":
                        document.cookie = encodeURI("app_status_cookie=" + statusSelection); break;
                }

                location.reload();
            }
        }

        let reportName = queryArray[0][0].toLowerCase().replace(/ /g, '');

        let length = 0;

        queryArray.forEach((slice, index) => {
            if(index !== 0){
                length += slice[1];
            }
        });

        switch(reportName){
                    case "applicationstatus":
                        document.getElementById('totalApplicationStatusReport').innerHTML = "Total: " + length; break;
                }
    }
    </script>
    <!-- End Google Pie Chart API Code -->


</head>

<div class="right-content">
    <h3> Application Pie Chart. </h3>
</div>
<div class="container">
    <div class="table-container center unset">
        <table>
            <tr>
                <td>
                    <div style=" width:400px; height:400px; disply:inline-block;" id="ApplicationStatusReport" style="width: 900px; height: 500px;"></div>
                    <p style="position:relative;z-index:1000;text-align:center" id="totalApplicationStatusReport"></p>
                </td>
            </tr>
        </table>
    </div>
<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if ($_COOKIE['app_status_cookie']!= null) {
    $appStatusSelection = $_COOKIE['app_status_cookie'];
    $sql = "SELECT app_name, app_version, app_status from applications";
    setcookie("app_status_cookie", "", time()-3600);
    echo "<table id='info' cellpadding='0' cellspacing='0' border='0'
    class='datatable table table-striped table-bordered datatable-style table-hover'
    width='100px' style='width: 750px;'>
            <thead>
                <tr id='table-first-row'>
                <th>App Status</th>
                    <th>App Name</th>
                    <th>App Version</th>


                </tr>
            </thead>
            <tbody>";
            $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo '<tr>
                                <td>'.$row["app_status"].' </span> </td>
                                <td>'.$row["app_name"].'</td>
                                <td>'.$row["app_version"].'</td>
                                </tr>';

                    }//end while
                }//end if
                else {
                    echo "0 results";
                }//end else

                $result->close();
                echo "</tbody>

            <tfoot>
            <tr>
            <th>App Status</th>
            <th>App Name</th>
            <th>App Version</th>
            </tr>
        </tfoot>


                </table>";
    }
?>

            </tbody>
        </table>


        <script type="text/javascript" language="javascript">

        var app_status, cmp_status, request_status, request_step = null;
        <?php
        if ($appStatusSelection != null) {
            echo "app_status ='".$appStatusSelection."';";
        } 
         else {
            echo "console.log(\"No Cookies Set\");";
        }
        ?>

        $(document).ready( function () {

        $('#info').DataTable( {
            dom: 'lfrtBip',
            buttons: [
                'copy', 'excel', 'csv', 'pdf'
            ] }
        );



        $('#info thead tr').clone(true).appendTo( '#info thead' );
        $('#info thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            if (title == 'App Status' && app_status != null) {
                $(this).html( '<input id = "mytext" type="text" placeholder="Search '+title+'" value = "'+app_status+'" autofocus/>' );

                $( this ).trigger( 'keyup' );
            }  else {
                $(this).html( '<input id = "mytext" type="text" placeholder="Search '+title+'"/>' );
            }

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
        table.columns(0).search( $('#mytext').val() ).draw();
    } );



</script>
</div>
