<?php
  // set the current page to one of the main buttons
  $nav_selected = "ADMIN";
  // make the left menu buttons visible; options: YES, NO
  $left_buttons = "YES";
  // set the left menu button selected; options will change based on the main selection
  $left_selected = "ADMIN";
  include("./nav.php");
  /*
  // Changing for consistency with other locations in code
  // hard coded database was breaking for me. NAS 16.06.22
  $query = "SELECT * FROM users";
  
  $GLOBALS['data'] = mysqli_query($db, $query);
  
  $servername = 'localhost';
  $dbname = 'bom';
  $username = 'root';
  $password = '';
  */

  //Get DB Credentials
  $DB_SERVER = constant('DB_SERVER');
  $DB_NAME = constant('DB_NAME');
  $DB_USER = constant('DB_USER');
  $DB_PASS = constant('DB_PASS');
  //PDO connection
  //$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $pdo = new PDO("mysql:host=$DB_SERVER;dbname=$DB_NAME", $DB_USER, $DB_PASS);
  // Query
  $query = "SELECT * FROM users";
  $GLOBALS['data'] = mysqli_query($db, $query); // $db from initialize.php

?>

<html>

<head>
<style>
table.center {
    margin-left:auto;
    margin-right:auto;
  }
</style>
</head>

<body>      
<h3 style = "color: #01B0F1;">Admin --> Users</h3>  
<div id="customerTableView">
        <table id="info" cellpadding="0" cellspacing="0" border="0"
        class="datatable table table-striped table-bordered datatable-style table-hover"
        width="100%" style="width: 100px;">
                <thead>
                <tr id="table-first-row">
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Hash</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Modified Time</th>
                    <th>Created Time</th>
                    <th>Active</th>
                </tr>
                </thead>
                <tbody>
                <?php
                // fetch the data from $_GLOBALS
                if ($data->num_rows > 0) {
                    // output data of each row
                    while($row = $data->fetch_assoc()) {
                        echo '<tr>
                                <td>'.$row["id"].'</td>
                                <td>'.$row["first_name"].' </span> </td>
                                <td>'.$row["last_name"].'</td>
                                <td>'.$row["hash"].'</td>
                                <td>'.$row["email"].' </span> </td>
                                <td>'.$row["role"].'</td>
                                <td>'.$row["created_time"].' </span> </td>
                                <td>'.$row["modified_time"].' </span> </td>
                                <td>'.$row["active"].' </span> </td>
                            </tr>';
                    }//end while
                }//end if
                else {
                    echo "0 results";
                }//end else
        ?>

</body>

</html>
