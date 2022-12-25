<?php

//include "../conn/connection.php";
include "master-data-query.php";

?>
           
<div class="box-header">
	<h3 class="box-title">Edit Menu Master Data</h3>
</div>
<hr style="margin-top: 1px;">

<?php

    $id_menu = $_GET['id_menu'];
    $id_user = $_SESSION['id_user'];
    
     $query_exec2 = get_menu_data_by_id($id_menu);
    
        //while ($row2 = mysql_fetch_assoc($query_exec2)) {
        while ($row2 = mysqli_fetch_assoc($query_exec2)) {
           
        $menu_name    = $row2['menu_name'];
        $menu_object  = $row2['menu_object'];
        $object_path  = $row2['object_path'];
        $mn_status    = $row2['mn_status'];

?>
    <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="registration/act-master-data.php" method="post" enctype="multipart/form-data">
        
        <div class="box-body">    

            <input type="hidden" id="id_menu" name="id_menu" class="form-control" value="<?php echo $id_menu ?>">
            <input type="hidden" id="id_user" name="id_user" value ="<?php echo $id_user; ?>">

            <div class="form-group">
                <label>Menu Name</label>
                <input type="text" class="form-control" id="menu_name" name="menu_name" value="<?php echo $menu_name; ?>" required> 
            </div>

            <div class="form-group">
                <label>Menu Object</label>
                <input type="text" class="form-control" id="menu_object" name="menu_object" value="<?php echo $menu_object; ?>" required>
            </div>

            <div class="form-group">
                <label>Object Path</label>
                <input type="text" class="form-control" id="object_path" name="object_path" value="<?php echo $object_path; ?>" required>
            </div>
                
            <div class="form-group">
                <label>Status User</label>
                <select class="form-control" id="mn_status" name="mn_status" >
                    <option value="A" <?php if($mn_status == 'A'){ echo "selected"; } ?> >Active</option>
                    <option value="N" <?php if($mn_status != 'A'){ echo "selected"; } ?> >Not-active</option>
                </select>
            </div>                                                                       
    
    	</div><!-- /.box-body -->

        	<div class="box-footer">
        	    <button type="submit" id="edit-menu" name="edit-menu" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
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