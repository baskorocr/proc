<?php
/**
 * Copyright (c) 2017. Don't copy or use the source code without author permission for comercial purpose(s)
 */

    include "master-data-query.php";
    include "master-data-func.php";
?>

<div class="box-header">
    <h3 class="box-title">User Log Record</h3>
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
                <th>No</th>
                <th>Username</th>
                <th>IP Address</th>
                <th>Activity</th>
                <th>Last Activity</th>
                <th>Attempt</th>
                <th>User Type</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        
        <tbody>                            
           <?php
                //PHP TAG
                $no =1;
                $query_exec = get_all_user_log_data();

                while ($row = mysqli_fetch_assoc($query_exec)) {

                    if ($row['status_user']=='A') {
                        $status = "<small class='label label-success'> Active</small>";
                        $disabled = "";
                    } elseif ($row['status_user']=='N') {
                        $status = "<small class='label label-warning'> Blocked</small>";
                        $disabled = "hidden";
                    } else {
                        $status = "<small class='label label-danger'> Unidentified</small>";
                    }

                    if ($row['id_user'] != "" AND $row['id_vendor'] == ""){
                        $foreign_user = "Internal user";
                        $foreign_nm   = "Dharma Polimetal";
                    } elseif ($row['id_user'] != "" AND $row['id_vendor'] != "") {
                        $foreign_user = "External user";
                        $foreign_nm   = $row['nm_vendor'];
                    } elseif ($row['id_user'] == "" AND $row['id_vendor'] == "") {
                        $foreign_nm = $row['info'];
                    }

                    if ($row['activity']=='in') {
                        $activity = "<small class='label label-info'> <i class='fa fa-arrow-circle-right'></i> IN</small>";
                    } elseif ($row['activity']=='out') {
                        $activity = "<small class='label label-warning'><i class='fa fa-arrow-circle-left'></i> OUT</small>";
                    }

                    if ($row['attempt']=='S') {
                        $attempt = "<small class='label label-success'> <i class='fa fa-check-square-o'></i> Success</small>";
                    } elseif ($row['attempt']=='F') {
                        $attempt = "<small class='label label-danger'><i class='fa fa-exclamation'></i> Failed</small>";
                    }

                    $time = strtotime($row['datetime_log']);
                    $last_act_datetime = date("D, d.m.Y h:i A", $time);

                    $username = $row['username'];

                    if ($row['nm_tipe_user'] != "") {
                        $user_type = $row['nm_tipe_user'];
                    } else {
                        $user_type = "<i>Unknown</i>";
                    }

                    echo "    <tr>";
                    echo "        <td>".$no++."</td>";
                    echo "        <td><div>".$username."</div><small><i>$foreign_nm</i></small></td>";
                    echo "        <td>".$row['ip_address']."</td>";
                    echo "        <td>".$activity."</td>";
                    echo "        <td>".$last_act_datetime."</td>";
                    echo "        <td>".$attempt."</td>";
                    echo "        <td>".$user_type."</td>";
                    echo "        <td>".$status."</td>";
                    echo "        <td align='center'>";
                    ?>

                    <a href='#' data-toggle='tooltip' title='block <?php echo $row['username']; ?>' data-placement = "bottom" onclick=" return block_conf('<?php echo $row['id_user']; ?>', '<?php echo $username; ?>')">
                        <button class='btn-flat' style="background-color: #db2b2b; color: #fff; " <?php echo $disabled; ?> ><i class='fa fa-minus-circle'></i> Block</button>
                    </a>

                    <?php

                    echo "        </td>";
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

