<?php

//include "../conn/conn.php";
include "project-mgt-query.php";

?>
           
<div class="box-header">
	<h3 class="box-title">Edit Product Master</h3>
</div>
<hr style="margin-top: 1px;">

<?php

    $id_product = $_GET['id_prod'];
    
     $query_exec2 = get_prod_data_by_id($id_product);
    
        while ($row2 = mysqli_fetch_assoc($query_exec2)) {

            $prod_num  = $row2['prod_num'];
            $nm_product= $row2['nm_product'];

?>

    <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="project_mgt/act-project-mgt.php" method="post" enctype="multipart/form-data">
        
        <div class="box-body">
            <!--
            <div class="form-group">
               	<label for="exampleInputFile">ID PRODUCT</label>
                <input type="text" class="form-control" value="<?php echo $id_product ?>" disabled>
                <input type="hidden" id="id_product" name="id_product" value ="<?php echo  $id_product; ?>">
                <input type="hidden" id="id_user" name="id_user" value ="<?php echo  $_SESSION['id_user']; ?>">
            </div>
            -->

            <?php
            if ($_SESSION['role'] == 'admin'){

                echo '<div class="form-group">
                         <label>ID Product</label>
                         <input type="text" class="form-control" value="'.$id_product.'" disabled>
                      </div>';
            }
            ?>

            <input type="hidden" id="id_product" name="id_product" value ="<?php echo  $id_product; ?>">
            <input type="hidden" id="id_user" name="id_user" value ="<?php echo  $_SESSION['id_user']; ?>">

            <div class="form-group">
                <label>Product Number</label>
                <input type="text" class="form-control" name="prod_num" value="<?php echo $prod_num ?>" placeholder="Product Number" required>
            </div>

            <div class="form-group">
                <label>Product Name</label>
                <input type="text" class="form-control" id="nm_product" name="nm_product" value="<?php echo $nm_product; ?>" required> 
            </div>                                                                 

            <!--
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" id="status_product" name="status_product" >
                    <option value="A">Active</option>
                    <option value="N">Not-active</option>
                </select>
            </div>
            -->
    
    	</div><!-- /.box-body -->

        	<div class="box-footer">
        	    <button type="submit" id="edit-prodmaster" name="edit-prodmaster" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
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