<?php
    include "project-mgt-query.php";
    include "project-mgt-func.php";
?>

<div class="box-header">
    <h3 class="box-title">Monitoring Project</h3>   
</div><!-- /.box-header -->

<div class="box-body table-responsive">                        
    <table id="example2" class="table table-bordered table-striped table-hover">                      
        
        <!--
            <tr>
                <th>ID Project</th>
                <th>Project Name</th>
                <th>Assign Proj</th>
                <th>Doc upload</th>
                <th>Doc checked</th>
                <th>Assign Vend</th>
                <th>Vendor Download</th>
                <th>Status</th>
            </tr>
        -->

        <thead>
            <tr>
                <th>ID Project</th>
                <th>Project Name</th>
                <th>Product Name</th>
                <th>Part Name</th>
                <th>Vendor Ass.</th>
                <th>Project Type</th>
            </tr>
        </thead>
        <tbody> 
                                  
           <?php
                //PHP TAG
                
                $no =1;
                $arr_data = array();
                $query_exec = get_proj_vendor_assign_data();
                while ($row = mysqli_fetch_assoc($query_exec)) {
                    $id_project = $row['id_project'];
                    $id_vendor = $row['id_vendor'];

                    $query_exec2 = get_proj_vendor_assign($id_project);

                    $count = mysqli_num_rows($query_exec2);

                    if ($count > 1 ){
                        $project_type = "<h4><label class='label label-primary text-md-center'>Multisourcing (Project)</label></h4>";
                    } else {
                        $project_type= "<h4><label class='label label-success text-md-center'>Single Vendor (Project)</label></h4>";
                    }

                    /*

                        

                    */


            ?>
                <tr>
                    <td><?php echo $row['id_project'];?></td>
                    <td><?php echo $row['nm_project'];?></td>
                    <td><?php echo $row['nm_product'];?></td>
                    <td><?php echo $row['nm_part'];?></td>
                    <td><?php echo $row['nm_vendor'];?></td>
                    <td><?php echo$project_type; ?></small></td>
                </tr>

            <?php

                }   
                
            ?>                               
        </tbody>                       
        
    </table>

</div>

       
<div class="container">
  
  <!-- UPLOAD MODAL -->
  <div class="modal fade" id="addModalx" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create Project</h4>
            </div>
            <div class="modal-body">
                <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">


                     <?php 
                        $id_project = autonum( "project", "id_project", 10, 10, 1, "44"); // table, id, lebardata, lebar data yang diambil, start point, awalan
                    ?>

                    <div class="form-group"> <!-- change get updatet user id -->
                        <label>ID Project</label>
                        <input type="text" class="form-control" value ="<?php echo $id_project; ?>" disabled="true">
                        <input type="hidden" id="id_project" name="id_project" value ="<?php echo $id_project; ?>">
                    </div>

                    <div class="form-group">
                        <label>Nama Project</label>
                        <input type="text" class="form-control" id="nm_project" name="nm_project" placeholder="Project Name">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="submit-add" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
                    </div>
        
                </form>
        </div>
      
    </div>
  </div>
  
</div>

<div class="container">
  
  <!-- UPLOAD MODAL -->
  <div class="modal fade" id="assignDetailModal" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Assign Project to Product</h4>
            </div>
            <div class="modal-body">
                <form role=form name="myForm" id="myForm2" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
                    
                    <!--
                    <div class="col-lg-10">

                    </div>
                    -->
                    <?php 
                        $id_part = $row['id_part']; // table, id, lebardata, lebar data yang diambil, start point, awalan
                    ?>

                     <div class="form-group">
                        <label>Choose Project</label>
                            <select class="form-control selectpicker" name="id_project" data-live-search="true" required>
                                <?php
                                    
                                    $query_exec1 = get_unassigned_project_data();

                                    while ($row1 = mysqli_fetch_assoc($query_exec1)) {
                                        echo "<option value=".$row1['id_project'].">".$row1['nm_project']."</option>";
                                    }
                                    
                                ?>
                            </select>
                    </div>  

                    <div class="form-group">
                        <label>Assign Product</label>
                            <select multiple class="form-control selectpicker" name="id_product[]" data-live-search="true" required>
                                <?php
                                    
                                    $query_exec2 = get_all_assigned_product_data();

                                    while ($row2 = mysqli_fetch_assoc($query_exec2)) {
                                        echo "<option value=".$row2['id_product'].">".$row2['nm_product']."</option>";
                                    }
                                    
                                ?>
                            </select>
                    </div>  

                    <div class="modal-footer">
                        <button type="submit" name="submit-assign" class="btn btn-primary"><i class="fa fa-check"></i> Assign</button>
                    </div>
        
                </form>
        </div>
      
    </div>
  </div>
  
</div>



<?php 
    if (isset($_POST['submit-add'])){

        $id_project     = $_POST['id_project'];
        $nm_project     = $_POST['nm_project'];
        $id_user        = $_SESSION['id_user'];

        insert_project_data($id_project, $nm_project, $id_user);
        echo "<script>window.location=('../view/home.php?mnu=vass')</script>";

    } elseif (isset($_POST['submit-assign'])){
        $id_project     = $_POST['id_project'];
        $id_product     = $_POST['id_product'];
        $id_user        = $_SESSION['id_user'];
  
        $count = count($id_product);
        for($i=1; $i <= $count; $i++){

            insert_product_for_project_data($id_project, $id_product[$i-1], $id_user);
        }
        update_project_assign($id_project, $id_user);
        echo "<script>window.location=('../view/home.php?mnu=projectass')</script>";
    }

?>  
        <!-- jQuery 2.0.2 -->
        <script src="../jquery/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="../js/AdminLTE/app.js" type="text/javascript"></script>

        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": true,
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
        </script>

    </body>
</html>