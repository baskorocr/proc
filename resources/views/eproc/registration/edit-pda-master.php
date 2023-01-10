<?php

//include "../conn/connection.php";
//include "master-data-query.php";

include "purchasing_process/purch-proc-query.php";

?>
           
<div class="box-header">
	<h3 class="box-title">Edit PDA User Access Data</h3>
</div>
<hr style="margin-top: 1px;">

<?php
    $id = $_GET['id'];
    
     $query_exec2 = get_all_user_pda_data_by_id($id);
    
    while ($row2 = mysqli_fetch_assoc($query_exec2)) {
           
        $username       = $row2['username'];
        $full_name      = $row2['full_name'];
        $user_stat      = $row2['user_stat'];
        $pin            = $row2['pin'];

?>

    <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
        
        <div class="box-body">                            
            <div class="form-group">
               	<label for="exampleInputFile">ID User</label>
                <input type="text" class="form-control" value="<?php echo $id ?>" disabled>
                <input type="hidden" id="id_pda_user" name="id_pda_user" value ="<?php echo  $id; ?>">
            </div>

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo $full_name; ?>" required> 
            </div>

            <div class="form-group">
                <label>Username for PDA Access</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" required>
            </div>
            
                
            <div class="form-group">
                <label>Status User</label>
                <select class="form-control" id="user_stat" name="user_stat" >
                    <option value="A" <?php if($user_stat == 'A'){ echo "selected";} ?> >Active</option>
                    <option value="N" <?php if($user_stat == 'N'){ echo "selected";} ?> >Not-active</option>
                </select>
            </div>         

            <div class="form-group">
                <label>PIN</label>
                <input type="text" class="form-control" id="pin" name="pin" value="<?php echo $pin; ?>" maxlength="6" required>
            </div>                                                              
    
    	</div><!-- /.box-body -->

        	<div class="box-footer">
        	    <button type="submit" id="edit-umaster-pda" name="edit-umaster-pda" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
        	</div>
    </form>

    <?php

    }


    if(isset($_POST['edit-umaster-pda'])){
        
        $data['id']         = $_POST['id_pda_user'];
        $data['full_name']  = $_POST['full_name'];
        $data['username']   = $_POST['username'];
        $data['user_stat']  = $_POST['user_stat'];
        $data['pin']        = $_POST['pin'];

        update_pda_user_access($data);

        echo '
                <script>
                swal({
                    title: "Success!",
                    text: "Data has been updated!",
                    type: "success",
                    customClass: \'swal-wide\',
                    allowOutsideClick: false
                })
                    .then(function() {
                    window.location = (\'../view/home.php?mnu=pdaccs\');
                });

                </script>
                ';

    }


    ?>

<script src="../jquery-2/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="../js/AdminLTE/app.js" type="text/javascript"></script>


    </body>
</html>