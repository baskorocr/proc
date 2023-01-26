<?php
    include "project-mgt-query.php";
    include "project-mgt-func.php";
    //include "../lib/function.php";
?>

<div class="box-header">
    <h3 class="box-title">Project Master</h3>   

    <div class="pull-right box-tools">
        <!-- button with a dropdown -->
        <div class="btn-group">
            <a href="#" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
            <ul class="dropdown-menu pull-right" role="menu">
                <li><a href="#addModalx" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-plus-square"></i>Create Project</a>
                </li>
                <li><a href="#assignDetailModal" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-level-down"></i>Assign Project Details</a>
                </li>
                <li><a href="home.php?<?php echo token(); ?>mnu=projectass<?php echo token2(); ?>" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-table"></i>Project Assignment Data</a>
                </li>
            </ul>
        </div>
    </div><!-- /. tools -->

</div><!-- /.box-header -->

<hr style="margin-top: 1px;">

<div class="box-body table-responsive">                        
    <table id="example2" class="table table-bordered table-striped">                      
        
        <thead>
            <tr>
                <th>#</th>
                <th>Project Number</th>
                <th>Project Name</th>
                <th>Last Change Date</th>
                <th>Last Changed by</th>
                <!--
                <th>Status</th>
                -->
                <th>Product Ass. </th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody> 
                                  
           <?php
                //PHP TAG
                
                $no =1;
                $query_exec = get_all_project_data();

                while ($row = mysqli_fetch_assoc($query_exec)) {
					
                    if ($row['assigned'] == 'Y'){
                        $assigned = "<small class='label label-success'> Assigned</small>";
                    }elseif ($row['assigned'] == 'N') {
                        $assigned = "<small class='label label-warning'> Not-Assigned</small>";
                    }

                    if ($row['status'] == "A"){
                        $status = "<small class='label label-success'> Active</small>";
                    }elseif ($row['status'] == "N") {
                        $status = "<small class='label label-danger'> Nonactive</small>";
                    }

                    if ( $_SESSION['role']== "admin") {
                        //$btn_act = "";
                        $btn_act1 = "";
                        $btn_act2 = "";
                    } else {
                        //$btn_act = "disabled";
                        $btn_act1 = "<!--";
                        $btn_act2 = "-->";
                    }

            ?>
                <tr>
                    <td><?php echo $no++;?></td>
                    <td><?php echo $row['proj_num'];?></td>
                    <td><?php echo $row['nm_project'];?></td>
                    <td><?php echo $row['modify_date'];?></td>
                    <td><?php echo $row['nm_user'];?></td>
                    <!--
                    <td><?php echo $status;?></td>
                    -->
                    <td><?php echo $assigned;?></td>
                    <td align="center">
                        <a href="home.php?mnu=projectmasteredit&id_project=<?php echo $row['id_project']; ?>" data-toggle='tooltip' title='edit'>
                            <button class='btn-flat bg-blue'><i class='fa fa-pencil-square-o'></i> Edit</button>
                        </a> 
                     <?php echo $btn_act1; ?>      
                        <a href='project_mgt/act-project-mgt.php?act=del&mod=projmaster&id_project=<?php echo $row['id_project']; ?>' data-toggle='tooltip' title='delete' onclick="return confirm('All reference data will be deleted. \n Are you sure want to delete this data [<?php echo $row['id_project']; ?>]?')">
                            <button class='btn-flat' style="background-color: #db2b2b; color: #fff; "><i class='fa fa-trash-o'></i> Delete</button>
                        </a>
                     <?php echo $btn_act2; ?> 
                    </td>
                </tr>

            <?php

                }   
                
            ?>                               
        </tbody>                       
        
    </table>

</div>

       
<div class="container">
  
  <!-- UPLOAD MODAL -->
  <div class="modal fade" id="create-project" role="dialog">
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

                    <!--
                    <label>ID Project</label>
                    <input type="text" class="form-control" value ="<?php echo $id_project; ?>" disabled="true">
                    <input type="hidden" id="id_project" name="id_project" value ="<?php echo $id_project; ?>">
                    -->
                    <?php
                        if ($_SESSION['role'] == 'admin'){

                            echo '<div class="form-group">
                                        <label>ID Project</label>
                                        <input type="text" class="form-control" value ='.$id_project.' disabled="true">
                                  </div>';
                        }
                    ?>

                    <input type="hidden" id="id_project" name="id_project" value ="<?php echo $id_project; ?>">

                    <div class="form-group">
                        <label>Project Number</label>
                        <input type="text" class="form-control" name="proj_num" placeholder="Project Number" required>
                    </div>

                    <div class="form-group">
                        <label>Nama Project</label>
                        <input type="text" class="form-control" id="nm_project" name="nm_project" placeholder="Project Name" required>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="submit-add" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Create</button>
                    </div>
        
                </form>
        </div>
      
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
                                        echo "<option value=".$row1['id_project'].">".$row1['proj_num']." - ".$row1['nm_project']."</option>";
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
                        <button type="submit" name="submit-assign" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Assign</button>
                    </div>
        
                </form>
        </div>
      
    </div>
  </div>
  
</div>
</div>



<?php 
    if (isset($_POST['submit-add'])){

        $id_project     = $_POST['id_project'];
        $proj_num       = $_POST['proj_num'];
        $nm_project     = $_POST['nm_project'];
        $id_user        = $_SESSION['id_user'];

        insert_project_data($id_project, $proj_num, $nm_project, $id_user);
        /*
        echo "<script>window.alert('Success create data');
                window.location=('../view/home.php?mnu=projmaster');
             </script>";
        */
        echo '
        <script>
        swal({
            title: "Success!",
            text: "Success create data",
            type: "success",
            customClass: \'swal-wide\',
            allowOutsideClick: false
        })
            .then(function() {
            window.location = (\'../view/home.php?mnu=projmaster\');
        });
        
        </script>
        ';

    } elseif (isset($_POST['submit-assign'])){
        $id_project     = $_POST['id_project'];
        $id_product     = $_POST['id_product'];
        $id_user        = $_SESSION['id_user'];
  
        $count = count($id_product);
        for($i=1; $i <= $count; $i++){

            insert_product_for_project_data($id_project, $id_product[$i-1], $id_user);
        }
        update_project_assign($id_project, $id_user);
        /*
        echo "<script>window.alert('Success assign product to project');
                window.location=('../view/home.php?mnu=projmaster')
             </script>";
        */
        echo '
        <script>
        swal({
            title: "Success!",
            text: "Success assign product to project",
            type: "success",
            customClass: \'swal-wide\',
            allowOutsideClick: false
        })
            .then(function() {
            window.location = (\'../view/home.php?mnu=projmaster\');
        });
        
        </script>
        ';
    }

?>  
        <!-- jQuery 2.0.2 -->
        <script src="../jquery-2/jquery.min.js"></script>
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
                    "bLengthChange": false,
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
        </script>

    </body>
</html>