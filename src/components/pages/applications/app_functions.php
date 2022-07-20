<?php

function getNextAppsetId($db){
  $sql_query_last_appset_id = '
    SELECT app_set_id
    FROM app_sets
    ORDER BY app_set_id DESC
    LIMIT 1;
  ';
  $query_result = $db->query($sql_query_last_appset_id);
  if($query_result->num_rows < 1){
    return 1;
  }
  return $query_result->fetch_row()[0] + 1;
}

function createSystemAppset($db, $apps, $appset_name){
  $appset_id = getNextAppsetId($db);
  $sql_create_system_appset = '
    INSERT INTO app_sets (app_set_id, app_set_name, app_id)
    VALUES (?,?,?);
  ';
  try{
    $db->autocommit(true);
    $appset_insert = $db->prepare($sql_create_system_appset);
    foreach($apps as $app_id){
      $appset_insert->bind_param('iss', $appset_id, $appset_name, $app_id);
      $appset_insert->execute();
    }
    return $db->commit();
  } finally {
    $db->autocommit(true);
  }
}

?>
