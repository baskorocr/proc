<?php
    include "data-model/my-query.php";
?>

<div class="box-header">
    <h3 class="box-title">Assignment >> Create Project</h3>   
</div><!-- /.box-header -->


<form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="home.php?mnu=crproj" method="post" enctype="multipart/form-data">

    <div class="box-body">
        <div class="form-group">
            <label>Nama Project</label>
            <input type="text" class="form-control" id="project_nm" name="project_nm" placeholder="Project Name">
        </div>
        
        <!-- select -->
        <div class="form-group">
            <label>Status Project</label>
            <select class="form-control" name="project_stat">
                <option>NEW PROJECT</option>
                <option>MASS PRO</option>
                <option>MULTI SOURCING</option>
            </select>
        </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Confirm</button>
    </div>
        
</form>
                        

        
        <!-- jQuery 2.0.2 -->
        <script src="../jquery/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="../js/AdminLTE/app.js" type="text/javascript"></script>

    </body>
</html>