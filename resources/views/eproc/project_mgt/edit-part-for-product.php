<?php

include "../conn/conn.php";
include "project-mgt-query.php";

?>
           
<div class="box-header">
	<h3 class="box-title">Edit Part Master</h3>
</div>

<?php

    $id_assign = $_GET['id'];
    
     $query_exec2 = get_part_data_by_id($id_part);
    
        while ($row2 = mysqli_fetch_assoc($query_exec2)) {

          $nm_part= $row2['nm_part'];

?>

    <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="project_mgt/act-project-mgt.php" method="post" enctype="multipart/form-data">
        
        <div class="box-body">                            
            <div class="form-group">
               	<label for="exampleInputFile">ID Part</label>
                <input type="text" class="form-control" value="<?php echo $id_part ?>" disabled>
                <input type="hidden" id="id_part" name="id_part" value ="<?php echo  $id_part; ?>">
            </div>

            <div class="form-group">
                <label>Nama Part</label>
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

            <div class="form-group">
                <label>Status</label>
                <select class="form-control" id="status_part" name="status_part" >
                    <option value="A">Active</option>
                    <option value="N">Not-active</option>
                </select>
            </div>                                                                       
    
    	</div><!-- /.box-body -->

        	<div class="box-footer">
        	    <button type="submit" id="edit-partforprod" name="edit-partforprod" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit</button>
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