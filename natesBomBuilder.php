<html>
  <head>
  </head>
  <body>
    <h1>Nate's Bom Builder</h1>
    <form action="./natesBomBuilder.php" method="POST">
      <label for="number">Enter desired number of components:</label>
      <input type="number" id="number" name="number"></br>
      <label for="number">Enter desired number of 'red' applications:</label>
      <input type="number" id="red_number" name="red_number" value="1"></br>
      <input type="submit" value="Build a Bom">
    </form>
  </body>
</html>
<?php
  $cmpt_position = 0;
  $red_app_position = 0;
  $branch_position = 0;
  include("./src/db/database.php");

  if(isset($_POST['number'])) {
    $cmpt_count = (int)$_POST['number'];
    $red_app_count = (int)$_POST['red_number'];
    $branch_count = intdiv($cmpt_count,6);
    $cmpt_per_red_app = intdiv($cmpt_count,$red_app_count);
    $branch_per_red_app = intdiv($cmpt_per_red_app,6);
    echo "<p>cmpt_count: ".$cmpt_count."</p>\n<p>red_app_count: ".$red_app_count."</p>\n<p>branch_count: ".$branch_count."</p>\n<p>cmpt_per_red_app: ".$cmpt_per_red_app."</p>\n<p>branch_per_red_app: ".$branch_per_red_app."</p>";

    for ( $i = 0; $i < $red_app_count; $i++) {
      $red_app_id =  $red_app_position;
      $red_app_ver = random_int(1,100).".".random_int(1,100).".".random_int(1,100);
      echo "<h3>Red App ID: ".sprintf("%'.08d", $red_app_id)."</h3>\n";
      $parent_id_buffer = $red_app_id;
      $parent_ver_buffer = $red_app_ver;
      $rando_ver = random_int(1,100).".".random_int(1,100).".".random_int(1,100);
      $red_app_position++;
      for ( $j = 0; $j < $cmpt_per_red_app; $j++ ) {

        echo sprintf("%'.08d", $cmpt_position).","."component_".$cmpt_position.",".$rando_ver.",".sprintf("%'.08d", $parent_id_buffer).",component_".$parent_id_buffer.",".$parent_ver_buffer.",GPLv3,approved,Nate's Buffer Builder,Description of component_".$parent_id_buffer.",".sprintf("%'.08d", $cmpt_position).",na,0".",\n</br>";
        $branch_position = ( $branch_position + 7 ) % 6;
	if ( $branch_position == 0 ) {
	  $parent_id_buffer = $red_app_id;
	  $parent_ver_buffer = $red_app_ver;
	} else {
	  $parent_id_buffer = $cmpt_position;
	  $parent_ver_buffer = $rando_ver;
	}
	
	$cmpt_position++;
//        $rando_ver = random_int(1,100).".".random_int(1,100).".".random_int(1,100);
      }
    }
  }
?> 