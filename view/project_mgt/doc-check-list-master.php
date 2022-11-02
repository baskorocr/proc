<?php
    include "project-mgt-query.php";
    include "project-mgt-func.php";
    include "../lib/function.php";
?>

<div class="box-header">
    <h3 class="box-title">Document Check List Master</h3>   

    <div class="pull-right box-tools">
        <!-- button with a dropdown -->
        <div class="btn-group">
            <a href="#" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
            <ul class="dropdown-menu pull-right" role="menu">
                <li><a href="home.php?<?php echo token(); ?>mnu=addlistcheckdoc<?php echo token2(); ?>" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                        <i class="fa fa-retweet"></i>Modify Doc Check List</a>
                </li>
                <li><a href="home.php?<?php echo token(); ?>mnu=asslistcheckdoc<?php echo token2(); ?>" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-level-down"></i>Assign Document Check List</a>
                </li>
                <li><a href="home.php?<?php echo token(); ?>mnu=docmaster<?php echo token2(); ?>" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-table"></i>Document Master</a>
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
                <th>ID Document</th>
                <th>Doc Name</th>
                <th>Check Parameters </th>
                <th>Last Change Date</th>
                <th>Last Changed by</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody> 
                                  
           <?php
                //PHP TAG
                
                $no =1;
                $query_exec = get_all_check_doc_data();

                while ($row = mysqli_fetch_assoc($query_exec)) {

                if ( $_SESSION['role']== "admin") {
                    $btn_act = "";
                } else {
                    $btn_act = "disabled";
                }

                /*
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
                */

            ?>
                <tr>
                    <td><?php echo $no++;?></td>
                    <td><?php echo $row['id_doc_part'];?></td>
                    <td><?php echo $row['nm_doc_part'];?></td>
                    <td><?php echo $row['check_params'];?></td>
                    <td><?php echo $row['modify_date'];?></td>
                    <td><?php echo $row['nm_user'];?></td>
                    
                    <td align="center">
                    
                        <a href="home.php?mnu=listcheckedit&id=<?php echo $row['id_check']; ?>" data-toggle='tooltip' title='edit'>   <button class='btn-flat bg-blue'><i class='fa fa-pencil-square-o'></i> Edit</button>
                        </a> 
                    <!--
                        <a href='project_mgt/act-project-mgt.php?act=del&mod=partmaster&id_part=<?php echo $row['id_part']; ?>' data-toggle='tooltip' title='delete' onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">
                            <button class='btn-flat btn-danger' <?php echo $btn_act; ?> ><i class='fa fa-trash-o'></i> Delete</button>
                        </a>

                    </td>
                    -->
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
                <h4 class="modal-title">Add Part</h4>
            </div>
            <div class="modal-body">
                <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
                    
                    <?php 
                        $id_part = autonum( "part", "id_part", 10, 10, 1, "42"); // table, id, lebardata, lebar data yang diambil, start point, awalan
                    ?>

                    <div class="form-group"> <!-- change get updatet user id -->
                        <label>ID User</label>
                        <input type="text" class="form-control" value ="<?php echo $id_part; ?>" disabled="true">
                        <input type="hidden" id="id_part" name="id_part" value ="<?php echo $id_part; ?>">
                    </div>

                    <div class="form-group">
                        <label>Nama Part</label>
                        <input type="text" class="form-control" id="nm_part" name="nm_part" focused required> 
                    </div>   

                    <div class="modal-footer">
                        <button type="submit" name="submit-add" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
                    </div>
        
                </form>
        </div>
      
    </div>
  </div>
  </div>
</div>


<div class="container">
  
  <!-- UPLOAD MODAL -->
  <div class="modal fade" id="assignModal" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
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
</div>

<?php 
    if (isset($_POST['submit-add'])){

        $id_part     = $_POST['id_part'];
        $nm_part     = $_POST['nm_part'];
        $id_user   = $_SESSION['id_user'];
        //$id_user    = "00006";

        insert_part_data($id_part, $nm_part, $id_user);
        echo "<script>window.location=('../view/home.php?mnu=partmaster')</script>";

    } elseif (isset($_POST['submit-assign'])) {

        $id_product     = $_POST['id_product'];
        $id_part     = $_POST['id_part'];

        $id_user    = "00006";

        $count = count($id_part);

        for($i=1; $i <= $count; $i++){

            insert_part_for_product($id_product, $id_part[$i-1], $id_user);
        }

        //insert_part_data($id_part, $nm_part, $id_user);
        echo "<script>window.location=('../view/home.php?mnu=partforprod')</script>";
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