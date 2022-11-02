<?php

//include "conn/connection.php";
include "master-data-query.php";

?>
           
<div class="box-header">
	<h3 class="box-title">Edit User Master Data</h3>
</div>
<hr style="margin-top: 1px;">

<?php
    $id_user = $_GET['id_user'];
    
     $query_exec2 = get_user_data_by_id($id_user);
    
        while ($row2 = mysqli_fetch_assoc($query_exec2)) {
           
        $nm_user      = $row2['nm_user'];
        $id_tipe_user = $row2['id_tipe_user'];
        $status_user  = $row2['status_user'];
        $username     = $row2['username'];
        $id_access_group = $row2['id_access_group'];

?>

    <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="registration/act-master-data.php" method="post" enctype="multipart/form-data">
        
        <div class="box-body">                            
            <div class="form-group">
               	<label for="exampleInputFile">ID User</label>
                <input type="text" class="form-control" value="<?php echo $id_user ?>" disabled>
                <input type="hidden" id="id_user" name="id_user" value ="<?php echo  $id_user; ?>">
            </div>

            <div class="form-group">
                <label>Nama User</label>
                <input type="text" class="form-control" id="nm_user" name="nm_user" value="<?php echo $nm_user; ?>" required> 
            </div>

            <div class="form-group">
                <label>Tipe User</label>
                <select class="form-control" id="tipe_user" name="tipe_user" <?php echo $list; ?> >
                    <?php
    
                        $query_exec1 = get_tipe_user();
    
                        while ($row = mysqli_fetch_assoc($query_exec1)) {

                            if ($row['id_tipe_user'] == $id_tipe_user) {
                                $this_select = " selected='selected'";
                            } else {
                                $this_select = "";
                            }

                            echo "<option value=".$row['id_tipe_user'].$this_select.">".$row['nm_tipe_user']."</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Username for login</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" required>
            </div>

            <div class="form-group">
                <label>Access Group</label>
                <select class="form-control selectpicker" name="id_access" data-live-search="true" required>
                    <option></option>
					<?php         
                        $query_exec = get_all_assigned_access_group();
                        while ($row1 = mysqli_fetch_assoc($query_exec)) {

                            if ($row1['id_access_group'] == $id_access_group) {
                                $this_select = " selected='selected'";
                            } else {
                                $this_select = "";
                            }
                            echo "<option value=".$row1['id_access_group'].$this_select.">".$row1['access_group_name']."</option>";
                        }
                    ?>
                </select>
            </div>
                
            <div class="form-group">
                <label>Status User</label>
                <select class="form-control" id="status_user" name="status_user" >
                    <option value="A">Active</option>
                    <option value="N">Not-active</option>
                </select>
            </div>                                                                       
    
    	</div><!-- /.box-body -->

        	<div class="box-footer">
        	    <button type="submit" id="edit-umaster" name="edit-umaster" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
        	</div>
    </form>

    <?php

        }
    ?>

<script src="../jquery-2/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="../js/AdminLTE/app.js" type="text/javascript"></script>


    </body>
</html>