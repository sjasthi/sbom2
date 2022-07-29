<?php
  $nav_selected = "HELP";
  $left_selected = "HELPCHAT";
  $tabTitle = "SBOM - Help (Chat)";

  include("../../../../index.php");
  include("help_left_menu.php");
  echo '<iframe width="800" height="600" src="http://ics499-dev:3000/s/sbom_bot" frameborder="0"></iframe>';
 ?>