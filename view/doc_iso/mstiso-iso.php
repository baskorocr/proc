<?php
    include "conn/conn_proc.php";
    include "dociso-query.php";
?>

<div class="box-header">
    <h3 class="box-title">Master ISO Type (Not Used)</h3>   

    <div class="pull-right box-tools">
        <!-- button with a dropdown -->
        <div class="btn-group">
            <a href="#" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
            <ul class="dropdown-menu pull-right" role="menu">
                <li><a href="#addModalx" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-plus-square"></i>Create ISO Type</a>
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
                <th>ISO Type ID</th>
                <th>ISO Type Name</th>
                <th>Last Change Date</th>
                <th>Last Changed by</th>
                <!--
                <th>Status</th>
                -->
                <th>Action</th>
            </tr>
        </thead>
        <tbody> 
                
            <?php 

            $no =1;
            $query_exec = get_all_mstiso_data();

            while ($row = mysqli_fetch_assoc($query_exec)) {

            ?>
           
                <tr>
                    <td><?php echo $no++;?></td>
                    <td><?php echo $row['iso_type_id'];?></td>
                    <td><?php echo $row['iso_type_name'];?></td>
                    <td><?php echo $row['created_by'];?></td>
                    <td><?php echo $row['created_on'];?></td>
  
                    <td align="center">
                        <a href="home.php?<?php echo token(); ?>mnu=mstisoedit<?php echo token2(); ?>&isotype_id=<?php echo $row['iso_type_id']; ?>" data-toggle='tooltip' title='edit'>
                            <button class='btn-flat bg-blue'><i class='fa fa-pencil-square-o'></i> Edit</button>
                        </a> 
                     <?php //echo $btn_act1; ?>      
                        <a href='doc_iso/act-dociso.php?act=del&mod=mstiso&isotype_id=<?php echo $row['iso_type_id']; ?>' data-toggle='tooltip' title='delete' onclick="return confirm('All reference data will be deleted. \n Are you sure want to delete this data [<?php echo $row['iso_type_name']; ?>]?')">
                            <button class='btn-flat' style="background-color: #db2b2b; color: #fff; "><i class='fa fa-trash-o'></i> Delete</button>
                        </a>
                     <?php //echo $btn_act2; ?> 
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
  <div class="modal fade" id="addModalx" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create ISO Type</h4>
            </div>
            <div class="modal-body">
                <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label>ISO Type Name</label>
                        <input type="text" class="form-control" id="iso_type_name" name="iso_type_name" 
                        placeholder="ISO Type Name (Ex. 9001:2015, 16949:2009, etc)" required>
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


  
</div>
</div>



<?php 
    if (isset($_POST['submit-add'])){

        $cert_type_name   = $_POST['iso_type_name'];
        $id_user          = $_SESSION['id_user'];

        $query_exec = get_mstiso_data_by_name($cert_type_name);
        //$row = mysqli_fetch_assoc($query_exec);
        $exist = mysqli_num_rows($query_exec);

        if ( $exist >= 1 ) {

            echo '
            <script>
            swal({
                title: "Error!",
                text: "Name already exist",
                type: "error",
                customClass: \'swal-wide\',
                allowOutsideClick: false
            });
            
            </script>
            ';
            
        } else {

            insert_mstiso_data($cert_type_name, $id_user);

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
                window.location = (\'../view/home.php?mnu=mstiso\');
            });
            
            </script>
            ';
            
        }
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