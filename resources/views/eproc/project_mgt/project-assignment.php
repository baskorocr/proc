<?php
    include "project-mgt-query.php";
    include "project-mgt-func.php";
    include "../lib/function.php";
?>

<div class="box-header">
    <h3 class="box-title">Project Assignment</h3>   

    <div class="pull-right box-tools">
        <!-- button with a dropdown -->
        <div class="btn-group">
            <a href="#" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
            <ul class="dropdown-menu pull-right" role="menu">
                <li><a href="home.php?<?php echo token(); ?>mnu=projmaster<?php echo token2(); ?>" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-table"></i>Project Master</a>
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
                <th>ID Project</th>
                <th>Project Name</th>
                <th>Product Name</th>
                <th>Part Name</th>
                <th>Last Change Date</th>
                <th>Last Changed by</th>
                <th>Status</th>
                <!--
                <th>Action</th>
                -->
            </tr>
        </thead>
        <tbody> 
                                  
           <?php
                //PHP TAG
                
                $no =1;
                $query_exec = get_all_assignment_project_data();

                while ($row = mysqli_fetch_assoc($query_exec)) {

                    if ( $_SESSION['role']== "admin") {
                        $btn_act = "";
                    } else {
                        $btn_act = "disabled";
                    }

            ?>
                <tr>
                    <td><?php echo $no++;?></td>
                    <td><?php echo $row['id_project'];?></td>
                    <td><?php echo $row['nm_project'];?></td>
                    <td><?php echo $row['nm_product'];?></td>
                    <td><?php echo $row['nm_part'];?></td>
                    <td><?php echo $row['modify_date'];?></td>
                    <td><?php echo $row['nm_user'];?></td>
                    <td><small class='label label-success'> Active</small></td>
                    <!--
                    <td align="center">
                    
                        
                        <a href="home.php?mnu=partmasteredit&id_part=<?php echo $row['id_part']; ?>" data-toggle='tooltip' title='edit'>   <button class='btn-flat btn-primary'><i class='fa fa-pencil'></i> Edit</button>
                        </a> 
                        
                                    
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

</div>

       
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