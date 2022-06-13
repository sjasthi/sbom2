
<?php
  // set the current page to one of the main buttons
  $nav_selected = "ADMIN";
  // make the left menu buttons visible; options: YES, NO
  $left_buttons = "YES";
  // set the left menu button selected; options will change based on the main selection
  $left_selected = "ADMIN";
  include("./nav.php");

  if(!isset($_SESSION)){
    session_start();
  }

  $cookie_name = 'mapping';
  $expire = strtotime('+1 year');

  //if cookie is set, decode cookie into array
  if(isset($_COOKIE[$cookie_name])) {
    $cookie_map = json_decode($_COOKIE[$cookie_name]);
  }
?>

<html>
  <head>
    <style>
      table.center {
        margin-left:auto;
        margin-right:auto;
      }
  
      #list ul {
        display: inline-block;
        text-align: left;
      }
  
      select {
        display: block;
      }
  
      .group {
        width: 250px;
        display: inline-block;
      }
  
      #importform {
        margin-top: 1rem;
        background: #acdff2;
        padding: 2rem;
        width: 900px;
      }
  
      #importform button {
        margin-top: 3rem;
        display: block;
        background: #01B0F1;
        color: white;
        padding: .5rem 1rem;
        border: solid #ccc 1px;
        border-radius: 4px;
      }
    </style>
  </head>
  <body>
    <h2 style = "color: #01B0F1;">Admin --> Import BOM</h2>
    <div id='list'>
      <p>Before importing a file, please make sure the file is a <span style="font-weight: bold;">CSV</span>
      file with these <span style="font-weight: bold;">14 </span>columns:<br></p>
      <ul>
              <li>Red Application ID</li>
              <li>Component ID</li>
              <li>Component Name</li>
              <li>Component Version</li>
              <li>Application ID</li>
      </ul>
      <ul>
              <li>Application Name</li>
              <li>Application Version</li>
              <li>License</li>
              <li>Status</li>
              <li>Requester</li>
      </ul>
      <ul>
              <li>Description</li>
              <li>Monitoring ID</li>
              <li>Monitoring Digest</li>
              <li>Issue Count</li>
      </ul>
    </div>
    <form enctype="multipart/form-data" method="POST" role="form">
      <input type="file" name="file" id="file" size="150" style="color:black; display: inline-block;">
      <button style="background: #01B0F1; color: white;" type="submit"
      class="btn btn-default" name="submit" value="submit">Submit</button>
    </form>
  </body>
</html>

<?php
  /*if(!isset($_SESSION)){
    session_start();
  }*/
  
  $c = 0;
  
