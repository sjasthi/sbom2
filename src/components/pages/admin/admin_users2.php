<?php
    $nav_selected = "ADMIN";
    $left_selected = "USERS";
    $tabTitle = "SBOM - Admin (Users)";

    include("../../../../index.php");
    include("admin_left_menu.php");
	


//Read cookies for description and did you know length, use defauts if not set.
$last_name_length = 1000;
$email_length = 1000;

$description_length_cookie_name = "last_name_length";
$email_length_cookie_name = "email_length_length";

if (isset($_COOKIE[$last_name_length_cookie_name])) {
    $last_name_length = $_COOKIE[$last_name_length_cookie_name];
}

if (isset($_COOKIE[$email_length_cookie_name])) {
    $email_length = $_COOKIE[$email_length_cookie_name];
}

    $query = "SELECT id, first_name, LEFT (last_name, $last_name_length) as last_name, LEFT (email, $email_length) as email, hash, active, role, modified_time, created_time FROM users";

    $GLOBALS['data'] = mysqli_query( $db, $query );
?>

<style>
    #title {
        text-align: center;
        color: darkgoldenrod;
    }
    #toggle {
        color: 	#4397fb;
    }
    #toggle:hover {
        color: #467bc7
    }
    thead input {
        width: 100%;
    }
    .thumbnailSize{
        height: 100px;
        width: 100px;
        transition:transform 0.25s ease;
    }
    .thumbnailSize:hover {
        -webkit-transform:scale(3.5);
        transform:scale(3.5);
    }
    
</style>

