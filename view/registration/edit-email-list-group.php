<?php

//include "../conn/connection.php";
include "master-data-query.php";

?>
           
<div class="box-header">
	<h3 class="box-title">Edit Email Group</h3>
</div>
<hr style="margin-top: 1px;">

<?php

    $mail      = $_GET['mail'];
    $dept_code = $_GET['dept_code'];
    $id_user = $_SESSION['id_user'];
    
    $query_exec2 = get_all_email_list_group_by_mail_dept($mail, $dept_code);
    
    $row = mysqli_fetch_assoc($query_exec2);
       
    $email_name = $row['name'];
    $active     = $row['active'];

?>
    <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
        
        <div class="box-body">    

            <input type="hidden" id="id_user" name="id_user" value ="<?php echo $id_user; ?>">
            <input type="hidden" id="old_email" name="old_mail" value ="<?php echo $mail; ?>">
            <input type="hidden" id="old_deptcode" name="old_deptcode" value ="<?php echo $dept_code; ?>">
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" id="mail" name="mail" placeholder="ex. osa.maliki@dp.dharmap.com" focused required value="<?php echo $mail; ?>">  
            </div>

            <div class="form-group">
                <label>Departement</label>
                <select class="form-control selectpicker" name="dept_code" data-live-search="true" required>
                    <option></option>
                    <?php
                                
                        $query_exec = get_all_email_group();
                        while ($row1 = mysqli_fetch_assoc($query_exec)) {

                            $query_exec2 = get_all_email_group_by_dept_code($dept_code);
                            $row2 = mysqli_fetch_assoc($query_exec2);
                    ?>
                            <option value="<?php echo $row1['dept_code']; ?>" 
                                           <?php if ($row1['dept_code'] == $row2['dept_code'] ){ echo "selected"; } ?> >
                                <?php echo "[".$row1['dept_code']."] ".$row1['dept_desc']; ?>
                           </option>
                    <?php       
                        }
    
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Email Holder Name</label>
                <input type="text" class="form-control" id="email_name" name="email_name" placeholder="ex. Osa Maliki" required value="<?php echo $email_name; ?>"> 
            </div>

            <div class="form-group">
                <label>Status Active</label>
                <select class="form-control" id="active" name="active" >
                    <option value="A" <?php if($active == 'A'){ echo "selected"; } ?> >Active</option>
                    <option value="N" <?php if($active != 'A'){ echo "selected"; } ?> >Not-active</option>
                </select>
            </div>    
    
    	</div><!-- /.box-body -->

        	<div class="box-footer">
        	    <button type="submit" id="edit-email-list-group" name="edit-email-list-group" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
        	</div>
    </form>

    <?php

        if(isset($_POST['edit-email-list-group'])){

            $id_user    = $_POST['id_user'];
            $mail       = $_POST['mail'];
            $dept_code  = $_POST['dept_code'];
            $email_name = $_POST['email_name'];
            $active     = $_POST['active'];

            $old_mail      = $_POST['old_mail'];
            $old_deptcode  = $_POST['old_deptcode'];
        
            if(update_email_list_group($old_mail, $old_deptcode, $mail, $dept_code, $email_name, $active, $id_user)) {

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
                    window.location = (\'../view/home.php?mnu=emailgrlist\');
                });

                </script>
                ';
            }
            else
            {
                    echo '
                    <script>
                    swal({
                        title: "Warning!",
                        text: "No Update performed!",
                        type: "warning",
                        customClass: \'swal-wide\',
                        allowOutsideClick: false
                    })
                        .then(function() {
                        window.location = (\'../view/home.php?mnu=emailgrlist\');
                    });
                    </script>
                    ';
            
            }
        }

    ?>

<script src="../jquery-2/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="../js/AdminLTE/app.js" type="text/javascript"></script>

<!-- DATA TABLES SCRIPT -->
<script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>


    </body>
</html>