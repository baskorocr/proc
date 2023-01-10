<?php
    include "project-mgt-query.php";
    include "project-mgt-func.php";
    //include "../lib/function.php";
?>

<div class="box-header">
    <h3 class="box-title">Part Master</h3>   

    <div class="pull-right box-tools">
        <!-- button with a dropdown -->
        <div class="btn-group">
            <a href="#" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
            <ul class="dropdown-menu pull-right" role="menu">
                <!--
                <li><a href="home.php?mnu=prodmstrupld"><i class="fa fa-upload"></i>Upload Part</a></li>
                -->
                <li><a href="#addModal" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-plus-square"></i>Create Part</a>
                </li>
                <li><a href="#assignModal" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-level-down"></i>Assign Doc For Part</a>
                </li>
                <!--
                <li><a href="#assignModal" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-level-down"></i>Assign Part for Product</a>
                </li>
                -->
                <li><a href="home.php?<?php echo token(); ?>mnu=docforpart<?php echo token2(); ?>" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-table"></i>Doc for Part Data</a>
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
                <!--
                <th>ID Part</th>
                -->
                <th>Part Number</th>
                <th>Part Name</th>
                <th>Last Change Date</th>
                <th>Last Changed by</th>
                <!--
                <th>Status</th>
                -->
                <th>Doc Ass.</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody> 
                                  
           <?php
                //PHP TAG
                
                $no =1;
                $query_exec = get_all_part_data();

                while ($row = mysqli_fetch_assoc($query_exec)) {

                if ( $_SESSION['role']== "admin") {
                        //$btn_act = "";
                        $btn_act1 = "";
                        $btn_act2 = "";
                    } else {
                        //$btn_act = "disabled";
                        $btn_act1 = "<!--";
                        $btn_act2 = "-->";
                    }

                if ($row['status'] == "A"){
                        $status = "<small class='label label-success'> Active</small>";
                    }elseif ($row['status'] == "N") {
                        $status = "<small class='label label-danger'> Nonactive</small>";
                    }

                if ($row['assigned'] == 'Y'){
                        $assigned = "<small class='label label-success'> Assigned</small>";
                    }elseif ($row['assigned'] == 'N') {
                        $assigned = "<small class='label label-warning'> Not-Assigned</small>";
                    }

            ?>
                <tr>
                    <td><?php echo $no++;?></td>
                    <td><?php echo $row['part_num'];?></td>
                    <td><?php echo $row['nm_part'];?></td>
                    <td><?php echo new_format_date('d.m.Y', $row['modify_date']);?></td>
                    <td><?php echo $row['nm_user'];?></td>
                    <!--
                    <td><?php echo $status;?></td>
                    -->
                    <td><?php echo $assigned;?></td>
                    <td align="center">
                        <a href="home.php?mnu=partmasteredit&id_part=<?php echo $row['id_part']; ?>" data-toggle='tooltip' title='edit'>   <button class='btn-flat bg-blue'><i class='fa fa-pencil-square-o'></i> Edit</button>
                        </a> 
                    <?php echo $btn_act1; ?>         
                        <a href='project_mgt/act-project-mgt.php?act=del&mod=partmaster&id_part=<?php echo $row['id_part']; ?>' data-toggle='tooltip' title='delete' onclick="return confirm('Semua data yang terhubung akan dihapus. \n Apakah anda yakin akan menghapus data ini [<?php echo $row['id_part']; ?>]?')">
                            <button class='btn-flat' style="background-color: #db2b2b; color: #fff; " <?php //echo $btn_act; ?> ><i class='fa fa-trash-o'></i> Delete</button>
                        </a>
                    <?php echo $btn_act2; ?>      
                    </td>
                </tr>

            <?php

                }   
                
            ?>                               
        </tbody>
    </table>
</div><!-- /.box-body -->
                        
<div class="container">
  
  <!-- UPLOAD MODAL -->
  <div class="modal fade" id="addModal" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create Part</h4>
            </div>
            <div class="modal-body">
                <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
                    
                    <?php 
                        $id_part = autonum( "part", "id_part", 10, 10, 1, "42"); // table, id, lebardata, lebar data yang diambil, start point, awalan
                    ?>

                    <!--
                    <div class="form-group">
                        <label>ID User</label>
                        <input type="text" class="form-control" value ="<?php echo $id_part; ?>" disabled="true">
                        <input type="hidden" id="id_part" name="id_part" value ="<?php echo $id_part; ?>">
                    </div>
                    -->

                    <?php
                    if ($_SESSION['role'] == 'admin'){

                        echo '<div class="form-group">
                                        <label>ID Part</label>
                                        <input type="text" class="form-control" value ='.$id_part.' disabled="true">
                                  </div>';
                    }
                    ?>

                    <input type="hidden" id="id_part" name="id_part" value ="<?php echo $id_part; ?>">

                    <div class="form-group">
                        <label>Part Number</label>
                        <input type="text" class="form-control" name="part_num" placeholder="Part Number" required>
                    </div>

                    <div class="form-group">
                        <label>Part Name</label>
                        <input type="text" class="form-control" id="nm_part" name="nm_part" placeholder="Part Name" focused required> 
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