#  $labels = array('app_id', 'app_name', 'app_version', 'cmp_id', 'cmp_name',
#  'cmp_version', 'cmp_type', 'app_status', 'cmp_status', 'request_id',
#  'request_date', 'request_status', 'request_step', 'notes', 'requestor');
  $labels = array('red_app_id', 'cmpt_id', 'cmpt_name', 'cmpt_version',
	'app_id', 'app_name', 'app_version', 'license', 'status', 'requester',
	'description', 'monitoring_id', 'monitoring_digest', 'issue_count');
  $data = array();
  $map = array();
  
  if (isset($_POST['submit'])) {
    $chkfile = $_FILES['file']['name'];
    $file = $_FILES['file']['tmp_name'];
  
    //if user clicks button with no file uploaded
    if(!file_exists($file)) {
      echo "<p style='color: white; background-color: red; font-weight: bold; width: 500px;
      text-align: center; border-radius: 2px;'>NO FILE WAS SELCTED</p>";
  
    }else {
      $extension = 'csv';
      $file_ext = pathinfo($chkfile);
  
      //if the uploaded file is not a csv file
      if($file_ext['extension'] !== $extension) {
        echo "<p style='color: white; background-color: red; font-weight: bold; width: 500px;
        text-align: center; border-radius: 2px;'>PLEASE SELECT AN CSV FILE</p>";
  
      }else {
        $target_dir = "csv_files/";
        $target_file = $target_dir.basename($_FILES["file"]["name"]);
        move_uploaded_file($file,$target_file);
        $_SESSION["the_file"] = $target_file;
        $handle = fopen($target_file, "r");
  
        if(FALSE !== $handle) {
            $row = fgetcsv($handle, 1000, ',');
            if(count($row) < 14) {
              echo "<p style='color: white; background-color: red; font-weight: bold; width: 500px;
              text-align: center; border-radius: 2px;'>FILE CAN'T HAVE LESS THAN 14 COLUMNS</p>";
            }else {
              //function to populate options with headers from uploaded file
              function file_options($row) {
                foreach($row as $val) {
                  echo '<option value="'.$val.'">'.$val.'</option>';
                }
              }
  
              //function to populate options
              // IS THIS EVEN USED ANYWHERE?
              function dropdown($cookie_map, $col, $row) {
                //if mapping cookie is set, set headers from mapping cookie array as the default option
                //with headers pulled from uploaded file
                if(isset($cookie_map)) {
                  //get column headers from mapping cookie array
                  /*
                  $appid = $cookie_map[0];
                  $appname = $cookie_map[1];
                  $appver = $cookie_map[2];
                  $cmpid = $cookie_map[3];
                  $cmpname = $cookie_map[4];
                  $cmpver = $cookie_map[5];
                  $cmptype = $cookie_map[6];
                  $appstatus = $cookie_map[7];
                  $cmpstatus = $cookie_map[8];
                  $requestid = $cookie_map[9];
                  $requestdate = $cookie_map[10];
                  $requeststatus = $cookie_map[11];
                  $requeststep = $cookie_map[12];
                  $notes = $cookie_map[13];
                  $requestor = $cookie_map[14];
                  */
                  $red_app_id = $cookie_map[0];
                  $cmpt_id = $cookie_map[1];
                  $cmpt_name = $cookie_map[2];
                  $cmpt_version = $cookie_map[3];
                  $app_id = $cookie_map[4];
                  $app_name = $cookie_map[5];
                  $app_version = $cookie_map[6];
                  $license = $cookie_map[7];
                  $status = $cookie_map[8];
                  $requester = $cookie_map[9];
                  $description = $cookie_map[10];
                  $monitoring_id = $cookie_map[11];
                  $monitoring_digest = $cookie_map[12];
                  $issue_count = $cookie_map[13];
  
                  //set default option for each selection
									/*(
                  switch($col) {
                    case 'appid':
                      echo '<option value="'.$appid.'">'.$appid.'</option>';
                      file_options($row);
                      break;
                    case 'appname':
                      echo '<option value="'.$appname.'">'.$appname.'</option>';
                      file_options($row);
                      break;
                    case 'appver':
                      echo '<option value="'.$appver.'">'.$appver.'</option>';
                      file_options($row);
                    case 'cmpid':
                      echo '<option value="'.$cmpid.'">'.$cmpid.'</option>';
                      file_options($row);
                      break;
                    case 'cmpname':
                      echo '<option value="'.$cmpname.'">'.$cmpname.'</option>';
                      file_options($row);
                      break;
                    case 'cmpver':
                      echo '<option value="'.$cmpver.'">'.$cmpver.'</option>';
                      file_options($row);
                    case 'cmptype':
                      echo '<option value="'.$cmptype.'">'.$cmptype.'</option>';
                      file_options($row);
                      break;
                    case 'appstatus':
                      echo '<option value="'.$appstatus.'">'.$appstatus.'</option>';
                      file_options($row);
                      break;
                    case 'cmpstatus':
                      echo '<option value="'.$cmpstatus.'">'.$cmpstatus.'</option>';
                      file_options($row);
                    case 'cmpid':
                      echo '<option value="'.$cmpid.'">'.$cmpid.'</option>';
                      file_options($row);
                      break;
                    case 'requestid':
                      echo '<option value="'.$requestid.'">'.$requestid.'</option>';
                      file_options($row);
                      break;
                    case 'requestdate':
                      echo '<option value="'.$requestdate.'">'.$requestdate.'</option>';
                      file_options($row);
                    case 'requeststatus':
                      echo '<option value="'.$requeststatus.'">'.$requeststatus.'</option>';
                      file_options($row);
                    case 'requeststep':
                      echo '<option value="'.$requeststep.'">'.$requeststep.'</option>';
                      file_options($row);
                      break;
                    case 'notes':
                      echo '<option value="'.$notes.'">'.$notes.'</option>';
                      file_options($row);
                      break;
                    case 'requestor':
                      echo '<option value="'.$requestor.'">'.$requestor.'</option>';
                      file_options($row);
                  }
                  */
                  switch($col) {
                    case 'red_app_id':
                      echo '<option value="'.$red_app_id.'">'.$red_app_id.'</option>';
                      file_options($row);
                      break;
                    case 'cmpt_id':
                      echo '<option value="'.$cmpt_id.'">'.$cmpt_id.'</option>';
                      file_options($row);
                      break;
                    case 'cmpt_name':
                      echo '<option value="'.$cmpt_name.'">'.$cmpt_name.'</option>';
                      file_options($row);
                    case 'cmpt_version':
                      echo '<option value="'.$compt_version.'">'.$cmpt_version.'</option>';
                      file_options($row);
                      break;
                    case 'app_id':
                      echo '<option value="'.$app_id.'">'.$app_id.'</option>';
                      file_options($row);
                      break;
                    case 'app_name':
                      echo '<option value="'.$app_name.'">'.$app_name.'</option>';
                      file_options($row);
                    case 'app_version':
                      echo '<option value="'.$app_version.'">'.$app_version.'</option>';
                      file_options($row);
                      break;
                    case 'license':
                      echo '<option value="'.$license.'">'.$license.'</option>';
                      file_options($row);
                      break;
                    case 'status':
                      echo '<option value="'.$status.'">'.$status.'</option>';
                      file_options($row);
                    case 'requester':
                      echo '<option value="'.$requester.'">'.$requester.'</option>';
                      file_options($row);
                      break;
                    case 'description':
                      echo '<option value="'.$description.'">'.$description.'</option>';
                      file_options($row);
                      break;
                    case 'monitoring_id':
                      echo '<option value="'.$monitoring_id.'">'.$monitoring_id.'</option>';
                      file_options($row);
                    case 'monitoring_digest':
                      echo '<option value="'.$monitoring_digest.'">'.$monitoring_digest.'</option>';
                      file_options($row);
                      break;
                    case 'issue_count':
                      echo '<option value="'.$issue_count.'">'.$issue_count.'</option>';
                      file_options($row);
                      break;
                  }
  
                }
                //if mapping cookie is not set, populate with the uploaded file headers
                else {
                  echo '<option value="">--Select Choice--</option>';
                  file_options($row);
                }
              }
              include('import_form_2.php');
            }
        }
      }
    }
  }
