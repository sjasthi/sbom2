<?php
    $nav_selected = "APPLICATIONS";
    $left_selected = "APP_ID";
    $tabTitle = "Comprehensive Report";

    include("../../../../index.php");
    include("app_left_menu.php");
    ini_set('display_errors', 1);
    global $db;
?>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<div class="right-content">
    <h3> Comprehensive Report</h3>
</div>
<div class="wrap">


    <?php
    echo '<br>'.'<h3>Fix Plan: </h3>'. '<br>';  
    function getFixPlan($db)
    {
        $sql = "SELECT red_app_id, app_name,app_version,monitoring_id,monitoring_digest,
        CASE WHEN monitoring_digest = 'critical' THEN 'Need Fixing'
        ELSE 'No Fix Needed' END AS fix_plan
        FROM apps_components ;";
        $result = $db->query($sql);
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                    <td>' . $row["red_app_id"] . '</td>
                    <td>' . $row["app_name"] . '</td>
                    <td>' . $row["app_version"] . '</td>
                    <td>' . $row["monitoring_id"] . '</td>
                    <td>' . $row["monitoring_digest"] . '</td>
                    <td>' . $row["fix_plan"] . '</td>
                    </tr>';
            }
        }
        else {
            echo "0 results";
        }
        $result->close();
    }
?>

<div class="table-container">
        <table id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered datatable-style table-hover" width="100%" style="width: 100px;">
        <thead>
                <tr id="table-first-row">
                    <th>Red App ID</th>
                    <th>App Name</th>
                    <th>App Version</th>
                    <th>Monitoring ID</th>
                    <th>Monitoring Digest</th>
                    <th>Fix Plan</th>
                </tr>
            </thead>
            <tbody>
            <?php

        getFixPlan($db);
       ?>      
            </tbody>
            <tfoot>
                <tr>
                    <th>Red App ID</th>
                    <th>App Name</th>
                    <th>App Version</th>
                    <th>Monitoring ID</th>
                    <th>Monitoring Digest</th>
                    <th>Fix Plan</th>
                </tr>
            </tfoot>
        </table>
    </div>
        </div>
<?php

    // echo '<br>'.'<h3>Security Summary :</h3>'. '<br>';  

    $sql = "SELECT IF(monitoring_digest = 5 or monitoring_digest =4,'major issues', 'minor issues') as security , COUNT(monitoring_digest) as count FROM `apps_components` GROUP BY monitoring_digest";

        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row

            echo '<br>'.'<h3>Security Summary</h3>' . '<br>';
            while($row = $result->fetch_assoc()) {
                $security[]  = $row['security']  ;
                $security_count[] = $row['count'];

                echo $row['security'].': '. $row['count'] .'<br>';
               
            }//end while
        }//end if
        else {
        echo "0 results";
        }//end else
        $result->close();

        echo  "<canvas  id='chartjs_bar_security'></canvas>";


    $sql = "SELECT cmpt_name FROM `apps_components` WHERE status!='Approved'";

    $result = $db->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row

                echo '<br>'.'<h3>Components with Pending Status</h3>'. '<br>';
                while($row = $result->fetch_assoc()) {
                    echo $row['cmpt_name']. '<br>';
                
                }//end while
            }//end if
            else {
            echo "0 results";
            }//end else
            $result->close();
  

    $sql = "SELECT requester, COUNT(requester) as count FROM `apps_components` GROUP BY requester; ";

        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row

            echo '<br>'.'<h3>Requestor Summary</h3>' . '<br>';
            while($row = $result->fetch_assoc()) {
                $Requester[]  = $row['requester']  ;
                $RequesterCount[] = $row['count'];
                echo $row['requester'] ." has ".$row['count']." request". '<br>';
               
            }//end while
        }//end if
        else {
        echo "0 results";
        }//end else
        $result->close();

        echo  "<canvas  id='chartjs_bar_requestor'></canvas>";


        echo '<br>'.'<h3> EOL components : PENDING </h3>'. '<br>';  

    $sql = "SELECT cmpt_name FROM `apps_components` WHERE issue_count > 0";

        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row

            echo '<br>'.'<h3>Components With issues</h3>' . '<br>';
            while($row = $result->fetch_assoc()) {
                echo $row['cmpt_name'] .'<br>';
               
            }//end while
        }//end if
        else {
        echo "0 results";
        }//end else
        $result->close();


    $sql = "SELECT cmpt_name  FROM apps_components GROUP BY cmpt_name HAVING COUNT(app_version) > 1";

        $result = $db->query($sql);
        if ($result->num_rows > 0) {

            echo '<br>'.'<h3>Duplicate Components (multiple Versions)</h3>' . '<br>';
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo $row['cmpt_name']. '<br>';
               
            }//end while
        }//end if
        else {
        echo "0 results";
        }//end else
        $result->close();


        echo '<br>'.'<h3>  Component count  (OSS components, Commercial Components) </h3>' . '<br>';
        function getComponentCount($db)
        {
            $sql = "SELECT (SELECT count(*) FROM `apps_components` WHERE license like '%Commercial%') as commericalTotal,
            (SELECT count(*) FROM `apps_components` WHERE license not like '%Commercial%') as ossTotal;";
            $result = $db->query($sql);
        
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    $commercial[] = $row["commericalTotal"];
                    $oss[] = $row["ossTotal"] ;

                    echo '<tr>
                        <td>' . $row["commericalTotal"] . '</td>
                        <td>' . $row["ossTotal"] . '</td>
                        </tr>';
                }

                echo "<canvas  id='chartjs_bar_OSS'></canvas>";
            }
            else {
                echo "0 results";
            }
            $result->close();
        }
    ?>
    
    <div class="table-container">
            <table id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered datatable-style table-hover" width="100%" style="width: 100px;">
            <thead>
                    <tr id="table-first-row">
                        <th>Commercial Components</th>
                        <th>OSS Components</th>
                    </tr>
                </thead>
                <tbody>
                <?php
    
            // getComponentCount($db);

            $sql = "SELECT (SELECT count(*) FROM `apps_components` WHERE license like '%Commercial%') as commericalTotal,
            (SELECT count(*) FROM `apps_components` WHERE license not like '%Commercial%') as ossTotal;";
            $result = $db->query($sql);
        
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    // $commercial[] = $row["commericalTotal"];
                    // $oss[] = $row["ossTotal"] ;

                    $count_oss_commercial[] =  $row["commericalTotal"];
                    $count_oss_commercial[] =  $row["ossTotal"];

                    echo '<tr>
                        <td>' . $row["commericalTotal"] . '</td>
                        <td>' . $row["ossTotal"] . '</td>
                        </tr>';
                }

                echo "<canvas  id='chartjs_bar_OSS'></canvas>";
            }
            else {
                echo "0 results";
            }
            $result->close();
           ?>      
                </tbody>
                <tfoot>
                    <tr>
                        <th>Commercial Components</th>
                        <th>OSS Components</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


