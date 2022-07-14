<?php

include_once 'db_configuration.php';

if (isset($_POST['id'])){

    $id = mysqli_real_escape_string($db, $_POST['id']);
    $first_name = mysqli_real_escape_string($db, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($db, $_POST['last_name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $hash = mysqli_real_escape_string($db, $_POST['hash']);
    $active = mysqli_real_escape_string($db, $_POST['active']);
    $role = mysqli_real_escape_string($db, $_POST['role']);
    $modified_time = mysqli_real_escape_string($db, $_POST['modified_time']);
   $created_time = mysqli_real_escape_string($db, $_POST['created_time']);


 


}
?>
