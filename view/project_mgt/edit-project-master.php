<?php

include "../conn/conn.php";
include "project-mgt-query.php";

?>
           
<div class="box-header">
	<h3 class="box-title">Edit Project Master</h3>
</div>
<hr style="margin-top: 1px;">

<?php

    $id_project = $_GET['id_project'];
    
     $query_exec2 = get_project_data_by_id($id_project);
    
        while ($row2 = mysqli_fetch_assoc($query_exec2)) {

            $proj_num  = $row2['proj_num'];
            $nm_project= $row2['nm_project'];


?>

    <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="project_mgt/act-project-mgt.php" method="post" enctype="multipart/form-data">
        
        <div class="box-body">

            <!--
            <div class="form-group">
               	<label for="exampleInputFile">ID Project</label>
                <input type="text" class="form-control" value="<?php echo $id_project ?>" disabled>
                <input type="hidden" id="id_project" name="id_project" value ="<?php echo  $id_project; ?>">
                <input type="hidden" id="id_user" name="id_user" value ="<?php echo  $_SESSION['id_user']; ?>">
            </div>
            -->

            <?php
            if ($_SESSION['role'] == 'admin'){

                echo '<div class="form-group">
                         <label>ID Project</label>
                         <input type="text" class="form-control" value="'.$id_project.'" disabled>
                      </div>';
            }
            ?>

            <input type="hidden" id="id_project" name="id_project" value ="<?php echo $id_project; ?>">
            <input type="hidden" id="id_user" name="id_user" value ="<?php echo  $_SESSION['id_user']; ?>">

            <div class="form-group">
                <label>Project Number</label>
                <input type="text" class="form-control" name="proj_num" value="<?php echo $proj_num ?>" placeholder="Project Number" required>
            </div>

            <div class="form-group">
                <label>Project Name</label>
                <input type="text" class="form-control" id="nm_project" name="nm_project" value="<?php echo $nm_project; ?>" required> 
            </div>                                                                 

            <!--
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" id="status_project" name="status_project" >
                    <option value="A">Active</option>
                    <option value="N">Not-active</option>
                </select>
            </div>
            -->

            <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>" >                                                                 
    	</div><!-- /.box-body -->

        	<div class="box-footer">
        	    <button type="submit" id="edit-projmaster" name="edit-projmaster" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
        	</div>
    </form>

    <?php

        }
    ?>

<script src="../jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="../js/AdminLTE/app.js" type="text/javascript"></script>


    </body>
</html>