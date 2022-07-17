<?php

  $nav_selected = "BOM";
  $left_selected = "SBOMTREE";
  $tabTitle = "SBOM - BOM (Tree)";



  include("../../../../index.php");
  include("bom_left_menu.php");
  include("bom_functions.php");

  //Get DB Credentials
  $DB_SERVER = constant('DB_SERVER');
  $DB_NAME = constant('DB_NAME');
  $DB_USER = constant('DB_USER');
  $DB_PASS = constant('DB_PASS');
  $preference_cookie_name = 'preference';

  $def = "false";
  $DEFAULT_SCOPE_FOR_RELEASES = getScope($db);
  $scopeArray = array();

  //Grabs default app_ids that are to be shown in the default scope
  function getFilterArray($db) {
    global $scopeArray;
    global $pdo;
    global $DEFAULT_SCOPE_FOR_RELEASES;

    $sql = "
      SELECT * FROM releases WHERE app_id LIKE ?
    ";
    foreach($DEFAULT_SCOPE_FOR_RELEASES as $currentID){
      $sqlID = $pdo->prepare($sql);
      $sqlID->execute([$currentID]);
      if ($sqlID->rowCount() > 0) {
        while($row = $sqlID->fetch(PDO::FETCH_ASSOC)){
          array_push($scopeArray, $row["app_id"]);
        }
      }
    }
  }

  checkUserAppsetCookie();
 ?>

<style>
 .hidden{
   display:none;
 }
 </style>


<div class="right-content">
  <div class="container" id="container">
    <h3 id=scannerHeader style="color: #01B0F1;">BOM --> BOM Tree</h3>
    <!-- Form to retrieve user preference -->
    <form id='getpref-form' name='getpref-form' method='post' action='' style='display: inline;'>
        <button type='submit' name='getpref' value='submit'>Show My BOMS</button>
      </form>
      <form id='getdef-form' name='getdef-form' method='post' action='' style='display: inline;'>
        <button type='submit' name='getdef' value='submit'>Show System Boms</button>
      </form>
      <form id='getall-form' name='getall-form' method='post' action='' style='display: inline;'>
        <button type='submit' name='getall' value='submit'>Show All BOMS</button>
      </form>

    <nav class="navbar">
    <div class="container-fluid">
      <ul class="nav navbar-nav" style='font-size: 18px;'>
        <li><a href="#" onclick="expandAll();" id = 'expandAll'><span class="glyphicon glyphicon-chevron-down"></span>Expand All</a></li>
        <li class="active"><a href="#" onclick="collapseAll();"><span class="glyphicon glyphicon-chevron-up"></span>Collapse All</a></li>
        <li><a href="#" id='color_noColor'><span id = 'no_color'>No </span>Color</a></li>
        <!-- <li><a href="#" id ="showYellow" >Show <span class="glyphicon glyphicon-tint" style='color:#ffd966;'> </span>Yellow</a></li> -->
        <li><a href="#" id="showRed">Show <span class="glyphicon glyphicon-tint" style='color:#ff6666;'> </span>Red</a></li>
        <li><a href="#" id="showRedYellow"> Show <span class="glyphicon glyphicon-tint" style='color:#ff6666;'></span>Red and <span class="glyphicon glyphicon-tint" style='color:#ffd966;'></span>Yellow</a></li>
        <li><div class="input-group">
          <input type="text" id="input" class="form-control" placeholder="Where Used" >
          <div class="input-group-btn">
            <button class="btn btn-default" type="submit"> <!--Makes the user feel better, otherwise no use.-->
              <i class="glyphicon glyphicon-search"></i>
            </button>
          </div>
        </div>
        </li>
      </ul>