<!-- Page Content -->
<br><br>
<div class="container-fluid">
    <?php
        if(isset($_GET['createDress'])){
            if($_GET["createDress"] == "Success"){
                echo '<br><h3>Success! Your Dress has been added!</h3>';
            }
        }

        if(isset($_GET['DressUpdated'])){
            if($_GET["DressUpdated"] == "Success"){
                echo '<br><h3>Success! Your Dress has been modified!</h3>';
            }
        }

        if(isset($_GET['DressDeleted'])){
            if($_GET["DressDeleted"] == "Success"){
                echo '<br><h3>Success! Your Dress has been deleted!</h3>';
            }
        }

        if(isset($_GET['createTopic'])){
            if($_GET["createTopic"] == "Success"){
                echo '<br><h3>Success! Your topic has been added!</h3>';
            }
        }
    ?>
   
    <h2 id="title">Dresses List</h2><br>
    
    <div id="customerTableView">
        <button><a class="btn btn-sm" href="create_dress.php">Create a Dress</a></button>
        <table class="display" id="ceremoniesTable" style="width:100%">
            <div class="table responsive">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>First</th>
                    <th>last</th>
                    <th>email</th>
                    <th>hash</th>
                    <th>active</th>
                    <th>role</th>
                    <th>modified_time</th>
                    <th>created_time</th>
					
                    <th>Display</th>
                    <th>Modify</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                <div>
                    <strong> Toggle column: </strong> 
                    <a id="toggle" class="toggle-vis" data-column="0">ID</a> - 
                    <a id="toggle" class="toggle-vis" data-column="1">First</a> - 
                    <a id="toggle" class="toggle-vis" data-column="2">Last</a> - 
                    <a id="toggle" class="toggle-vis" data-column="3">email</a> - 
                    <a id="toggle" class="toggle-vis" data-column="4">hash</a> - 
                    <a id="toggle" class="toggle-vis" data-column="5">active</a> - 
                    <a id="toggle" class="toggle-vis" data-column="6">role</a> -
                    <a id="toggle" class="toggle-vis" data-column="7">modified_time</a> - 
                    <a id="toggle" class="toggle-vis" data-column="8">created_time</a> -
 
                    <a id="toggle" class="toggle-vis" data-column="12">Modify</a> - 
                    <a id="toggle" class="toggle-vis" data-column="13">Delete</a> 
                </div> <br>
                
                <?php
                // fetch the data from $_GLOBALS
                if ($data->num_rows > 0) {
                    // output data of each row
                    while($row = $data->fetch_assoc()) {
                    $ID = $row["id"];
                    $first_name = $row["first_name"];
                    $last_name = $row["last_name"];
                    $email = $row["email"];
                    $hash = $row["hash"];
                    $active = $row["active"];
                    $role = $row["role"];
                    $modified_time = $row["modified_time"];
                    $created_time = $row["created_time"];


                    if(isset($_SESSION['role'])) {
                        ?>
                <tr>
                    <td><?php echo $ID; ?></td>
                    <td><div contenteditable="true" onBlur="updateValue(this,'ID','<?php echo $ID; ?>')"><?php echo $ID; ?></div></span> </td>
                    <td><div contenteditable="true" onBlur="updateValue(this,'first_name','<?php echo $ID; ?>')"><?php echo $first_name; ?></div></span> </td>
                    <td><div contenteditable="true" onBlur="updateValue(this,'last_name','<?php echo $ID; ?>')"><?php echo $last_name; ?></div></span> </td>
                    <td><div contenteditable="true" onBlur="updateValue(this,'email','<?php echo $ID; ?>')"><?php echo $email; ?></div></span> </td>
                    <td><div contenteditable="true" onBlur="updateValue(this,'hash','<?php echo $ID; ?>')"><?php echo $hash; ?></div></span> </td>
                    <td><div contenteditable="true" onBlur="updateValue(this,'active','<?php echo $ID; ?>')"><?php echo $active; ?></div></span> </td>
                    <td><div contenteditable="true" onBlur="updateValue(this,'role','<?php echo $ID; ?>')"><?php echo $role; ?></div></span> </td>
                    <td><div contenteditable="true" onBlur="updateValue(this,'modified_time','<?php echo $ID; ?>')"><?php echo $modified_time; ?></div></span> </td>
                    <td><div contenteditable="true" onBlur="updateValue(this,'created_time','<?php echo $ID; ?>')"><?php echo $created_time; ?></div></span> </td>
                   

                    <?php echo '<td><a class="btn btn-warning btn-sm" href="modify_dress.php?id='.$row["id"].'">Modify</a></td>' ?>
                    <?php echo '<td><a class="btn btn-danger btn-sm" href="deleteDress.php?id='.$row["id"].'">Delete</a></td>' ?>
                </tr>
                 <?php  
                    } else{
                      echo '<tr>
                      <td>'.$row["id"].'</td>
                      <td> </span> <a href="display_the_dress.php?id='.$row["id"].'">'.$row["ID"].'</a></td>
                      <td>'.$row["first_name"].'</td>
                      <td>'.$row["last_name"].'</td>
                      <td>'.$row["email"].' </span> </td>
                      <td>'.$row["hash"].'</td>
                      <td>'.$row["active"].'</td>
                      <td>'.$row["role"].' </span> </td>
                      <td>'.$row["modified_time"].' </span> </td>
                      <td>'.$row["created_time"].' </span> </td>
                      

                      <td><a class="btn btn-warning btn-sm" href="modify_dress.php?id='.$row["id"].'">Modify</a></td>
                      <td><a class="btn btn-danger btn-sm" href="deleteDress.php?id='.$row["id"].'">Delete</a></td>
                  </tr>';    

                    }//end while
                }//end if
            }//end second if 
  
                ?>

                </tbody>
            </div>
        </table>
    </div>
</div>

<!-- /.container -->
<!-- Footer -->
<footer class="page-footer text-center">
    <p>Created for ICS 325 Summer Project "Team Alligators"</p>
</footer>

<!--JQuery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 

<script type="text/javascript" charset="utf8"
        src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<!--Data Table-->
<script type="text/javascript" charset="utf8"
        src="https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<script type="text/javascript" language="javascript">
    $(document).ready( function () {
        
        $('#ceremoniesTable').DataTable( {
            dom: 'lfrtBip',
            buttons: [
                'copy', 'excel', 'csv', 'pdf'
            ] }
        );

        $('#ceremoniesTable thead tr').clone(true).appendTo( '#ceremoniesTable thead' );
        $('#ceremoniesTable thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    
        var table = $('#ceremoniesTable').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            retrieve: true
        } );
        
    } );

    $(document).ready(function() {
        
    var table = $('#ceremoniesTable').DataTable( {
        retrieve: true,
        "scrollY": "200px",
        "paging": false
    } );
 
    $('a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();
 
        // Get the column API object
        var column = table.column( $(this).attr('data-column') );
 
        // Toggle the visibility
        column.visible( ! column.visible() );
    } );
} );


function updateValue(element,column,id){
        var value = element.innerText
        $.ajax({
            url:'editable_list.php',
            type: 'post',
            data:{
                value: value,
                column: column,
                id: id
            },
            success:function(php_result){
				console.log(php_result);
				
            }
            
        })
    }




</script>

</body>
</html>