<?php
$start_time = microtime(TRUE);
?>

<html>

<body>
    <div id="wrapper">
        <?php

        $cookie_name = 'preference';
        global $pref_err;

        function getFixPlan($db)
        {
            $app_id = $_GET['app_id'] ?? null;
            $sql = "SELECT DISTINCT red_app_id, app_name,app_version,monitoring_id,monitoring_digest,
    CASE WHEN monitoring_digest = 'critical' THEN 'Next Patch'
    ELSE 'Current Release' END AS fix_plan
    FROM apps_components
    WHERE app_id ='$app_id';";
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                <td>' . $row["red_app_id"] . '</td>
                <td>' . $row["app_name"] . '</td>
                <td>' . $row["app_version"] . '</td>
                <td>' . $row["monitoring_id"] . '</td>
                <td>' . $row["monitoring_digest"] . '</td>
                <td>' . $row["fix_plan"] . '</td>
                </tr>';
                } //end while
            } //end if
            else {
                echo "0 results";
            } //end else
            $result->close();
        }


        function getSecuritySummary($db)
        {
            $app_id = $_GET['app_id'] ?? null;
            $sql =  "SELECT DISTINCT red_app_id, app_name, app_version, cmpt_version, cmpt_id, cmpt_name, monitoring_id, monitoring_digest, issue_count
    FROM `apps_components`
    WHERE issue_count > 0 AND app_id ='$app_id';";
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
	    <td>' . $row["red_app_id"] . '</td>
          <td>' . $row["app_name"] . '</td>
          <td>' . $row["app_version"] . '</td>
          <td>' . $row["cmpt_version"] . ' </td>
          <td>' . $row["cmpt_id"] . '</td>
          <td>' . $row["cmpt_name"] . '</td>
          <td>' . $row["monitoring_id"] . '</td>
          <td>' . $row["monitoring_digest"] . '</td>
          <td>' . $row["issue_count"] . '</span> </td>
        </tr>';
                } //end while
            } //end if
            else {
                echo "0 results";
            } //end else
            $result->close();
        }

        function getComponentsWithPendingStatus($db)
        {
            $app_id = $_GET['app_id'] ?? null;
            $sql =  "SELECT app_name, app_version, cmpt_id, cmpt_name, status
    FROM `apps_components`
    WHERE status not like '%Approved%' AND app_id ='$app_id';";
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
          <td>' . $row["app_name"] . '</td>
          <td>' . $row["app_version"] . '</td>
          <td>' . $row["cmpt_id"] . '</td>
          <td>' . $row["cmpt_name"] . '</td>
          <td>' . $row["status"] . '</span> </td>
        </tr>';
                } //end while
            } //end if
            else {
                echo "0 results";
            } //end else
            $result->close();
        }
        function getRequestorSummary($db)
        {
            $app_id = $_GET['app_id'] ?? null;
            $sql = "SELECT requester, SUM(CASE WHEN status LIKE '%Approved%' THEN 1 ELSE 0 END) as total_approved, SUM(CASE WHEN status NOT LIKE '%Approved%' THEN 1 ELSE 0 END) as not_approved
    FROM apps_components
    WHERE app_id ='$app_id'
    GROUP BY requester;";
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                $approved_total = 0;
                $not_approved_total = 0;

                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
            <td>' . $row["requester"] . '</td>
            <td>' . $row["total_approved"] . ' </span> </td>
            <td>' . $row["not_approved"] . '</td>
          </tr>';
                    $approved_total += $row["total_approved"];
                    $not_approved_total += $row["not_approved"];
                } //end while
                echo '<tr>
      <td>' . 'Total' . '</b></td>
      <td><b>' . $approved_total . '</b></td>
      <td><b>' . $not_approved_total . '</b></td>
      </tr>';
            } //end if
            else {
                echo "0 results";
            } //end else
            $result->close();
        }


        function getEOLComponents($db)
        {
            $app_id = $_GET['app_id'] ?? null;
            $sql = "SELECT app_id,app_name, app_version, SUM(CASE WHEN status LIKE '%Approved%' THEN 1 ELSE 0 END)
    as is_eol
    FROM apps_components
    WHERE app_id ='$app_id'
    GROUP BY app_name;";
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                <td>' . $row["app_id"] . '</td>
                <td>' . $row["app_name"] . '</td>
                <td>' . $row["app_version"] . '</td>
                <td>' . $row["is_eol"] . '</td>
                </tr>';
                } //end while
            } //end if
            else {
                echo "0 results";
            } //end else
            $result->close();
        }

        function getComponentsWithIssues($db)
        {
            $app_id = $_GET['app_id'] ?? null;
            $sql = "SELECT DISTINCT cmpt_id, cmpt_name,cmpt_version, issue_count FROM apps_components
    WHERE issue_count > 0 AND app_id ='$app_id' order by issue_count;";
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                <td>' . $row["cmpt_id"] . '</td>
                <td>' . $row["cmpt_name"] . '</td>
                <td>' . $row["cmpt_version"] . '</td>
                <td>' . $row["issue_count"] . '</td>
                </tr>';
                } //end while
            } //end if
            else {
                echo "0 results";
            } //end else
            $result->close();
        }

        function getDuplicateComponents($db)
        {
            $app_id = $_GET['app_id'] ?? null;
            $sql = "SELECT app_id, app_name, app_version, cmpt_id, cmpt_version, cmpt_name, COUNT(app_name) AS count
    FROM apps_components
    WHERE app_id ='$app_id'
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
            $app_id = $_GET['app_id'] ?? null;
            $sql = "SELECT app_name, app_version, SUM(CASE WHEN license NOT LIKE '%Commercial%' THEN 1 ELSE 0 END) as oss_count, SUM(CASE WHEN license LIKE '%Commercial%' THEN 1 ELSE 0 END) as commercial_count, COUNT(license) as total
    FROM apps_components
    WHERE app_id ='$app_id'
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
            <td>' . '' . '</td>
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

        function getDependencyReport($db)
        {
            $app_id = $_GET['app_id'] ?? null;
            $sql = "SELECT DISTINCT app_id, app_name, app_version
    FROM apps_components
    WHERE app_id != red_app_id AND app_id ='$app_id';";
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                <td>' . $row["app_id"] . '</td>
                <td>' . $row["app_name"] . '</td>
                <td>' . $row["app_version"] . '</td>
                </tr>';
                } //end while
            } //end if
            else {
                echo "0 results";
            } //end else
            $result->close();
        }

        function getUniqueComponents($db)
        {
            $app_id = $_GET['app_id'] ?? null;
            $sql = "SELECT DISTINCT cmpt_name FROM apps_components
            WHERE app_id ='$app_id'
            ORDER BY cmpt_name;";
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
       <td>' . $row["cmpt_name"] . '</td>
        </tr>';
                } //end while
            } //end if
            else {
                echo "0 results";
            } //end else
            $result->close();
        }

        function getLicenseCounts($db)
        {
            $app_id = $_GET['app_id'] ?? null;
            $sql = "SELECT license, COUNT(*) as cmpt_number
    FROM apps_components
    WHERE app_id ='$app_id'
    GROUP BY license
    ORDER BY 2 DESC;";
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                <td>' . $row["license"] . '</td>
                <td>' . $row["cmpt_number"] . '</td>
                </tr>';
                } //end while
            } //end if
            else {
                echo "0 results";
            } //end else
            $result->close();
        }

        ?>

        <div class="wrap">
            <h3 id=scannerHeader style="color: #01B0F1;">Reports --> Comprehensive Report </h3>
            <button class="accordion" style="background-color:#01B0F1; color: #eee; width: 100%; font-size: 24px">Fix it plan</button>
            <div class="table-container" style="display:none;">
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
                        $start_time = microtime(TRUE);
                        ?>
                        <html>

                        <body>
                            <div id="wrapper">
                                <?php

                                $cookie_name = 'preference';
                                global $pref_err;

                                getFixPlan($db);
                                if (isset($_COOKIE[$cookie_name]) || isset($_COOKIE[$cookie_name]) && isset($_POST['getpref'])) {
                                    $def = "false";

                                    while ($row = $pref->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<tr>
                <td>' . $row["red_app_id"] . '</td>
                <td>' . $row["app_name"] . '</td>
                <td>' . $row["app_version"] . '</td>
                <td>' . $row["monitoring_id"] . '</td>
                <td>' . $row["monitoring_digest"] . '</td>
                <td>' . $row["fix_plan"] . '</span> </td>
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
                            <th>Monitoring ID</th>
                            <th>Monitoring Digest</th>
                            <th>Fix Plan</th>
                        </tr>
                    </tfoot>
                </table>
                <?php
                $end_time = microtime(TRUE);
                $time_taken = ($end_time - $start_time) * 1000;
                $time_taken = round($time_taken, 5);

                echo 'Fix Plan menu generated in ' . $time_taken . ' seconds.';
                ?>
            </div>
            <button class="accordion" style="background-color:#01B0F1; color: #eee; width: 100%; font-size: 24px">Security Summary </button>
            <div class="table-container" style="display:none;">
                <table id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered datatable-style table-hover" width="100%" style="width: 100px;">
                    <thead>
                        <tr id="table-first-row">
                            <th>red App Id</th>
                            <th>App Name</th>
                            <th>App Version</th>
                            <th>Cmpt Version</th>
                            <th>Cmpt Id</th>
                            <th>Cmpt Name </th>
                            <th>Monitoring Id</th>
                            <th>Monitering Digest</th>
                            <th>Issue Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $start_time = microtime(TRUE);
                        ?>
                        <html>

                        <body>
                            <div id="wrapper">
                                <?php

                                $cookie_name = 'preference';
                                global $pref_err;

                                getSecuritySummary($db);
                                if (isset($_COOKIE[$cookie_name]) || isset($_COOKIE[$cookie_name]) && isset($_POST['getpref'])) {
                                    $def = "false";

                                    while ($row = $pref->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<tr>
                <td>' . $row["red_app_id"] . '</td>
                <td>' . $row["app_name"] . '</td>
                <td>' . $row["app_version"] . '</td>
                <td>' . $row["cmpt_version"] . ' </td>
                <td>' . $row["cmpt_id"] . '</td>
                <td>' . $row["cmpt_name"] . '</td>
                <td>' . $row["monitoring_id"] . '</td>
                <td>' . $row["monitoring_digest"] . '</td>
                <td>' . $row["issue_count"] . '</span> </td>
              </tr>';
                                    }
                                }
                                ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>red App Id</th>
                            <th>App Name</th>
                            <th>App Version</th>
                            <th>Cmpt Version</th>
                            <th>Cmpt Id</th>
                            <th>Cmpt Name </th>
                            <th>Monitoring Id</th>
                            <th>Monitering Digest</th>
                            <th>Issue Count</th>
                        </tr>
                    </tfoot>
                </table>
                </script>
  </head>
  <body>
    <div id="securityChart" style="width:400; height:300"></div>
  </body>
</html>
                <?php
                $end_time = microtime(TRUE);
                $time_taken = ($end_time - $start_time) * 1000;
                $time_taken = round($time_taken, 5);

                echo 'Security Summary menu generated in ' . $time_taken . ' seconds.';
                ?>
            </div>
            <button class="accordion" style="background-color:#01B0F1; color: #eee; width: 100%; font-size: 24px;">Component With Pending Status</button>
            <div class="table-container" style="display:none;">
                <table id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered datatable-style table-hover" width="100%" style="width: 100px;">
                    <thead>
                        <tr id="table-first-row">
                            <th>App Name</th>
                            <th>App Version</th>
                            <th>Component ID</th>
                            <th>Component Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $start_time = microtime(TRUE);
                        ?>
                        <html>

                        <body>
                            <div id="wrapper">
                                <?php

                                $cookie_name = 'preference';
                                global $pref_err;

                                getComponentsWithPendingStatus($db);
                                if (isset($_COOKIE[$cookie_name]) || isset($_COOKIE[$cookie_name]) && isset($_POST['getpref'])) {
                                    $def = "false";

                                    while ($row = $pref->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<tr>
                <td>' . $row["app_name"] . '</td>
                <td>' . $row["app_version"] . '</td>
                <td>' . $row["cmp_id"] . '</td>
                <td>' . $row["cmp_name"] . '</td>
                <td>' . $row["status"] . '</span> </td>
              </tr>';
                                    }
                                }
                                ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>App Name</th>
                            <th>App Version</th>
                            <th>Component ID</th>
                            <th>Component Name</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
                </table>
                <?php
                $end_time = microtime(TRUE);
                $time_taken = ($end_time - $start_time) * 1000;
                $time_taken = round($time_taken, 5);

                echo 'Components With Pending Status menu generated in ' . $time_taken . ' seconds.';
                ?>

            </div>
            <button class="accordion" style="background-color:#01B0F1; color: #eee; width: 100%; font-size: 24px">Requester Summary</button>
            <div class="table-container" style="display:none;">
                <table id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered datatable-style table-hover" width="100%" style="width: 100px;">
                    <thead>
                        <tr id="table-first-row">
                            <th>Requestor Name</th>
                            <th>Toal Approved</th>
                            <th>Pending</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $start_time = microtime(TRUE);
                        ?>
                        <html>

                        <body>
                            <div id="wrapper">
                                <?php

                                $cookie_name = 'preference';
                                global $pref_err;
                                getRequestorSummary($db);
                                if (isset($_COOKIE[$cookie_name]) || isset($_COOKIE[$cookie_name]) && isset($_POST['getpref'])) {
                                    $def = "false";

                                    while ($row = $pref->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<tr>
                <td>' . $row["requester"] . '</td>
                <td>' . $row["total_approved"] . '</td>
=                <td>' . $row["not_approved"] . '</span> </td>
              </tr>';
                                    }
                                }
                                ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Requestor Name</th>
                            <th>Total Approved</th>
                            <th>Pending</th>

                        </tr>
                    </tfoot> 
                </table>
                </script>
  </head>
  <body>
    <div id="requesterChart" style="width:400; height:300"></div>
  </body>
</html>
                <?php
                $end_time = microtime(TRUE);
                $time_taken = ($end_time - $start_time) * 1000;
                $time_taken = round($time_taken, 5);

                echo 'EOL Components menu generated in ' . $time_taken . ' seconds.';
                ?>
        </div>

            <button class="accordion" style="background-color:#01B0F1; color: #eee; width: 100%; font-size: 24px">EOL Component</button>
            <div class="table-container" style="display:none;">
                <table id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered datatable-style table-hover" width="100%" style="width: 100px;">
                    <thead>
                        <tr id="table-first-row">
                            <th>App Id</th>
                            <th>App Name</th>
                            <th>App Version</th>
                            <th>EOL Component</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php
                        $start_time = microtime(TRUE);
                        ?>
                        <html>

                        <body>
                            <div id="wrapper">
                                <?php

                                $cookie_name = 'preference';
                                global $pref_err;


                                getEOLComponents($db);
                                if (isset($_COOKIE[$cookie_name]) || isset($_COOKIE[$cookie_name]) && isset($_POST['getpref'])) {
                                    $def = "false";

                                    while ($row = $pref->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<tr>
                <td>' . $row["app_id"] . '</td>
                <td>' . $row["app_name"] . '</td>
                <td>' . $row["app_version"] . '</td>
                <td>' . $row["is_eol"] . '</span> </td>
              </tr>';
                                    }
                                }
                                ?>
                    </tbody>
                    
                    <tfoot>
                        <tr>
                            <th>App Id</th>
                            <th>App Name</th>
                            <th>App Version</th>
                            <th>EOL Component</th>
                        </tr>
                    </tfoot>
                </table>
                
                <?php
                $end_time = microtime(TRUE);
                $time_taken = ($end_time - $start_time) * 1000;
                $time_taken = round($time_taken, 5);

                echo 'EOL Components menu generated in ' . $time_taken . ' seconds.';
                ?>
            </div>
            <button class="accordion" style="background-color:#01B0F1; color: #eee; width: 100%; font-size: 24px">Components with Issues </button>
            <div class="table-container" style="display:none;">
                <table id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered datatable-style table-hover" width="100%" style="width: 100px;">
                    <thead>
                        <tr id="table-first-row">
                            <th>Component Id</th>
                            <th>Component Name</th>
                            <th>Component Version</th>
                            <th>Issue Count</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $start_time = microtime(TRUE);
                        ?>
                        <html>

                        <body>
                            <div id="wrapper">
                                <?php

                                $cookie_name = 'preference';
                                global $pref_err;

                                getComponentsWithIssues($db);
                                if (isset($_COOKIE[$cookie_name]) || isset($_COOKIE[$cookie_name]) && isset($_POST['getpref'])) {
                                    $def = "false";

                                    while ($row = $pref->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<tr>
        <td>' . $row["cmpt_id"] . '</td>
        <td>' . $row["cmpt_name"] . '</td>
        <td>' . $row["cmpt_version"] . '</td>
        <td>' . $row["issue_count"] . '</span> </td>
      </tr>';
                                    }
                                }
                                ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Component Id</th>
                            <th>Component Name</th>
                            <th>Component Version</th>
                            <th>Issue Count</th>
                        </tr>
                    </tfoot>
                </table>
                <?php
                $end_time = microtime(TRUE);
                $time_taken = ($end_time - $start_time) * 1000;
                $time_taken = round($time_taken, 5);

                echo 'Components with Issues menu generated in ' . $time_taken . ' seconds.';
                ?>
            </div>
            <button class="accordion" style="background-color:#01B0F1; color: #eee; width: 100%; font-size: 24px">Duplicate Components</button>
            <div class="table-container" style="display:none;">
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
                        $start_time = microtime(TRUE);
                        ?>
                        <html>

                        <body>
                            <div id="wrapper">
                                <?php

                                $cookie_name = 'preference';
                                global $pref_err;

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
                <?php
                $end_time = microtime(TRUE);
                $time_taken = ($end_time - $start_time) * 1000;
                $time_taken = round($time_taken, 5);

                echo 'Duplicate Components menu generated in ' . $time_taken . ' seconds.';
                ?>
            </div>
            <button class="accordion" style="background-color:#01B0F1; color: #eee; width: 100%;font-size: 24px;">Component Count</button>
            <div class="table-container" style="display:none;">
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
                        $start_time = microtime(TRUE);
                        ?>
                        <html>

                        <body>
                            <div id="wrapper">
                                <?php

                                $cookie_name = 'preference';
                                global $pref_err;

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
                </script>
  </head>
  <body>
    <div id="componentChart" style="width:400; height:300"></div>
  </body>
</html>
                <?php
                $end_time = microtime(TRUE);
                $time_taken = ($end_time - $start_time) * 1000;
                $time_taken = round($time_taken, 5);

                echo 'Component Count menu generated in ' . $time_taken . ' seconds.';
                ?>
            </div>
            <button class="accordion" style="background-color:#01B0F1; color: #eee; width: 100%; font-size: 24px;">Dependency Report</button>
            <div class="table-container" style="display:none;">
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
                        $start_time = microtime(TRUE);
                        ?>
                        <html>

                        <body>
                            <div id="wrapper">
                                <?php

                                $cookie_name = 'preference';
                                global $pref_err;

                                getDependencyReport($db);
                                if (isset($_COOKIE[$cookie_name]) || isset($_COOKIE[$cookie_name]) && isset($_POST['getpref'])) {
                                    $def = "false";

                                    while ($row = $pref->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<tr>
                <td>' . $row["app_id"] . '</td>
                <td>' . $row["app_name"] . '</td>
                <td>' . $row["app_version"] . '</td>
                </tr>';
                                    }
                                }
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
                <?php
                $end_time = microtime(TRUE);
                $time_taken = ($end_time - $start_time) * 1000;
                $time_taken = round($time_taken, 5);
                echo 'Dependency Report menu generated in ' . $time_taken . ' seconds.';

                ?>
            </div>
            <button class="accordion" style="background-color:#01B0F1; color: #eee; width: 100%; font-size: 24px;">List of Unique Components</button>
            <div class="table-container" style="display:none;">
                <table id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered datatable-style table-hover" width="100%" style="width: 100px;">
                    <thead>
                        <<tr id="table-first-row">
                            <th>Component Name</th>

                            </tr>
                    </thead>
                    <tbody>
                        <?php
                        $start_time = microtime(TRUE);
                        ?>
                        <html>

                        <body>
                            <div id="wrapper">
                                <?php

                                $cookie_name = 'preference';
                                global $pref_err;

                                getUniqueComponents($db);
                                if (isset($_COOKIE[$cookie_name]) || isset($_COOKIE[$cookie_name]) && isset($_POST['getpref'])) {
                                    $def = "false";

                                    while ($row = $pref->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<tr>
                <td>' . $row["Cmpt_name"] . '</td>
                </tr>';
                                    }
                                }
                                ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Component Name</th>
                        </tr>
                    </tfoot>
                </table>
                <?php
                $end_time = microtime(TRUE);
                $time_taken = ($end_time - $start_time) * 1000;
                $time_taken = round($time_taken, 5);

                echo 'Unique Componenet menu generated in ' . $time_taken . ' seconds.';
                ?>
            </div>
            <button class="accordion" style="background-color:#01B0F1; color: #eee; width: 100%; font-size: 24px;">License Counts</button>
            <div class="table-container" style="display:none;">
                <table id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered datatable-style table-hover" width="100%" style="width: 100px;">
                    <thead>
                        <tr id="table-first-row">
                            <th>License</th>
                            <th># of Components</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        /*----------------- GET PREFERENCE COOKIE -----------------*/
                        // Calls the function where the query is set above.
                        getLicenseCounts($db);

                        //Checks our cookie for a preference, then grabs the info from the getReports function
                        // and displays it in the appropriate rows and columns
                        if (isset($_COOKIE[$cookie_name]) || isset($_COOKIE[$cookie_name]) && isset($_POST['getpref'])) {
                            $def = "false";

                            while ($row = $pref->fetch(PDO::FETCH_ASSOC)) {
                                echo '<tr>
                <td>' . $row["license"] . '</td>
                <td>' . $row["cmpt_number"] . '</td>
                </tr>';
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>License</th>
                            <th># of Components</th>

                        </tr>
                    </tfoot>
                </table>
                </script>
  </head>
  <body>
    <div id="licenseChart" style="width:400; height:300"></div>
  </body>
</html>
                <?php
                $end_time = microtime(TRUE);
                $time_taken = ($end_time - $start_time) * 1000;
                $time_taken = round($time_taken, 5);

                echo 'License Count menu generated in ' . $time_taken . ' seconds.';
                ?>
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
            <script type="text/javascript">
                var acc = document.getElementsByClassName("accordion");
                var i;

                for (i = 0; i < acc.length; i++) {
                    acc[i].addEventListener("click", function() {
                        /* Toggle between adding and removing the "active" class,
                        to highlight the button that controls the panel */
                        this.classList.toggle("active");

                        /* Toggle between hiding and showing the active panel */
                        var panel = this.nextElementSibling;
                        if (panel.style.display === "none") {
                            panel.style.display = "block";
                        } else {
                            panel.style.display = "none";
                        }
                    });
                }
            </script>
            <html>

            <head>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['corechart']
                    });
                    google.charts.setOnLoadCallback(drawRequesterChart);
                    google.charts.setOnLoadCallback(drawSecurityChart);
                    google.charts.setOnLoadCallback(drawComponentCount);
                    google.charts.setOnLoadCallback(drawLicenesCount);

                    function drawRequesterChart() {

                        var data = google.visualization.arrayToDataTable([
                            ['Requester name', 'Approved', 'Pending', ],
                            <?php
                            $app_id = $_GET['app_id'] ?? null;
                            $query = $db->query("SELECT requester, SUM(CASE WHEN status LIKE '%Approved%' THEN 1 ELSE 0 END) as total_approved, SUM(CASE WHEN status NOT LIKE '%Approved%' THEN 1 ELSE 0 END) as not_approved
                            FROM apps_components
                            WHERE app_id ='$app_id'
                            GROUP BY requester;");
                      
                            while ($query_row = $query->fetch_assoc()) {
                                $requester = $query_row['requester'];
                                $total_approved = $query_row['total_approved'];
                                $not_approved = $query_row['not_approved'];
                            ?>['<?php echo $requester; ?>', <?php echo $total_approved; ?>, <?php echo $not_approved; ?>],
                            <?php
                            }
                            ?>
                        ]);

                        var options = {
                            title: 'Requester count report',
                            width: 900,
                            height: 500,
                        };

                        var chart = new google.visualization.BarChart(document.getElementById("requesterChart"));
                        chart.draw(data, options);
                    }

                    function drawSecurityChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['App name', 'Security Issue Count', ],
                            <?php
                            $app_name = $_GET['app_name'] ?? null;
                            $app_version = $_GET['app_version'] ?? null;
                            $app_id = $_GET['app_id'] ?? null;
                            $query = $db->query("SELECT DISTINCT red_app_id, app_name, app_version, cmpt_version, cmpt_id, cmpt_name, monitoring_id, monitoring_digest, issue_count
                            FROM `apps_components`
                            WHERE issue_count > 0 AND app_id ='$app_id';");
   
                            while ($query_row = $query->fetch_assoc()) {
                                $app_name = $query_row['app_name'];
                                $issue_count = $query_row['issue_count'];
                            ?>['<?php echo $app_name; ?>', <?php echo $issue_count; ?>],
                            <?php
                            }
                            ?>
                        ]);
                        var options = {
                            title: 'Security Summary Report',
                            width: 900,
                            height: 500,
                        };
                        var chart = new google.visualization.BarChart(document.getElementById("securityChart"));
                        chart.draw(data, options);
                    }

                    //****************************************************** */
                    function drawComponentCount() {
                        var data = google.visualization.arrayToDataTable([
                            ['App name', 'OSS Count', 'Commercial Count'],
                            <?php
                            $app_id = $_GET['app_id'] ?? null;
                            $query = $db->query("SELECT app_name, app_version, SUM(CASE WHEN license NOT LIKE '%Commercial%' THEN 1 ELSE 0 END) as oss_count, SUM(CASE WHEN license LIKE '%Commercial%' THEN 1 ELSE 0 END) as commercial_count, COUNT(license) as total
                            FROM apps_components
                            WHERE app_id ='$app_id'
                            GROUP BY app_name;");
                            while ($query_row = $query->fetch_assoc()) {
                                $app_name = $query_row['app_name'];
                                $oss_count = $query_row['oss_count'];
                                $commercial_count = $query_row['commercial_count'];
                            ?>['<?php echo $app_name; ?>', <?php echo $oss_count; ?>, <?php echo $commercial_count; ?>],
                            <?php
                            }
                            ?>
                        ]);

                        var options = {
                            title: 'Component Count Report',
                            width: 900,
                            height: 500,
                        };

                        var chart = new google.visualization.BarChart(document.getElementById("componentChart"));
                        chart.draw(data, options);
                    }

                    function drawLicenesCount() {
                        var data = google.visualization.arrayToDataTable([
                            ['License name', 'License Count'] , 
                            <?php

                            $app_id = $_GET['app_id'] ?? null;
                            $query = $db->query("SELECT license, COUNT(*) as cmpt_number
                            FROM apps_components
                            WHERE app_id ='$app_id'
                            GROUP BY license
                            ORDER BY 2 DESC;");
   
                            while ($query_row = $query->fetch_assoc()) {
                                $license = $query_row['license'];
                                $cmpt_number = $query_row['cmpt_number'];
                            ?>['<?php echo $license; ?>', <?php echo $cmpt_number; ?>],
                            <?php
                            }
                            ?>
                        ]);
                        var options = {
                            title: 'License Count Report', 
                            width: 900,
                            height: 500,
                        };
                        var chart = new google.visualization.BarChart(document.getElementById("licenseChart"));
                        chart.draw(data, options);
                    }
                </script>
            </head>

            </html>
<?php
$end_time = microtime(TRUE);
$time_taken = ($end_time - $start_time) * 1000;
$time_taken = round($time_taken, 5);

echo 'Page generated in ' . $time_taken . ' seconds.';
?>