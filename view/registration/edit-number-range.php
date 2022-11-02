<?php

//include "../conn/connection.php";
include "master-data-query.php";

?>
           
<div class="box-header">
	<h3 class="box-title">Edit Email Group</h3>
</div>
<hr style="margin-top: 1px;">

<?php

    $doc_type  = $_GET['doc_type'];
    $doc_year = $_GET['doc_year'];
    $id_user = $_SESSION['id_user'];
    
    $query_exec2 =get_all_number_range_by_doc_year($doc_type, $doc_year);
    
    $row = mysqli_fetch_assoc($query_exec2);
       
    $num_low = $row['num_low'];
    $num_high = $row['num_high'];

?>
    <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
        
        <div class="box-body">    

            <input type="hidden" id="id_user" name="id_user" value ="<?php echo $id_user; ?>">
            <input type="hidden" id="old_doctype" name="old_doctype" value ="<?php echo $doc_type; ?>">
            <input type="hidden" id="old_docyear" name="old_docyear" value ="<?php echo $doc_year; ?>">
            
            <div class="form-group">
                <label>Document Type</label>
                <select class="form-control selectpicker" name="doc_type" data-live-search="true" focused required>
                    <option value="iso">iso</option>
                </select>
            </div>

            <div class="form-group">
                <label>Document Year</label>
                <input type="number" class="form-control" id="doc_year" name="doc_year" placeholder="ex. 2022" maxlength="4" focused required> 
            </div>

            <div class="form-group">
                <label>Low Number</label>
                <input type="number" class="form-control" id="num_low" name="num_low" placeholder="ex. 00000" maxlength="5" focused required> 
            </div>

            <div class="form-group">
                <label>High Number</label>
                <input type="number" class="form-control" id="num_high" name="num_high" placeholder="ex. 99999" maxlength="5" focused required> 
            </div>  
    
    	</div><!-- /.box-body -->

        	<div class="box-footer">
        	    <button type="submit" id="edit-email-list-group" name="edit-email-list-group" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
        	</div>
    </form>

    <?php

        if(isset($_POST['edit-email-list-group'])){

            $id_user    = $_POST['id_user'];
            $doc_type   = $_POST['doc_type'];
            $doc_year   = $_POST['doc_year'];
            $num_low    = $_POST['num_low'];
            $num_high   = $_POST['num_high'];

            $old_doctype  = $_POST['old_doctype'];
            $old_docyear  = $_POST['old_docyear'];
        
            if(update_number_range($old_doctype, $old_docyear, $doc_type, $doc_year, $num_low, $num_high, $id_user)) {

                echo '
                <script>
                swal({
                    title: "Success!",
                    text: "Data has been updated!",
                    type: "success",
                    customClass: \'swal-wide\',
                    allowOutsideClick: false
                })
                    .then(function() {
                    window.location = (\'../view/home.php?mnu=numrange\');
                });

                </script>
                ';
            }
            else
            {
                    echo '
                    <script>
                    swal({
                        title: "Warning!",
                        text: "No Update performed!",
                        type: "warning",
                        customClass: \'swal-wide\',
                        allowOutsideClick: false
                    })
                        .then(function() {
                        window.location = (\'../view/home.php?mnu=numrange\');
                    });
                    </script>
                    ';
            
            }
        }

    ?>

<script src="../jquery-2/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="../js/AdminLTE/app.js" type="text/javascript"></script>

<!-- DATA TABLES SCRIPT -->
<script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>


    </body>
</html>