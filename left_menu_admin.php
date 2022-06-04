<div id="menu-left">
  <a href="admin_users.php">
      <div <?php if ($left_selected == "USERS") {
          echo 'class="menu-left-current-page"';
      } ?>>
          <img src="./images/admin_users.png">
          <br/>Users<br/></div>
  </a>

  <a href="admin_bom_backup.php">
      <div <?php if ($left_selected == "BOMBACKUP") {
          echo 'class="menu-left-current-page"';
      } ?>>
          <img src="./images/bom_backup.png">
          <br/>BOM Backup<br/></div>
  </a>

  <a href="admin_bom_compare.php">
    <div <?php if ($left_selected == "BOMCOMPARE") {
      echo 'class="menu-left-current-page"';
    } ?>>
    <img src="./images/bom_compare.png">
    <br/>BOM Compare<br/></div>
  </a>

  <a href="admin_import_bom.php">
    <div <?php if($left_selected == "IMPORTBOM") {
      echo 'class="menu-left-current-page"';
    } ?>>
    <img src="./images/image36.png" alt="Import File" width="50">
    </br>Import Bom</br></div>
  </a>
</div>
