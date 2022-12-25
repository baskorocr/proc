<?php

//include "../conn/conn.php";
//include "project-mgt-query.php";
include "dociso-query.php";

?>
           
<div class="box-header">
	<h3 class="box-title">Edit Master ISO Certified</h3>
</div>
<hr style="margin-top: 1px;">

    <?php

        $cert_id = $_GET['cert_id'];

        
        $query_exec2 = get_mstcert_data_by_id($cert_id);
    
        $row2 = mysqli_fetch_assoc($query_exec2);

        $cert_id   = $row2['cert_id'];
        $cert_name = $row2['cert_name'];

        
    ?>

    <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="doc_iso/act-dociso.php" method="post" enctype="multipart/form-data">
        
        <div class="box-body">


            <input type="hidden" id="cert_id" name="cert_id" value ="<?php echo $cert_id; ?>">

            <div class="form-group">
                <label>Certified ID</label>
                <input type="text" class="form-control" name="cert_id" value="<?php echo $cert_id; ?>" placeholder="Certified ID" required disabled>
            </div>

            <div class="form-group">
                <label>Certified Name</label>
                <input type="text" class="form-control" id="cert_name" name="cert_name" value="<?php echo $cert_name; ?>" required> 
            </div>                                                                 

            <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>" >                                                                 
    	</div><!-- /.box-body -->

        	<div class="box-footer">
        	    <button type="submit" id="edit-mstcert" name="edit-mstcert" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
        	</div>
    </form>


<script src="../jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="../js/AdminLTE/app.js" type="text/javascript"></script>


    </body>
</html>