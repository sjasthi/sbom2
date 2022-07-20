<form id="importform" action="admin_import_bom_2.php" method="post">
<h4>Column Mapping for: <span style='color: red;'><?php echo $_FILES["file"]["name"]?></span></h4>
<table>
  <tr>
    <td><label for="cmpt_id">Component ID:</label></td></td>
    <td><select id="cmpt_id" name="cmpt_id" required>
    <?php dropdown($cookie_map, 'cmpt_id', $row); ?>
    </select></td></td>

    <td><label for="cmpt_name">Component Name:</label></td></td>
    <td><select id="cmpt_name" name="cmpt_name" required>
    <?php dropdown($cookie_map, 'cmpt_name', $row); ?>
    </select></td></td>

    <td><label for="cmpt_version">Component Version:</label></td></td>
    <td><select id="cmpt_version" name="cmpt_version" required>
    <?php dropdown($cookie_map, 'cmpt_version', $row); ?>
    </select></td></td>
  </tr>

  <tr>
    <td><label for="app_id">Application ID:</label></td>
    <td><select id="app_id" name="app_id" required>
    <?php dropdown($cookie_map, 'app_id', $row); ?>
    </select></td>

    <td><label for="app_name">Application Name:</label></td>
    <td><select id="app_name" name="app_name" required>
    <?php dropdown($cookie_map, 'app_name', $row); ?>
    </select></td>

    <td><label for="app_version">Application Version:</label></td>
    <td><select id="app_version" name="app_version" required>
    <?php dropdown($cookie_map, 'app_version', $row); ?>
    </select></td>
  </tr>

  <tr>
    <td><label for="license">License:</label></td>
    <td><select id="license" name="license" required>
    <?php dropdown($cookie_map, 'license', $row); ?>
    </select></td>

    <td><label for="status">Status:</label></td>
    <td><select id="status" name="status" required>
    <?php dropdown($cookie_map, 'status', $row); ?>
    </select></td>

    <td><label for="requester">Requester:</label></td>
    <td><select id="requester" name="requester" required>
    <?php dropdown($cookie_map, 'requester', $row); ?>
    </select></td>
  </tr>

  <tr>
    <td><label for="description">Description:</label></td>
    <td><select id="description" name="description" required>
    <?php dropdown($cookie_map, 'description', $row); ?>
    </select></td>

    <td><label for="monitoring_id">Monitoring ID:</label></td>
    <td><select id="monitoring_id" name="monitoring_id" required>
    <?php dropdown($cookie_map, 'monitoring_id', $row); ?>
    </select></td>

    <td><label for="monitoring_digest">Monitoring Digest:</label></td>
    <td><select id="monitoring_digest" name="monitoring_digest" required>
    <?php dropdown($cookie_map, 'monitoring_digest', $row); ?>
    </select></td>
  </tr>

  <tr>
    <td><label for="issue_count">Issue Count:</label></td>
    <td><select id="issue_count" name="issue_count" required>
    <?php dropdown($cookie_map, 'issue_count', $row); ?>
    </select></td>
  </tr>


<?php
  // Simply passing the Red App ID from admin_import_bom_2.php back to the same
  echo '<input type="hidden" id="red_app_id_field" name="red_app_id_field" value="'.$_POST['red_app_id_form'].'">';
?>

<button type="submit" name="submitform" value="submit">Import File</button>
</form>
