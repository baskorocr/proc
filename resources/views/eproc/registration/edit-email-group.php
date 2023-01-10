<?php

//include "../conn/connection.php";
include "master-data-query.php";

?>
           
<div class="box-header">
	<h3 class="box-title">Edit Email Group</h3>
</div>
<hr style="margin-top: 1px;">

<?php

    $dept_code = $_GET['dept_code'];
    $id_user = $_SESSION['id_user'];
    
    $query_exec2 = get_all_email_group_by_dept_code($dept_code);
    
    $row = mysqli_fetch_assoc($query_exec2);
       
    $abrev      = $row['abrev'];
    $dept_desc  = $row['dept_desc'];

?>
    <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
        
        <div class="box-body">    

            <input type="hidden" id="id_user" name="id_user" value ="<?php echo $id_user; ?>">
            <input type="hidden" id="old_deptcode" name="old_deptcode" value ="<?php echo $dept_code; ?>">
            
            <div class="form-group">
                <label>Departement Code</label>
                <input type="text" class="form-control" id="dept_code" name="dept_code" maxlength="5" placeholder="ex. PROC" required value="<?php echo $dept_code; ?>"> 
            </div>
            <div class="form-group">
                <label>Abbreviation (SAP PO Creator)</label>
                <input type="text" class="form-control" id="abrev" name="abrev" maxlength="10" placeholder="ex. PRO" required value="<?php echo $abrev; ?>"> 
            </div>
            <div class="form-group">
                <label>Departement Description</label>
                <input type="text" class="form-control" id="dept_desc" name="dept_desc" maxlength="50" placeholder="ex. Procurement" value="<?php echo $dept_desc; ?>"> 
            </div>
    
    	</div><!-- /.box-body -->

        	<div class="box-footer">
        	    <button type="submit" id="edit-email-group" name="edit-email-group" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
        	</div>
    </form>

    <?php

        if(isset($_POST['edit-email-group'])){

            $id_user       = $_POST['id_user'];
            $dept_code     = $_POST['dept_code'];
            $abrev         = $_POST['abrev'];
            $dept_desc     = $_POST['dept_desc'];
            $old_deptcode  = $_POST['old_deptcode'];

            if(update_email_group($old_deptcode, $dept_code, $abrev, $dept_desc, $id_user)) {

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
                    window.location = (\'../view/home.php?mnu=emailgrp\');
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
                        window.location = (\'../view/home.php?mnu=emailgrp\');
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