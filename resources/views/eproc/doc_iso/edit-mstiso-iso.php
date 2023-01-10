<?php

//include "../conn/conn.php";
//include "project-mgt-query.php";
include "dociso-query.php";

?>
           
<div class="box-header">
	<h3 class="box-title">Edit Master ISO Type</h3>
</div>
<hr style="margin-top: 1px;">


    <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="doc_iso/act-dociso.php" method="post" enctype="multipart/form-data">
        
        <div class="box-body">

            <?php

                $iso_type_id = $_GET['isotype_id'];
                $query_exec2 = get_mstiso_data_by_id($iso_type_id);
            
                $row2 = mysqli_fetch_assoc($query_exec2);

                $iso_type_id   = $row2['iso_type_id'];
                $iso_type_name = $row2['iso_type_name'];

            ?>

            <input type="hidden" id="iso_type_id" name="iso_type_id" value ="<?php echo $iso_type_id; ?>">

            <div class="form-group">
                <label>ISO Type ID</label>
                <input type="text" class="form-control" name="iso_type_id" value="<?php echo $iso_type_id; ?>" placeholder="ISO Type ID" required disabled>
            </div>

            <div class="form-group">
                <label>ISO Type Name</label>
                <input type="text" class="form-control" id="iso_type_name" name="iso_type_name" value="<?php echo $iso_type_name; ?>" required> 
            </div>                                                                 

      

            <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>" >                                                                 
    	</div><!-- /.box-body -->

        	<div class="box-footer">
        	    <button type="submit" id="edit-mstiso" name="edit-mstiso" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
        	</div>
    </form>


<script src="../jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="../js/AdminLTE/app.js" type="text/javascript"></script>


    </body>
</html>