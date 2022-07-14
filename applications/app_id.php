<?php
    $nav_selected = "APPLICATIONS";
    $left_selected = "APP_ID";
    $tabTitle = "Comprehensive Report";

    include("../../../../index.php");
    include("app_left_menu.php");

    global $db;
?>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>




<div class="right-content">
    <h3> Comprehensive Report</h3>
</div>
<div class="wrap">


    <?php

    echo '<br>'.'<h3>Fix Plan : PENDING </h3>'. '<br>';  

    echo '<br>'.'<h3>Security Summary : PENDING </h3>'. '<br>';  


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
                echo $row['requester'] ." has ".$row['count']." request". '<br>';
               
            }//end while
        }//end if
        else {
        echo "0 results";
        }//end else
        $result->close();


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

        
        echo '<br>'.'<h3>  Dependency Report (Names of Assemblies) </h3>' . '<br>';




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
                echo $row['license']. ", Count: ". $row['count'] .'<br>';
               
            }//end while
        }//end if
        else {
        echo "0 results";
        }//end else
        $result->close();


        


    ?>
</div>
