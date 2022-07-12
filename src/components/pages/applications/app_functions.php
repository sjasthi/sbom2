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

function showAppsetsAsTable($db){
    $sql_query_appsets = '
      SELECT app_set_id, app_set_name, app_id
      FROM app_sets
      ORDER BY app_set_id ASC;
    ';
    $query_appsets_result = $db->query($sql_query_appsets);
    if($query_appsets_result->num_rows < 1){
      // show err
      return;
    }
    $appset_id = NULL;
    $appset_list = [];
    while($app_from_appset = $query_appsets_result->fetch_assoc()){
      if($appset_id != $app_from_appset['app_set_id']){
        echo '<tr>';
        $appset_id = $app_from_appset['app_set_id'];
        echo '<td><input id="'.$app_from_appset['app_set_id'].'" type="radio" name="appset_radio" value="'.$app_from_appset['app_set_id'].'"></td>';
        echo'<td>'.$app_from_appset['app_set_name'].'</td>';
      } else {
        echo '<td></td>';
        echo '<td></td>';
      }
      echo'<td>'.$app_from_appset['app_id'].'</td>';
      echo '</tr>';
      $appset_list[] = $app_from_appset['app_id'];
    }
}

?>
