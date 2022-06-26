<?php
    $nav_selected = "BOM";
    $left_selected = "BOMAPPSET";
    $tabTitle = "SBOM - BOM (APPSET)";

    include("../../../../index.php");
    include("bom_left_menu.php");

    global $db;
?>

<div class="wrap">
  <h3>BOM --> APP Sets.</h3>
  <form class="appSetForm" action="bom_create_appset.html" method="post">
    <div class="appSetName">
        <label for="bomSetName">BOM Set Name: </label>
        <input type="text" name="bomSetName" access="false" id="text-1656217535231">
    </div>
    <fieldset style="display: block;
  margin-inline-start: 2px;
  margin-inline-end: 2px;
  padding-block-start: 0.35em;
  padding-inline-start: 0.75em;
  padding-inline-end: 0.75em;
  padding-block-end: 0.625em;
  min-inline-size: min-content;
  border-width: 2px;
  border-style: groove;
  border-color: rgb(192, 192, 192);
  border-image: initial;
">
      <legend>Select BOM Apps:</legend>
      <div class="appSetCheckboxGroup">
        <input name="checkboxGroup" access="false" id="checkboxGroup" value="option-1" type="checkbox">
        <label for="checkboxGroup">Option 1</label>
      </div>
    </fieldset>
  </form>
</div>
