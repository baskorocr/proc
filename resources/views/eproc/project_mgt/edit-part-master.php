<?php

//include "../conn/conn.php";
include "project-mgt-query.php";

?>
           
<div class="box-header">
	<h3 class="box-title">Edit Part Master</h3>
</div>
<hr style="margin-top: 1px;">

<?php

    $id_part = $_GET['id_part'];
    
     $query_exec2 = get_part_data_by_id($id_part);
    
        while ($row2 = mysqli_fetch_assoc($query_exec2)) {

            $part_num  = $row2['part_num'];
            $nm_part= $row2['nm_part'];

?>

    <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="project_mgt/act-project-mgt.php" method="post" enctype="multipart/form-data">
        
        <div class="box-body">
            <!--
            <div class="form-group">
               	<label for="exampleInputFile">ID Part</label>
                <input type="text" class="form-control" value="<?php echo $id_part ?>" disabled>
                <input type="hidden" id="id_part" name="id_part" value ="<?php echo  $id_part; ?>">
                <input type="hidden" id="id_user" name="id_user" value ="<?php echo  $_SESSION['id_user']; ?>">
            </div>
            -->

            <?php
            if ($_SESSION['role'] == 'admin'){

                echo '<div class="form-group">
                         <label>ID Part</label>
                         <input type="text" class="form-control" value="'.$id_part.'" disabled>
                      </div>';
            }
            ?>

            <input type="hidden" id="id_part" name="id_part" value ="<?php echo  $id_part; ?>">
            <input type="hidden" id="id_user" name="id_user" value ="<?php echo  $_SESSION['id_user']; ?>">

            <div class="form-group">
                <label>Part Number</label>
                <input type="text" class="form-control" name="part_num" value="<?php echo $part_num ?>" placeholder="Part Number" required>
            </div>

            <div class="form-group">
                <label>Part Name</label>
                <input type="text" class="form-control" id="nm_part" name="nm_part" value="<?php echo $nm_part; ?>" required> 
            </div>     

            <!--                                                            
            
            <div class="form-group">
                <label>Assign Product</label>
                    <select class="form-control selectpicker" name="id_product" data-live-search="true" required>
                        <?php
                                    
                            $query_exec = get_all_prod_data();

                            while ($row2 = mysqli_fetch_assoc($query_exec)) {
                                echo "<option value=".$row2['id_product'].">".$row2['nm_product']."</option>";
                            }
                                    
                        ?>
                    </select>
            </div>

            -->  

            <!--
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" id="status_part" name="status_part" >
                    <option value="A">Active</option>
                    <option value="N">Not-active</option>
                </select>
            </div>
            -->

    	</div><!-- /.box-body -->

        	<div class="box-footer">
        	    <button type="submit" id="edit-partmaster" name="edit-partmaster" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
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