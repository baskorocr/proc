<?php
    include "data-model/my-query.php";
?>

<div class="box-header">
    <h3 class="box-title">Assignment >> Create Project [Nama Project]</h3>   

    <div class="pull-right box-tools">
        <!-- button with a dropdown -->
        <div class="btn-group">
            <a href="#" class="text-muted" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
            <ul class="dropdown-menu pull-right" role="menu">
                <li><a href="#"><i class="fa fa-plus"></i>Create Product</a></li>
                <li><a href="#"><i class="fa fa-plus"></i>Create Part</a></li>
            </ul>
        </div>
    </div><!-- /. tools -->   


</div><!-- /.box-header -->



<div class="box-body table-responsive">                        
    <table id="example2" class="table table-bordered table-striped table-hover">                      
                                
        <thead>
            <tr>
                <th>check</th>
                <th>Product</th>
                <th>Part</th>
                <th>Vendor</th>
            </tr>
        </thead>
        <tbody>                            
           <?php
                //PHP TAG
                $no =1;
                $query_exec = get_all_vendor_data();

                while ($row = mysqli_fetch_assoc($query_exec)) {
                    echo "    <tr>";
                    echo "        <td></td>";
                    echo "        <td>".$row['id_vendor']."</td>";
                    echo "        <td>".$row['vendor_nm']."</td>";
                    echo "        <td>VENDOR/USER</td>";
                    echo "    </tr>";
                }   
            ?>                               
        </tbody>
    </table>
</div><!-- /.box-body -->
                        

        
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
                    "bSort": false,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
        </script>

    </body>
</html>