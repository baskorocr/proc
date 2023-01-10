<?php

//include "../conn/connection.php";
include "master-data-query.php";

?>
           
<div class="box-header">
	<h3 class="box-title">Edit Vendor Master Data</h3>
</div>
<hr style="margin-top: 1px;">

<?php

    $id_vendor = $_GET['id_vendor'];
    
     $query_exec2 = get_vendor_data_by_id($id_vendor);
    
        while ($row2 = mysqli_fetch_assoc($query_exec2)) {
           
        $nm_vendor      = $row2['nm_vendor'];
        $allias         = $row2['allias'];
        $street         = $row2['street'];
        $status_vendor  = $row2['status_vendor'];
        //$id_user        = $row2['id_user'];
        //$id_user = '';

?>
    <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="registration/act-master-data.php" method="post" enctype="multipart/form-data">
        
        <div class="box-body">                            
            <div class="form-group">
               	<label for="exampleInputFile">ID Vendor</label>
                <input type="text" class="form-control" value="<?php echo $id_vendor ?>" disabled>
                <input type="hidden" id="id_vendor" name="id_vendor" value ="<?php echo  $id_vendor; ?>">
            </div>

            <div class="form-group">
                <label>Nama Vendor</label>
                <input type="text" class="form-control" id="nm_vendor" name="nm_vendor" value ="<?php echo  $nm_vendor; ?>" focused required> 
            </div>

            <div class="form-group">
                <label>Allias</label>
                <input type="text" class="form-control" id="allias" name="allias" value ="<?php echo  $allias; ?>" required> 
            </div>

            <div class="form-group">
                <label>Street</label>
                <input type="text" class="form-control" id="street" name="street" value ="<?php echo  $street; ?>" required> 
            </div>                                                              
                
            <!-- SELECT OPTION ACTIVE IF IT USER LOGIN-->
            <?php
                if ($_SESSION['role']=='admin'){
                    $list = "";
                } else {
                     $list = "disabled='false'";
                }
            ?>

            <div class="form-group">
                <label>Status Vendor</label>
                <select class="form-control" id="status_vendor" name="status_vendor" <?php echo $list; ?> >
                    <option value="A">Active</option>
                    <option value="N">Not-active</option>
                </select>
            </div>  

            <!--
            <div class="form-group">
                <label>ID User</label>
                <input type="text" class="form-control" value="<?php echo $id_user; ?>" disabled>
                <input type="hidden" id="id_user" name="id_user" value ="<?php echo $id_user; ?>">
            </div>       
            -->                                                             
    
    	</div><!-- /.box-body -->

        	<div class="box-footer">
        	    <button type="submit" id="edit-vmaster" name="edit-vmaster" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
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