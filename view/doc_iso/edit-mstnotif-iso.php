<?php

//include "../conn/conn.php";
//include "project-mgt-query.php";
include "dociso-query.php";

?>
           
<div class="box-header">
	<h3 class="box-title">Edit Master ISO Notify</h3>
</div>
<hr style="margin-top: 1px;">


    <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="doc_iso/act-dociso.php" method="post" enctype="multipart/form-data">
        
        <div class="box-body">

            <?php

                $notif_id = $_GET['notif_id'];
                $query_exec2 = get_mstnotif_data_by_id($notif_id);

                $row2 = mysqli_fetch_assoc($query_exec2);

                $notif_id 	 	= $row2['notif_id'];
                $notif_before 	= $row2['notif_before'];
                $uom 			= $row2['uom'];

                if ($row2['uom'] == "M"){
                    $uom_selected = "Months";
                } elseif($row2['uom'] == "D"){
                    $uom_selected = "Days";
                } 

            ?>

            <!--
            

            <div class="form-group">
                <label>Notify ID</label>
                <input type="text" class="form-control" name="" value="<?php echo $notif_id; ?>" placeholder="Notify ID" required disabled>
            </div>
            -->
            <input type="hidden" id="notif_id" name="notif_id" value ="<?php echo $notif_id; ?>">
            <div class="form-group">
                <label>Notification Termin</label>
                <select class="form-control" name="" required disabled>
                   <option value='T1'>T1</option>
                   <option value='T2'>T2</option>
                   <option value='T3'>T3</option>
                </select>
            </div>

            <div class="form-group">
                <label>Notify Before Expire Date</label>
                <input type="Number" class="form-control" id="notif_before" name="notif_before" value="<?php echo $notif_before; ?>" required> 
            </div>                                                                 

            <div class="form-group">
                <label>Measurement</label>
                <select class="form-control" name="uom" required>
                    <option value="D" <?php if ($row2['uom'] == "M"){ echo "selected"; }?> >Days</option>
                    <option value="M" <?php if ($row2['uom'] == "M"){ echo "selected"; }?> >Month</option>
                </select>
            </div>
      

            <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>" >                                                                 
    	</div><!-- /.box-body -->

        	<div class="box-footer">
        	    <button type="submit" id="edit-mstnotif" name="edit-mstnotif" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
        	</div>
    </form>


<script src="../jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="../js/AdminLTE/app.js" type="text/javascript"></script>


    </body>
</html>