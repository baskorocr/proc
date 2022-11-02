<?php
    include "project-mgt-query.php";
    include "project-mgt-func.php";
    include "../lib/function.php";
?>

<div class="box-header">
    <h3 class="box-title">Document Master</h3>   

    <div class="pull-right box-tools">
        <!-- button with a dropdown -->
        <div class="btn-group">
            <a href="#" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
            <ul class="dropdown-menu pull-right" role="menu">
            <!--
                <li><a href="home.php?mnu=prodmstrupld"><i class="fa fa-upload"></i>Upload Doc Master</a></li>
            -->
                <li><a href="#addModal" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-plus-square"></i>Create Doc Master</a>
                </li>
                <!--
                <li><a href="#assignModal" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-level-down"></i>Assign Doc For Part</a>
                </li>
                -->
                <li><a href="home.php?mnu=asslistcheckdoc" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-level-down"></i>Assign Document Check List</a>
                </li>
                <!--
                <li><a href="home.php?mnu=docforpart" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-table"></i>Doc for Part Data</a>
                </li>
                -->
                <li><a href="home.php?<?php echo token(); ?>mnu=listcheckmaster<?php echo token2(); ?>"><i class="fa fa-table"></i>Doc List Check Data</a></li>
            </ul>
            </ul>
        </div>
    </div><!-- /. tools -->   
</div><!-- /.box-header -->
<hr style="margin-top: 1px;">

<div class="box-body table-responsive">                        
    <table id="example2" class="table table-bordered table-striped">
    <!-- id="example2" class="table table-bordered table-striped" -->
                                
        <thead>
            <tr>
                <th data-breakpoints="xs">ID Document</th>
                <th>Doc Name</th>
                <th>Doc Type</th>
                <th>Last Change Date</th>
                <th>Last Changed by</th>
                <!--
                <th>Status</th>
                -->
                <th>Check Stat. </th>
                <th>Required</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody> 
                                  
           <?php
                //PHP TAG
                
                $no =1;
                $query_exec = get_all_doc_data();

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

                    if ($row['doc_type'] == "V") {
                        $doc_type = "Doc for Vendor";
                    } elseif($row['doc_type'] == "P"){
                        $doc_type = "Doc for Procurement";
                    }

                    if ($row['doc_required'] == "M") {
                        $doc_required = "<small class='label label-success'> Mandatory</small>" ;
                    } elseif ($row['doc_required'] == "Y")  {
                        $doc_required = "<small class='label label-primary'> Required</small>" ;
                    } elseif ($row['doc_required'] == "N")  {
                        $doc_required = "<small class='label label-warning'> Not-required</small>" ;
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
                    <td><?php echo $row['id_doc_part'];?></td>
                    <td><?php echo $row['nm_doc_part'];?></td>
                    <td><?php echo $doc_type;?></td>
                    <td><?php echo $row['modify_date'];?></td>
                    <td><?php echo $row['nm_user'];?></td>
                    <!--
                    <td><?php echo $status;?></td>
                    -->
                    <td><?php echo $assigned;?></td>
                    <td><?php echo $doc_required; ?></td>
                    <td>
                        <a href="home.php?mnu=docmasteredit&id_doc=<?php echo $row['id_doc_part']; ?>" data-toggle='tooltip' title='edit'>   <button class='btn-flat bg-blue'><i class='fa fa-pencil-square-o'></i> Edit</button>
                        </a> 
                    
                    <?php echo $btn_act1; ?>       
                        <a href='project_mgt/act-project-mgt.php?act=del&mod=docmaster&id_doc=<?php echo $row['id_doc_part']; ?>' data-toggle='tooltip' title='delete' onclick="return confirm('All reference data will be deleted. \n Are you sure to delete this data data ini [<?php echo $row['id_doc_part']; ?>]?')">
                            <button class='btn-flat' style="background-color: #db2b2b; color: #fff;" <?php //echo $btn_act; ?> ><i class='fa fa-trash-o'></i> Del</button>
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
                <h4 class="modal-title">Create Document</h4>
            </div>
            <div class="modal-body">
                <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
                    
                    <!--
                    <div class="col-lg-10">

                    </div>
                    -->
                    <?php 
                        $id_doc = autonum( "doc_part", "id_doc_part", 10, 10, 1, "43"); // table, id, lebardata, lebar data yang diambil, start point, awalan
                    ?>

                    <div class="form-group"> <!-- change get updatet user id -->
                        <label>ID Document</label>
                        <input type="text" class="form-control" value ="<?php echo $id_doc; ?>" disabled="true">
                        <input type="hidden" id="id_doc" name="id_doc" value ="<?php echo $id_doc; ?>">
                    </div>

                    <div class="form-group">
                        <label>Nama Document</label>
                        <input type="text" class="form-control" id="nm_doc" name="nm_doc" placeholder="Document Name" focused required> 
                    </div> 

                    <div class="form-group">
                        <label>Tipe Document</label>
                        <select class="form-control selectpicker" name="doc_type" required>
                            <option value="P">Doc for Procurement </option>
                            <option value="V">Doc for Vendor </option>
                        </select>
                    </div>  

                    <!--
                    <div class="form-group">
                        <input type="checkbox" class="form-control" id="doc_required" name="doc_required" value="Y"> 
                        <label>Required Document</label>
                    </div>
                    -->

                    <div class="form-group">
                        <label>Requirement Type</label>
                        <select class="form-control selectpicker" id="doc_required" name="doc_required" required>
                            <option value="M" style='color: #00cc00;'>Mandatory </option>
                            <option value="Y">Required </option>
                            <option value="N" style='color: #ff8000;'>Not required</option>
                        </select>
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
                            <select multiple class="form-control selectpicker" name="id_doc[]" data-live-search="true" required>
                                <?php
                                    
                                    $query_exec1 = get_all_assigned_doc_data(); //get_doc_type_data("V","Y"); //P = Procurement(internal) V= Vendor

                                    //QIS DRAWING P4 CHECKED BUT DISABLED
                                    while ($row1 = mysqli_fetch_assoc($query_exec1)) {
                                        echo "<option value=".$row1['id_doc_part'].">".$row1['nm_doc_part']."</option>";
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

        $id_doc_part    = $_POST['id_doc'];
        $nm_doc_part    = $_POST['nm_doc'];
        $doc_type       = $_POST['doc_type'];
        $id_user        = $_SESSION['id_user'];

        if ($_POST['doc_required'] == "M"){
            $doc_required   = "M";
        } elseif ($_POST['doc_required'] == "Y") {
            $doc_required   = "Y";
        } elseif ($_POST['doc_required'] == "N") {
            $doc_required   = "N";
        }
       
        //$id_user    = "00006";

        insert_doc_data($id_doc_part, $nm_doc_part, $doc_type, $doc_required, $id_user);
        /*
        echo "<script>window.alert('Success create data');
                    window.location=('../view/home.php?mnu=docmaster');
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
            window.location = (\'../view/home.php?mnu=docmaster\');
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
        

        //insert assign
        
        //update part master assign status
         update_part_assign($id_part, $id_user);
        /*
        echo "<script>window.alert('Success assign');
                window.location=('../view/home.php?mnu=partforprod')
              </script>";
        */

        echo '
        <script>
        swal({
            title: "Success!",
            text: "Success assign Document to Part",
            type: "success",
            customClass: \'swal-wide\',
            allowOutsideClick: false
        })
            .then(function() {
            window.location = (\'../view/home.php?mnu=partforprod\');
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