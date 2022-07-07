<?php 
    $nav_selected = "ADMIN";
    $left_selected = "USERS";
    $tabTitle = "SBOM - Admin (Users)";

    include("../../../../index.php");
    include("admin_left_menu.php");

 

?>
<html>

<style>
.head {
  text-align: center;
  font-family: "Times New Roman";
  color: rgb(200,55,0);
}

.title {
  text-align: center;
  font-family: "Times New Roman";
  color: rgb(0,200,55);
}

.words{
  text-align: center;
  font-family: "Times New Roman";
}

#guidance {
        color: grey;
        font-size: 10px;
</style>
<div class="container">
<style>#title {text-align: center; color: darkgoldenrod;}</style>

<?php


      echo '<h2 id="title">Edit Users</h2><br>';
      echo '<form action="edit_users2.php" method="POST" enctype="multipart/form-data">
      <br>
      <h3>'.$row["first_name"].' </h3> <br>
      <h3>'.$row["last_name"].' </h3> <br>
	  
	  
      <div>
        <label for="id">Id</label>
        <input type="text" class="form-control" name="id" value="'.$row["id"].'"  maxlength="5" style=width:400px readonly><br>
      </div>
      
      <div>
        <label for="first_name">First Name</label>
        <input type="text" class="form-control" name="first_name" value="'.$row["first_name"].'"  maxlength="255" style=width:400px required><br>
      </div>
      
      <div>
      
        <label for="last_name">Last Name</label>
        <textarea style=width:400px class="form-control" name= "last_name" cols="55" rows="6" required>'.$row["last_name"].'</textarea>
        </div>
          
      <div>
        <label for="email">Email </label>
        <textarea style=width:400px class="form-control" name= "email" cols="55" rows="2" required>'.$row["email"].'</textarea>
      </div>
          
      <div>
        <label for="hash">Hash</label> <label id="guidance"> </label>
        <input type="text" class="form-control" name="hash" value="'.$row["hash"].'"  maxlength="255" style=width:400px ><br>
      </div>

      <div>
        <label for="active">Active</label> <label id="guidance"> (Yes or No)</label> <br>
        <input type="text" class="form-control" name="active" value="'.$row["active"].'"  maxlength="255" style=width:400px required><br>
      </div>

      <div>
        <label for="role">Role</label>
        <input type="text" class="form-control" name="role" value="'.$row["role"].'"  maxlength="255" style=width:400px ><br>
      </div>


    </div>



      <div class="text-left">
          <button type="submit" name="submit" class="btn btn-primary btn-md align-items-center">Modify Dress</button>
      </div>
      <br>

      <br> <br>
      
      </form>';
    
    }//end while
}//end if
else {
    echo "0 results";
}//end else

?>

</div>


