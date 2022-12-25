<?php
    //include "data-model/query.php";
    include "project-mgt-query.php";
    include "project-mgt-func.php";
    //include "lib/function.php";
?>

<div class="box-header">
    <h3 class="box-title">Product Master</h3>   

    <div class="pull-right box-tools">
        <!-- button with a dropdown -->
        <div class="btn-group">
            <a href="#" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
            <ul class="dropdown-menu pull-right" role="menu">
                <!--
                <li><a href="home.php?mnu=prodmstrupld"><i class="fa fa-upload"></i>Upload Product</a></li>
                -->
                <li><a href="#addModal" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-plus-square"></i>Create Product</a>
                </li>
                <li><a href="#assignModal" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-level-down"></i>Assign Part for Product</a>
                </li>
                <li><a href="home.php?<?php echo token(); ?>mnu=partforprod<?php echo token2(); ?>" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-table"></i>Part for Product Data</a>
                </li>
            </ul>
        </div>
    </div><!-- /. tools -->   
<?php //echo $_SESSION['id_user'];?>
</div><!-- /.box-header -->
<hr style="margin-top: 1px;">

<div class="box-body table-responsive">                        
    <table id="example2" class="table table-bordered table-striped">                      
                                
        <thead>
            <tr>
                <th>#</th>
                <!--
                <th>ID Product</th>
                -->
                <th>Product Number</th>
                <th>Product Name</th>
                <th>Last Change Date</th>
                <th>Last Change By</th>
                <!--
                <th>Status</th>
                -->
                <th>Part Ass.</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody> 

            <?php

                $no =1;
                $query_exec = get_all_prod_data();

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
                    <td><?php echo $row['prod_num'];?></td>
                    <td><?php echo $row['nm_product'];?></td>
                    <td><?php echo $row['modify_date'];?></td>
                    <td><?php echo $row['nm_user'];?></td>
                    <!--
                    <td><?php echo $status;?></td>
                    -->
                    <td><?php echo $assigned;?></td>
                    <td align="center">
                        <a href="home.php?mnu=prodmasteredit&id_prod=<?php echo $row['id_product']; ?>" data-toggle='tooltip' title='edit'>   <button class='btn-flat bg-blue'><i class='fa fa-pencil-square-o'></i> Edit</button>
                        </a> 

                    <?php echo $btn_act1; ?>     
                        <a href='project_mgt/act-project-mgt.php?act=del&mod=prodmaster&id_product=<?php echo $row['id_product']; ?>' data-toggle='tooltip' title='delete' onclick="return confirm('All reference data will be deleted. \n Are sure want to delete this data [<?php echo $row['id_product']; ?>]?')">
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
  
  <!-- ADD MODAL -->
  <div class="modal fade" id="addModal" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create Product</h4>
            </div>
            <div class="modal-body">
                <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
                    
                    <!--
                    <div class="col-lg-10">

                    </div>
                    -->
                    <?php 
                        $id_product = autonum( "product", "id_product", 10, 10, 1, "41"); // table, id, lebardata, lebar data yang diambil, start point, awalan
                    ?>

                    <!--
                    <div class="form-group">
                        <label>ID Product</label>
                        <input type="text" class="form-control" value ="<?php echo $id_product; ?>" disabled="true">
                        <input type="hidden" id="id_product" name="id_product" value ="<?php echo $id_product; ?>">
                    </div>
                    -->

                    <?php
                    if ($_SESSION['role'] == 'admin'){

                        echo '<div class="form-group">
                                        <label>ID Product</label>
                                        <input type="text" class="form-control" value ='.$id_product.' disabled="true">
                                  </div>';
                    }
                    ?>

                    <input type="hidden" id="id_product" name="id_product" value ="<?php echo $id_product; ?>">

                    <div class="form-group">
                        <label>Product Number</label>
                        <input type="text" class="form-control" name="prod_num" placeholder="Product Number" required>
                    </div>

                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" class="form-control" id="nm_product" name="nm_product" placeholder="Product Name" focused required> 
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

        $id_product  = $_POST['id_product'];
        $prod_num    = $_POST['prod_num'];
        $nm_product  = $_POST['nm_product'];
        $id_user     = $_SESSION['id_user'];
        //$id_user    = "00005";

        insert_prod_data($id_product, $prod_num, $nm_product, $id_user);
        /*
        echo "<script>window.alert('Success create data');
                window.location=('../view/home.php?mnu=prodmaster')
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
            window.location = (\'../view/home.php?mnu=prodmaster\');
        });
        
        </script>
        ';

    } elseif (isset($_POST['submit-assign'])) {

        $id_product     = $_POST['id_product'];
        $id_part        = $_POST['id_part'];
        $id_user        = $_SESSION['id_user'];
       
        $count = count($id_part);

        for($i=1; $i <= $count; $i++){

            insert_part_for_product($id_product, $id_part[$i-1], $id_user);
        }

        update_product_assign($id_product, $id_user);
        /*
        echo "<script>window.alert('Success assign part to product');
                window.location=('../view/home.php?mnu=prodmaster')
              </script>";
        */

        echo '
        <script>
        swal({
            title: "Success!",
            text: "Success assign part to product",
            type: "success",
            customClass: \'swal-wide\',
            allowOutsideClick: false
        })
            .then(function() {
            window.location = (\'../view/home.php?mnu=prodmaster\');
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