<?php
        
        echo '<br>'.'<h3>  Dependency Report (Names of Assemblies) </h3>' . '<br>';
        function getDependencyReport($db)
        {
            $sql = 
            "SELECT app_id, app_name, app_version 
            FROM `apps_components` 
            WHERE app_id NOT IN (SELECT red_app_id FROM `apps_components`);";
            $result = $db->query($sql);
        
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                            <td>' . $row["app_id"] . '</td>
                            <td>' . $row["app_name"] . '</td>
                            <td>' . $row["app_version"] . '</td>
                        </tr>';
                }
            }
            else {
                echo "0 results";
            }
            $result->close();
        }
    ?>
    
    <div class="table-container">
            <table id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered datatable-style table-hover" width="100%" style="width: 100px;">
            <thead>
                    <tr id="table-first-row">
                    <th>App Id</th>
                    <th>App Name</th>
                    <th>App Version</th>

                    </tr>
                </thead>
                <tbody>
                <?php
    
    getDependencyReport($db);
           ?>      
                </tbody>
                <tfoot>
                    <tr>
                    <th>App Id</th>
                    <th>App Name</th>
                    <th>App Version</th>

                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


<?php



    $sql = "SELECT cmpt_name  FROM apps_components  GROUP BY cmpt_name HAVING COUNT(cmpt_name) = 1";

        $result = $db->query($sql);
        if ($result->num_rows > 0) {

            echo '<br>'.'<h3>List of unique components</h3>' . '<br>';
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo $row['cmpt_name']. '<br>';
               
            }//end while
        }//end if
        else {
        echo "0 results";
        }//end else
        $result->close();


    
        $sql = "SELECT license ,COUNT(cmpt_name) as count FROM apps_components GROUP BY license;";

        $result = $db->query($sql);
        if ($result->num_rows > 0) {

            echo '<br>'.'<h3>License Counts (for each license type, how many components)</h3>' . '<br>';
            // output data of each row
            while($row = $result->fetch_assoc()) {

                $license[]=$row['license'];
                $count_license[]=$row['count'];
                echo $row['license']. ", Count: ". $row['count'] .'<br>';
               
            }//end while

            echo "<canvas  id='chartjs_bar_license'></canvas>";
        }//end if
        else {
        echo "0 results";
        }//end else
        $result->close();


        


    ?>

<script type="text/javascript">

var csecurity = document.getElementById("chartjs_bar_security").getContext('2d');
                var myChart = new Chart(csecurity, {
                    type: 'bar',
                    data: {
                        labels:<?php echo json_encode($security); ?>,
                        datasets: [{
                            backgroundColor: [
                               "#5969ff",
                                "#ff407b",
                                "#25d5f2",
                                // "#ffc750",
                                // "#2ec551",
                                // "#7040fa",
                                // "#ff004e"
                            ],
                            data:<?php echo json_encode($security_count); ?>,
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

      var ctx = document.getElementById("chartjs_bar_requestor").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels:<?php echo json_encode($Requester); ?>,
                        datasets: [{
                            backgroundColor: [
                               "#5969ff",
                                "#ff407b",
                                "#25d5f2",
                                "#ffc750",
                                "#2ec551",
                                "#7040fa",
                                "#ff004e"
                            ],
                            data:<?php echo json_encode($RequesterCount); ?>,
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


                var coss = document.getElementById("chartjs_bar_OSS").getContext('2d');
                var myChart_oss = new Chart(coss, {
                    type: 'bar',
                    data: {
                        labels:<?php echo json_encode(["Commercial Components","OSS Components"]); ?>,
                        datasets: [{
                            backgroundColor: [
                               "#5969ff",
                                "#ff407b",
                            ],
                            data:<?php echo json_encode($count_oss_commercial); ?>,
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


                var clicense = document.getElementById("chartjs_bar_license").getContext('2d');
                var myChart_oss = new Chart(clicense, {
                    type: 'bar',
                    data: {
                        labels:<?php echo json_encode($license); ?>,
                        datasets: [{
                            backgroundColor: [
                                "#5969ff",
                                "#ff407b",
                                "#25d5f2",
                                "#ffc750",
                                "#2ec551",
                                "#7040fa",
                                "#ff004e",
                                "#5969ff",
                                "#ff407b",
                                "#25d5f2",
                            ],
                            data:<?php echo json_encode($count_license); ?>,
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
