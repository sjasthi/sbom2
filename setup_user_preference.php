<?php
// set the current page to one of the main buttons
$nav_selected = "SETUP";
// make the left menu buttons visible; options: YES, NO
$left_buttons = "YES";
// set the left menu button selected; options will change based on the main selection
$left_selected = "USERPREFERENCES";
include("./nav.php");

//PDO connection
$servername = 'localhost';
$dbname = 'bom';
$username = 'root';
$password = '';
$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$cookie_name = 'preference';
?>

<html>

<head>
<style>
table.center {
    margin-left:auto;
    margin-right:auto;
  }

#apps {
  border-collapse: collapse;
}

#apps td , #apps th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
  padding-right: 100px;
}

#apps tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>

<body>
  <h2 style = "color: #01B0F1;">Setup --> User Preferences</h2>

  </form>

  
  <?php
  if(isset($_COOKIE[$cookie_name])) {
    $prep = rtrim(str_repeat('?,', count(json_decode($_COOKIE[$cookie_name]))), ',');
    $sql = 'SELECT * FROM releases WHERE app_id IN ('.$prep.')';
    $pref = $pdo->prepare($sql);
    $pref->execute(json_decode($_COOKIE[$cookie_name]));

    echo 
    "<table id = 'apps'>
    <caption>User Saved Applications<caption>
    <tr>
      <th>App ID</th>
      <th>Application Name</th>
    </tr>";

    while($row = $pref->fetch(PDO::FETCH_ASSOC)) {
      echo '<tr>
        <td>'.$row["app_id"].'</td>
        <td>'.$row["name"].'</td>
      </tr>';
    }

    echo '</table>';
  } else {
      echo "<br><font size = '+1'>No preference cookie found.</font><br>";
  }

  ?>
  

  <?php
  $sqlLog = "SELECT * FROM preferences WHERE name = 'ENABLE_LOGGING'";
  $logList = $db->query($sqlLog);
  $logRow = $logList->fetch_assoc();

  if($logRow["value"] == "true"){
    echo "<br/>Logging is enabled<br/>";
    echo "<form id='disable-form' name='disable-form' method='post' action=''>
    <button type='submit' name='disable' value='submit'
    style='background: #01B0F1;
      color: white;
      border: none;
      border-radius: 10px;
      padding: 1rem;
      margin-right: 1rem;'>Disable Logging</button>
    </form>";
  } else {
    echo "<br/>Logging is disabled<br/>";
    echo "<form id='enable-form' name='enable-form' method='post' action=''>
    <button type='submit' name='enable' value='submit'
    style='background: #01B0F1;
      color: white;
      border: none;
      border-radius: 10px;
      padding: 1rem;
      margin-right: 1rem;'>Enable Logging</button>
    </form>";
  }

  if(isset($_POST['disable'])){
    $sql = "UPDATE preferences
    SET value = 'false'
    WHERE name = 'ENABLE_LOGGING';";
    $result = $db->query($sql);
    header("Refresh:0");
  }

  if(isset($_POST['enable'])){
    $sql = "UPDATE preferences
    SET value = 'true'
    WHERE name = 'ENABLE_LOGGING';";
    $result = $db->query($sql);
    header("Refresh:0");
  }

  echo "<br><font size='+2'>To change user BOMs you must select BOMs from the releases list to save into a browser cookie.</font>";
  ?>

</body>
</html>