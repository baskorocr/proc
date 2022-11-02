<?php

include "../conn/conn.php";
include "project-mgt-query.php";

?>
           
<div class="box-header">
	<h3 class="box-title">Edit Document Master</h3>
</div>

<?php

    $id_doc_part = $_GET['id_doc'];
    
     $query_exec2 = get_doc_data_by_id($id_doc_part);
    
        while ($row2 = mysqli_fetch_assoc($query_exec2)) {

          $nm_doc_part= $row2['nm_doc_part'];

?>

    <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="project_mgt/act-project-mgt.php" method="post" enctype="multipart/form-data">
        
        <div class="box-body">                            
            <div class="form-group">
               	<label for="exampleInputFile">ID Document</label>
                <input type="text" class="form-control" value="<?php echo $id_doc_part ?>" disabled>
                <input type="hidden" id="id_doc_part" name="id_doc_part" value ="<?php echo  $id_doc_part; ?>">
                <input type="hidden" id="id_user" name="id_user" value ="<?php echo  $_SESSION['id_user']; ?>">
            </div>

            <div class="form-group">
                <label>Nama Document</label>
                <input type="text" class="form-control" id="nm_doc_part" name="nm_doc_part" value="<?php echo $nm_doc_part; ?>" required> 
            </div>  

            <div class="form-group">
                <label>Tipe Document</label>
                <select class="form-control selectpicker" name="doc_type" required>
                    <option value="P">Doc for Procurement </option>
                    <option value="V">Doc for Vendor </option>
                </select>
            </div>

            <!--
            <div class="form-group">
                <input type="hidden" class="form-control" id="doc_required" name="doc_required" value="N">
                <input type="checkbox" class="form-control" id="doc_required" name="doc_required" value="Y">
                <label>Required Document</label>
            </div>
            -->

            <div class="form-group">
                <label>Requirement Type</label>
                <select class="form-control selectpicker" id="doc_required" name="doc_required" required>
                    <option value="M" style='color: #00cc00;'>Mandatory </option>
                    <option value="Y">Required </option>
                    <option value="N" style='color: #ff8000;'>Not required</option>
                </select>
            </div>

            <!--
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" id="status_doc" name="status_doc" >
                    <option value="A">Active</option>
                    <option value="N">Not-active</option>
                </select>
            </div>
            -->

    	</div><!-- /.box-body -->

        	<div class="box-footer">
        	    <button type="submit" id="edit-docmaster" name="edit-docmaster" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
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