?>

<?php
 if (isset($_POST['submitform'])) {
   /*
   $app_id_col = $_POST['app_id'];
   $app_name_col = $_POST['app_name'];
   $app_version_col = $_POST['app_version'];
   $cmp_id_col = $_POST['cmp_id'];
   $cmp_name_col = $_POST['cmp_name'];
   $cmp_version_col = $_POST['cmp_version'];
   $cmp_type_col = $_POST['cmp_type'];
   $app_status_col = $_POST['app_status'];
   $cmp_status_col = $_POST['cmp_status'];
   $request_id_col = $_POST['request_id'];
   $request_date_col = $_POST['request_date'];
   $request_status_col = $_POST['request_status'];
   $request_step_col = $_POST['request_step'];
   $requestor_col = $_POST['requestor'];
   $notes_col = $_POST['notes'];
   $target_file = $_SESSION["the_file"];
   */
   $red_app_id_col = $_POST['red_app_id'];
   $cmpt_id_col = $_POST['cmpt_id'];
   $cmpt_name_col = $_POST['cmpt_name'];
   $cmpt_version_col = $_POST['cmpt_version'];
   $app_id_col = $_POST['app_id'];
   $app_name_col = $_POST['app_name'];
   $app_version_col = $_POST['app_version'];
   $license_col = $_POST['license'];
   $status_col = $_POST['status'];
   $requester_col = $_POST['requester'];
   $description_col = $_POST['description'];
   $monitoring_id_col = $_POST['monitoring_id'];
   $monitoring_digest_col = $_POST['monitoring_digest'];
   $issue_count_col = $_POST['issue_count'];
   $target_file = $_SESSION["the_file"];

   //if mapping cookie is not set insert header selections into array and set cookie
   if(!isset($_COOKIE[$cookie_name])) {
     /*
     $mapping = array($app_id_col, $app_name_col, $app_version_col,
      $cmp_id_col, $cmp_name_col, $cmp_version_col, $cmp_type_col, $app_status_col,
      $cmp_status_col, $request_id_col, $request_date_col, $request_status_col,
      $request_step_col, $notes_col, $requestor_col);
     */
     $mapping = array( $red_app_id_col, $cmpt_id_col, $cmpt_name_col,
       $cmpt_version_col, $app_id_col, $app_name_col, $app_version_col,
       $license_col, $status_col, $requester_col, $description_col,
       $monitoring_id_col, $monitoring_digest_col, $issue_count_col);

     $set_map = setcookie($cookie_name, json_encode($mapping), $expire);
   }

   /*
   $headers = array($app_id_col, $app_name_col, $app_version_col, $cmp_id_col, $cmp_name_col,
   $cmp_version_col, $cmp_type_col, $app_status_col, $cmp_status_col, $request_id_col, $request_date_col,
   $request_status_col, $request_step_col, $notes_col, $requestor_col);
   */
   $headers = array( $red_app_id_col, $cmpt_id_col, $cmpt_name_col,
     $cmpt_version_col, $app_id_col, $app_name_col, $app_version_col,
     $license_col, $status_col, $requester_col, $description_col,
     $monitoring_id_col, $monitoring_digest_col, $issue_count_col);

   $data = array();
   $map = array();

   //get data
   $handle = fopen($target_file, "r");
   if(FALSE !== $handle) {
       $row = fgetcsv($handle, 1000, ',');

       //get column labels
       foreach($headers AS $header) {
         $index = array_search(strtolower($header), array_map('strtolower', $row));
         if(FALSE !== $index) {
           $map[$index] = $header;
         }
       }

       }

   while($data1 = fgetcsv($handle, 1000, ',')) {
     $row = array();
     foreach($map as $index => $field) {
       $row[$field] = $data1[$index];
     }
       $data[] = $row;
     }

     if(empty($data)) {
       echo "EMPTY";

     }else {
       /* We will no longer delete everything because we are instead appending.
       //delete existing data in table
       $sqlDelete = "DELETE FROM sbom";
       mysqli_query($db, $sqlDelete);
       */

       //insert data into database
       /*
       $sqlinsert = $db->prepare('INSERT INTO sbom (app_id, `app_name`, app_version, cmp_id,
         cmp_name, cmp_version, cmp_type, app_status, cmp_status, request_id, request_date,
         request_status, request_step, notes, requestor) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
       */
       $sqlinsert = $db->prepare('INSERT INTO apps_components ( red_app_id, cmpt_id, cmpt_name, cmpt_version, app_id, app_name, app_version, license, status, requester, description, monitoring_id, monitoring_digest, issue_count ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

       $sqlinsert->bind_param('sssssssssssssi', $red_app_id, $cmpt_id,
         $cmpt_name, $cmpt_version, $app_id, $app_name, $app_version,
         $license, $status, $requester, $description, $monitoring_id,
         $monitoring_digest, $issue_count);

       foreach ($data as $row) {
            $red_app_id = $row[$red_app_id];
            $cmpt_id = $row[$cmpt_id];
            $cmpt_name = $row[$cmpt_name];
            $cmpt_version = $row[$cmpt_version];
            $app_id = $row[$app_id];
            $app_name = $row[$app_name];
            $app_version = $row[$app_version];
            $license = $row[$license];
            $status = $row[$status];
            $requester = $row[$requester];
            $description = $row[$description];
            $monitoring_id = $row[$monitoring_id];
            $monitoring_digest = $row[$monitoring_digest];
            $issue_count = $row[$issue_count];
       }
       /* 
       $sqlinsert->bind_param('sssssssssssssss', $app_id, $app_name, $app_version,
         $cmp_id, $cmp_name, $cmp_version, $cmp_type, $app_status, $cmp_status, $request_id,
         $request_date, $request_status, $request_step, $notes, $requestor);

         foreach ($data as $row) {
               $app_id = $row[$app_id_col];
               $app_name = $row[$app_name_col];
               $app_version = $row[$app_version_col];
               $cmp_id = $row[$cmp_id_col];
               $cmp_name = $row[$cmp_name_col];
               $cmp_version = $row[$cmp_version_col];
               $cmp_type = $row[$cmp_type_col];
               $app_status = $row[$app_status_col];
               $cmp_status = $row[$cmp_status_col];
               $request_id = $row[$request_id_col];
               $request_date = $row[$request_date_col];
               $request_date = strtotime($request_date);
               $request_date = date('Y/m/d', $request_date);
               $request_status = $row[$request_status_col];
               $request_step = $row[$request_step_col];
               $notes = $row[$notes_col];
               $requestor = $row[$requestor_col];
               $sqlinsert->execute();
         }
       */
         if(!$sqlinsert->execute()) {
           echo '<p style="background: red; color: white; font-size: 2rem;">ERROR: '.$db->error.'</p>';
         }else {
           echo "<p style='color: white; background-color: green; font-weight: bold; width: 500px;
           text-align: center; border-radius: 2px;'>IMPORT SUCCESSFUL";
           echo "<br>".count($data)." rows have been successfully imported into the sbom table.</p>";
         }
     }

   }
  ?>