<!--
<div class="container">
  

  <div class="modal fade" id="assignModal2" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Assign Part for Product</h4>
            </div>
            <div class="modal-body">
                <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
                    
                    <?php 
                        $id_part = $row['id_part']; // table, id, lebardata, lebar data yang diambil, start point, awalan
                    ?>

                     <div class="form-group">
                        <label>Choose Product</label>
                            <select class="form-control selectpicker" name="id_product" data-live-search="true" required>
                                <?php
                                    
                                    $query_exec = get_unassigned_prod_data();

                                    while ($row2 = mysqli_fetch_assoc($query_exec)) {
                                        echo "<option value=".$row2['id_product'].">".$row2['nm_product']."</option>";
                                    }
                                    
                                ?>
                            </select>
                    </div>  

                    <div class="form-group">
                        <label>Assign Part</label>
                            <select multiple class="form-control selectpicker" name="id_part[]" data-live-search="true" required>
                                <?php
                                    
                                    $query_exec = get_all_assgined_part_data();

                                    while ($row1 = mysqli_fetch_assoc($query_exec)) {
                                        echo "<option value=".$row1['id_part'].">".$row1['nm_part']."</option>";
                                    }
                                    
                                ?>
                            </select>
                    </div>  

                    <div class="modal-footer">
                        <button type="submit" name="submit-assign" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
                    </div>
        
                </form>
        </div>
      
    </div>
  </div>
  
</div>
-->

<div class="container">
  
  <!-- UPLOAD MODAL -->
  <div class="modal fade" id="assignModal" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Assign Document for Part</h4>
            </div>
            <div class="modal-body">
                <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
                    
                    <div class="form-group">
                        <label>Choose Part</label>
                            <select class="form-control selectpicker" name="id_part" data-live-search="true" required>
                                <?php
                                    
                                    //$query_exec2 = get_all_check_doc_data();
                                    $query_exec2 = get_unassigned_part_data();

                                    while ($row2 = mysqli_fetch_assoc($query_exec2)) {
                                        echo "<option value=".$row2['id_part'].">".$row2['nm_part']."</option>";
                                    }
                                    
                                ?>
                            </select>
                    </div>  
                    

                    <div class="form-group">
                        <label>Assign Document</label>
                            <select multiple class="form-control selectpicker" name="id_doc[]" data-live-search="true" data-selected-text-format="count>4" required>
                                <?php
                                    
                                    $query_exec1 = get_all_assigned_doc_data(); //get_doc_type_data("V","Y"); //P = Procurement(internal) V= Vendor

                                    //QIS DRAWING P4 CHECKED BUT DISABLED
                                    while ($row1 = mysqli_fetch_assoc($query_exec1)) {
                                        $tp = $row1['doc_type'];
                                        $rq = $row1['doc_required'];

                                        if ($rq == "M") {
                                            $req = "Mandatory style='color: #00cc00;'";
                                        } elseif ($rq == "Y"){
                                            $req = "Required";
                                        } elseif ($rq == "N"){
                                            $req = "Not-required style='color: #ff8000;'";
                                        }

                                        echo "<option data-subtext=".$tp."-".$req." required value=".$row1['id_doc_part'].">".$row1['nm_doc_part']."</option>";
                                 
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

        $id_part     = $_POST['id_part'];
        $part_num    = $_POST['part_num'];
        $nm_part     = $_POST['nm_part'];
        $id_user   = $_SESSION['id_user'];

        insert_part_data($id_part, $part_num, $nm_part, $id_user);
        /*
        echo "<script>window.alert('Success create data');
               window.location=('../view/home.php?mnu=partmaster')
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
            window.location = (\'../view/home.php?mnu=partmaster\');
        });
        
        </script>
        ';

    } elseif (isset($_POST['submit-assign'])) {

        $id_part     = $_POST['id_part'];
        $id_doc_part = $_POST['id_doc'];
        $id_user     = $_SESSION['id_user'];

        $count = count($id_doc_part);

        for($i=1; $i <= $count; $i++){

            insert_doc_for_part($id_part, $id_doc_part[$i-1], $id_user);
        }

        update_part_assign($id_part, $id_user);
        /*
        echo "<script>window.alert('Success assign document to part');
                window.location=('../view/home.php?mnu=partmaster')
             </script>";
        */

        echo '
        <script>
        swal({
            title: "Success!",
            text: "Success assign document to part",
            type: "success",
            customClass: \'swal-wide\',
            allowOutsideClick: false
        })
            .then(function() {
            window.location = (\'../view/home.php?mnu=partmaster\');
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
<!--
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
        -->

        <script type="text/javascript">
            $(function() {
                $('#example2').DataTable({
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