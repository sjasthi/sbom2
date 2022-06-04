<?php
    $nav_selected = ""; 
    $left_buttons = ""; 
    $left_selected = ""; 
    $error = '';
   include("./nav.php");
   if(!isset($_SESSION)){
    session_start();
    }
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = mysqli_real_escape_string($db,$_POST['email']);
      $mypassword = mysqli_real_escape_string($db,$_POST['hash']); 

      if(password_verify($mypassword, '$2y$10$zFAG5GBNtf.5BpowMqZSputSLeG8OzfKACpjAMsePjZhu.TnvU/Bu') == true){
         $sql = "SELECT * FROM users WHERE email = '$myusername'";
         $result = mysqli_query($db,$sql);
         $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
         //$active = $row['active'];
         
         $count = mysqli_num_rows($result);
         
         // If result matched $myusername and $mypassword, table row must be 1 row
         
         if($count == 1) {
            $_SESSION['login_user'] = $myusername;
            $mytype = $row['role'];
            if (strpos($mytype, "admin") !== false){
               $_SESSION['admin'] = "It is working";
            }
            
            header("location: index.php");
         }else {
            $error = "Your Login Name or Password is invalid";
         }
      }
   } 

?>
<html>
   
   <head>
      <title>Login Page</title>
      
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         .box {
            border:#666666 solid 1px;
         }
      </style>
      
   </head>
   
   <body bgcolor = "#FFFFFF">
	
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
				
            <div style = "margin:30px">
               
               <form action = "" method = "post">
                  <label>Email:</label><input type = "text" name = "email" class = "box"/><br /><br />
                  <label>Password:</label><input type = "password" name = "hash" class = "box" /><br/><br />
                  <input type = "submit" value = " Submit "/><br />
               </form>
               
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>