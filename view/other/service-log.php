<?php
/**
 * Copyright (c) 2017. Don't copy or use the source code without author permission for comercial purpose(s)
 */

    include "service-data-query.php";
?>

<div class="box-header">
    <h3 class="box-title">Service Log Record</h3>
    <!--
    <div class="pull-right box-tools">

        <div class="btn-group">
            <button href="#" data-toggle="dropdown"><i class="fa fa-bars"></i></button>
            <ul class="dropdown-menu pull-right" role="menu">
                <li><a href="#addModal" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-plus-circle"></i>Create User</a>
                </li>
            </ul>
        </div>
    </div>
    -->

</div><!-- /.box-header -->
<hr style="margin-top: 1px;">

<div class="box-body table-responsive">                        
    <table id="example2" class="table table-bordered table-striped">                      
                                
        <thead>
            <tr>
                <th>Date Access</th>
                <th>IP Address / Service Name</th>
                <th width='200px'>Vars</th>
                <th>Attempt</th>
            </tr>
        </thead>
        
        <tbody>                            
           <?php
                //PHP TAG
                $no =1;
                $query_exec = get_all_service_log();

                while ($row = mysqli_fetch_assoc($query_exec)) {
                    
                    
                    if ($row['objective']=='S') {
                        $status = "<small class='label label-success'> Success</small>";
                    } elseif ($row['objective']=='F') {
                        $status = "<small class='label label-warning'> Failed</small>";
                    } elseif ($row['objective']=='E') {
                        $status = "<small class='label label-warning'> Exception Error</small>";
                    } elseif ($row['objective']=='X') {
                        $status = "<small class='label label-danger'> Invalid Key</small>";
                    }else {
                        $status = "<small class='label label-default'> Unidentified</small>";
                    }
                    

                    $time = strtotime($row['date_log']);
                    $act_datetime = date("d.m.Y h:i A", $time);

                    echo "    <tr>";
                    echo "        <td >".$act_datetime."</td>";
                    echo "        <td><div>".$row['ip_address']."</div><small><i>".$row['service']."</i></small></td>";
                    echo "        <td >".$row['vars']."</td>";
                    echo "        <td>".$status."</td>";
                    echo "    </tr>";
                }   
            ?>                               
        </tbody>
        
    </table>

</div><!-- /.box-body -->

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

        <script>
            function block_conf(id, user) {

                if(id == "" && user == ""){
                    swal({
                        title: 'Error!',
                        text: 'You can\'t block unidentified user!',
                        type: 'error',
                        allowOutsideClick: false
                    })
                } else {
                    swal({
                        title: 'Are you sure?',
                        text: "Block user " + user + "?",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, block it!',
                        cancelButtonText: 'No, cancel!',
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger',
                        buttonsStyling: true,
                        allowOutsideClick: false
                    }).then(function () {

                        window.location = ('registration/act-master-data.php?act=inact&mod=umaster&id_user=' + id);

                    }, function (dismiss) {
                        // dismiss can be 'cancel', 'overlay',
                        // 'close', and 'timer'
                        if (dismiss === 'cancel') {
                            swal({
                                title: 'Cancelled',
                                text: 'Block canceled!',
                                type: 'error',
                                allowOutsideClick: false
                            })
                        }
                    })
                }
            }
        </script>

    </body>
</html>

