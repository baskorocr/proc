<?php

include "../conn/conn.php";
include "project-mgt-query.php";

?>
           
<div class="box-header">
	<h3 class="box-title">Edit List Check Doc</h3>
</div>
<hr style="margin-top: 1px;">

<?php

    $id_check = $_GET['id'];
    
     $query_exec2 = get_list_check_data_by_id($id_check);
        while ($row2 = mysqli_fetch_assoc($query_exec2)) {
            $id_check     = $row2['id_check'];
            $nm_doc_part  = $row2['nm_doc_part'];
            $check_params = $row2['check_params'];

?>

    <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="project_mgt/act-project-mgt.php" method="post" enctype="multipart/form-data">
        
        <div class="box-body">                            
            <input type="hidden" id="id_check" name="id_check" value ="<?php echo  $id_check; ?>">
            <input type="hidden" id="id_user" name="id_user" value ="<?php echo  $_SESSION['id_user']; ?>">

            <div class="form-group">
                <label>Document Name</label>
                <input type="text" class="form-control" id="nm_doc_part" name="nm_doc_part" value="<?php echo $nm_doc_part; ?>" disabled> 
            </div> 

            <div class="form-group">
                <label>Check Parameter Name</label>
                <input type="text" class="form-control" id="check_params" name="check_params" value="<?php echo $check_params; ?>" required> 
            </div>  
                                                                      
    	</div><!-- /.box-body -->

        <div class="box-footer">
            <button type="submit" id="edit-listcheckmaster" name="edit-listcheckmaster" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
        </div>
    </form>

    <?php

        }
    ?>
<!-- jQuery 2.0.2 -->
<script src="../jquery-2/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="../js/AdminLTE/app.js" type="text/javascript"></script>


    </body>
</html>