</div>
</nav>
  <div>
    <h4 id="loading-text">Loading...</h4>
    <div class="h4" id="responsive-wrapper" style="opacity: 0.0;">
      <table id = "bom_treetable" >
        <thead class = 'h4'>
          <th style="width:50%" >Name</th>
          <th>Version</th>
          <th>Status</th>
        </thead>
          <?php
            $startTime = microtime(true);
            $getAppId = null;
            $findApp = false;

            if (isset($_GET['id'])){
              $getAppId = $_GET['id'];
              $findApp = true;
              $findAppName = false;
            }

            $getAppName = null;
            $getAppVer = null;
            $findAppName = false;
            if (isset($_GET['name']) && isset($_GET['version']) ){
              $getAppName= $_GET['name'];
              $getAppVer = $_GET['version'];
              $findApp = false;
              $findAppName = true;
            }
            //if user clicks "get all BOMS", retrieve all BOMS
            if(isset($_POST['getall'])) {
              ?>
              <script>document.getElementById("scannerHeader").innerHTML = "BOM --> BOM Tree --> All BOMS";</script>
              <?php
              // getAllBoms($db);
              displayBomsAsTable($db);
            }
            //If user clicks "get system BOMS", retrieve all default scope BOMS
            elseif(isset($_POST['getdef'])) {
              $is_set_sql = $db->prepare('SELECT value FROM preferences WHERE name = "ACTIVE_APP_SET"');
              if(!$is_set_sql->execute()) {
                displayBomsAsTable($db);
              } else {
                $is_set_results = $is_set_sql->get_result();
                $is_set_rows = $is_set_results->fetch_all(MYSQLI_ASSOC);
                if ( 0 < count($is_set_rows)) {
                  $system_dbom_sql = 'SELECT * FROM applications WHERE app_id in ( SELECT app_id FROM app_sets WHERE app_set_id in ( SELECT value FROM preferences WHERE name = "ACTIVE_APP_SET" ));';
                  displayBomsAsTable($db, $system_dbom_sql);
                } else {
                  displayBomsAsTable($db);
                }
              }

              ?>
              <script>document.getElementById("scannerHeader").innerHTML = "BOM --> BOM Tree --> System BOMS";</script>
              <?php
              //displayBomsAsTable($db, $sql);
            } elseif(isset($_COOKIE[$bom_app_set_cookie_name]) && isset($_POST['getpref'])) {
              //default if preference cookie is set, display user BOM preferences
                ?>
              <script>document.getElementById("scannerHeader").innerHTML = "BOM --> BOM Tree --> My BOMS";</script>
              <?php
              $prep_cookie_value = rtrim($_COOKIE[$bom_app_set_cookie_name], ',');
              $sql = "
                SELECT * FROM applications
                WHERE app_id IN (".$prep_cookie_value.")
              ";
              displayBomsAsTable($db, $sql);

            } elseif(isset($_POST['getpref']) && !isset($_COOKIE[$preference_cookie_name])) {
              //if no preference cookie is set but user clicks "show my BOMS"
              ?>
              <script>document.getElementById("scannerHeader").innerHTML = "BOM --> BOM Tree --> My BOMS";</script>
              <?php
              // getAllBoms($db);
              displayBomsAsTable($db);
            } else {
              //if no preference cookie is set show all Boms
              ?>
              <script>document.getElementById("scannerHeader").innerHTML = "BOM --> BOM Tree --> All BOMS";</script>
              <?php
              displayBomsAsTable($db);
             }
            $endTime = microtime(true) - $startTime;
          ?>
        </table>
        <span><?php echo round($endTime, 5); ?> seconds to generate</span>
        </div>
      </div>
    </div>

    <script>
      //Params for the treetable
      let sbom_params = {
        expandable: true,
        clickableNodeNames: true,
        indent: 40
      };
      $("#bom_treetable").treetable(sbom_params);
      //Function for Color/No Color Button
      $(document).ready(function(){
        $("#color_noColor").click(function(){
          $("#no_color").toggle();
          $("div .parent").toggleClass("no_color");
          $("div .child").toggleClass("no_color");
          $("div .grandchild").toggleClass("no_color");
        });
      });
        $(document).ready(function(){
        //click getRed to hide the yellows and show the reds
        $("#showRed").click(function(){
          $(".yellowComp").hide();
          $(".greenComp").hide();
          $(".redApp").show();
        });
      });
        $(document).ready(function(){
        //click getYellow to hide the reds and show the yellows
        $("#showYellow").click(function(){
          $(".yellowComp").show();
          $(".redApp").hide();
        });
      });
        $(document).ready(function(){
        //click getRedYellow to show everything
        $("#showRedYellow").click(function(){
          expandAll();
          $(".yellowComp").show();
          $(".greenComp").hide();
          $(".redApp").show();
        });
      });
      $(document).ready(function() {
        //input search for where used
        $('#input').on('keyup', function() {
          let input = $(this).val().toLowerCase();
          let cmp_nameInput = '', cmp_idInput = '';
          //Checks to see if the search terms are delineated, if yes, split input into cmp_nameInput and cmp_idInput
          //Feel free to add more delimiters to this array exxcept backslash ( \ ). I'm nearly 100% sure it'll break something, somewhere.
          let delimiterArray = [';', ':', ',', '|', '/'];
          let usingDelimiter = delimiterArray.some(function(delimiter){
            if(input.includes(delimiter)){
              [cmp_nameInput, cmp_idInput] = input.split(delimiter, 2);
              return true;
            }
          });
          //if we're not using a delimiter, assume input is only for component name
          if(!usingDelimiter){cmp_nameInput = input;}
          //Loops over each application
          $('#bom_treetable tbody').each(function() {
            let sucessfulMatch = false;
            //Check if any component name in the current application matches cmp_nameInput
            $(this).find(".component").each(function(){
              let nameMatch = false, idMatch = false;
              if($(this).find(".cmp_name").text().toLowerCase().includes(cmp_nameInput)){
                nameMatch = true;
              }
              if($(this).find(".cmp_version").text().toLowerCase().includes(cmp_idInput)){
                idMatch = true;
              }
              //Outer: if there was a sucessful match, don't bother searching more
              // 1: if (both search terms are used) and (both search terms aren't found)
              // 2: if (cmp_name is used) and (cmp_name isn't found)
              // 3: if (cmp_id is used) and (cmp_id isn't found)
              // 4: else, search successful, mark flag so we don't overwrite the show()
              if(!sucessfulMatch){
                if((cmp_nameInput != '' && cmp_idInput != '') && (!nameMatch || !idMatch)){
                  $(this).parent().hide();
                }else if((cmp_nameInput != '') && (!nameMatch)){
                  $(this).parent().hide();
                }else if((cmp_idInput != '') && (!idMatch)){
                  $(this).parent().hide();
                }else{
                  $(this).parent().show();
                  sucessfulMatch = true;
                }
              }
            });
          });
        });
      });
      document.onreadystatechange = function () {
        if (document.readyState === 'complete') {
          $('#loading-text').hide();
          $("#responsive-wrapper").css('opacity', '100.0');
        }
      }
      let expandAll = function(){
        $("#bom_treetable tbody tr.leaf").each((index, item) => {
          // setTimeout(() => {
          $("#bom_treetable").treetable("reveal", $(item).attr("data-tt-id"))
          // }, 0);
        });
      }
      let collapseAll = function(){
        let highestTimeoutId = setTimeout(";");
        for (let i = 0 ; i < highestTimeoutId ; i++) {
            clearTimeout(i);
        }
        $('#bom_treetable').treetable('collapseAll');
      }
      <?php
      if ($findApp || $findAppName) {
        echo "$( \"#expandAll\" ).trigger( \"click\" );";
      }

      ?>
      </script>
