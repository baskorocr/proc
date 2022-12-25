<?php
/**
 * Copyright (c) 2018. Don't copy or use the source code without author permission for comercial purpose(s)
 */

//include "../conn/conn_proc.php";
//include "schedule-delivery-query.php";
//include "function.php";
include "dociso-query.php";
include "project_mgt/project-mgt-query.php";

?>

<body>
<div class="box-header with-border">

   <h3 class="box-title">Dashboard ISO Document Expired</h3>

</div>
<hr style="margin-top: 1px;">

<div class="box-body">
    <?php

        $id_user = $_SESSION['id_user'];

        $query = get_vendor_user($id_user);
        $row = mysqli_fetch_assoc($query);
        //$id_vendor  = $row['id_vendor'];
        $data['id_vendor'] = isset($row['id_vendor']) ? $row['id_vendor'] : '';
        $id_vendor = isset($row['id_vendor']) ? $row['id_vendor'] : '';

        $role = $_SESSION['role'];
    ?>
   
<!-- Small boxes (Stat box) -->
    <div class="row">
        
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <?php
                if($role == 'vendor') {
                    $query_exec_valid = get_reg_iso_by_stat('V', $id_vendor);
                } else {
                    $query_exec_valid = get_reg_iso_by_stat('V','');
                }
                $count_valid = mysqli_num_rows($query_exec_valid);
            ?>
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?php echo $count_valid; ?></h3>
                    <p>Valid Document</p>
                </div>
                <div class="icon">
                    <i class="ion ion-document"></i>
                </div>
                <a href="home.php?<?php echo token(); ?>mnu=isodocstat<?php echo token2(); ?>&stat=V" class="small-box-footer" target="_blank">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <?php

                if($role == 'vendor') {
                    $query_exec_notifd = get_reg_iso_by_stat('N', $id_vendor);
                } else {
                    $query_exec_notifd = get_reg_iso_by_stat('N', $id_vendor);
                }
                $count_notifd = mysqli_num_rows($query_exec_notifd);
            ?>
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3><?php echo $count_notifd; ?></h3>
                    <p>Renewed Document</p>
                </div>
                <div class="icon">
                    <i class="ion ion-document"></i>
                </div>
                <a href="home.php?<?php echo token(); ?>mnu=isodocstat<?php echo token2(); ?>&stat=N" class="small-box-footer" target="_blank">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <?php
                if($role == 'vendor') {
                    $query_exec_exprd = get_reg_iso_by_stat('E', $id_vendor);
                } else {
                    $query_exec_exprd = get_reg_iso_by_stat('E', '');
                }
                $count_exprd = mysqli_num_rows($query_exec_exprd);
            ?>
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?php echo $count_exprd; ?></h3>
                    <p>Expired Document</p>
                </div>
                <div class="icon">
                    <i class="ion ion-document"></i>
                </div>
                <a href="home.php?<?php echo token(); ?>mnu=isodocstat<?php echo token2(); ?>&stat=E" class="small-box-footer" target="_blank">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <?php
                if($role == 'vendor') {
                    $query_exec_tot = get_reg_iso_all_stat($id_vendor);
                } else {
                    $query_exec_tot = get_reg_iso_all_stat('');
                }
                $count_tot = mysqli_num_rows($query_exec_tot);
            ?>
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3><?php echo $count_tot; ?></h3>
                    <p>Total Document</p>
                </div>
                <div class="icon">
                    <i class="ion ion-document"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
                        
    </div><!-- /.row -->

    <form role=form name="myForm" onSubmit="return downloadfunction()" action="#" method="post" enctype="multipart/form-data">
        
        <table class="table table-striped display nowrap"  style="width:100%" data-striping="false" data-toggle-column="last" data-paging="true" data-sorting="true" data-filtering="true"> 
            <thead>

            <?php

                //$data['id_vendor'] = '211445';
                if($role == 'vendor') {
                    $query_exec = get_all_iso_data_by_vendor($id_vendor);
                } else {
                    $query_exec = get_all_iso_data();
                }
            ?>
                    <tr>
                        <!--
                        <th><i class="fa fa-list"></i></th>
                        -->
                        <th data-breakpoints="xs sm md">Vendor Code</th>
                        <th >Vendor Name</th>
                        <th data-breakpoints="xs sm md">Material Supply</th>
                        <th data-breakpoints="xs sm md">Simplikasi</th>
                        <th >ISO Cert Num</th>
                        <th data-breakpoints="all" >ISO Cert Date</th>
                        <th data-breakpoints="all" >Certified</th>
                        <th data-breakpoints="all" >ISO Type</th>
                        <th data-breakpoints="xs sm md" >Expire Date</th>
                        <th data-breakpoints="xs sm md" >Expired Status</th>
                        <th data-breakpoints="xs sm md" >Doc Process</th>
                        <th data-breakpoints="all" >File</th>
                        <th data-breakpoints="all" >Last change</th>
                        <th data-breakpoints="all" >Entry Date</th>
                        <th data-breakpoints="all" >Remark</th>
                    </tr>
                </thead>

                <tbody>

                    <?php

                        while ($row = mysqli_fetch_assoc($query_exec)) {

                            $query_exec2 = get_transaction_type_id($row['stat']);
                            $row2 = mysqli_fetch_assoc($query_exec2);
                            $count = mysqli_num_rows($query_exec2);
                            if ($count == 1) {
                                $color = 'label label-'.$row2['color'];
                                $stat = '<span class="'.$color.'">'.$row2['trn_name'].'</span>';
                                //$stat = '<span class="label label-success">Valid</span>';
                            } else {
                                $stat = '<span class="label label-primary">'.$row2['trn_name'].'</span>';
                            }

                            $query_exec2 = get_transaction_type_id($row['trn_type']);
                            $row2 = mysqli_fetch_assoc($query_exec2);
                            $count = mysqli_num_rows($query_exec2);
                            
                            if ($count == 1) {
                                $color = 'label label-'.$row2['color'];
                                $doc_proccess = '<span class="'.$color.'">'.$row2['trn_name'].'</span>';
                            } else {
                                $doc_proccess = '<span class="label label-primary">'.$row2['trn_name'].'</span>';
                            }

                            if ($row['simply'] == "X") {
								$simplify = '<center><i class="fa fa-check"></i></center>';
							}else{
								$simplify = '';
							}
                    ?>

                    <tr class="rowlink">
                        <!--
                        <td><input type="checkbox" name="selectiso[]" value="">
                            <input type="hidden" name="trn_id" value ="" />
                            <input type="hidden" name="idvendor" value ="" />
                        </td>
                        -->

                        <td><?php echo $row['id_vendor'] ; ?></td>
                        <td><?php echo $row['nm_vendor'] ; ?></td>
                        <td><?php echo $row['mat_supply'] ; ?></td>
                        <td><?php echo $simplify ; ?></td>
                        <td><?php echo $row['cert_num'] ; ?></td>
                        <td><?php echo $row['cert_date'] ; ?></td>
                        <td><?php echo $row['cert_name'] ; ?></td>
                        <td><?php echo $row['iso_type_name'] ; ?></td>
                        <td><?php echo $row['exp_date'] ; ?></td>
                        <td><?php echo $stat ; ?></td>
                        <td><?php echo $doc_proccess; ?></td>
                        <td>
                            <a href="DATA_DOCISO/viewpdf.php?id=<?php echo $row['id_vendor'];?>&nm=<?php echo $row['doc_path']; ?>" class="btn btn-flat" target="_blank" data-toggle='tooltip' title='click to preview' >
                                <i class="fa fa-file"></i>
                            </a>
                        </td>
                        <td><?php echo $row['ch_date'] ; ?></td>
                        <td><?php echo $row['cr_date'] ; ?></td>
                        <td><?php echo $row['remark'] ; ?></td>
                    </tr>

                    <?php
                        }
                    ?>
                </tbody>

        </table>

        <div class="">
            <!-- post array -->
            <!--
            <div class="box-footer">
                <button type="submit" name="checked-po" class="btn btn-flat btn-success">
                    <i class="fa fa-download"></i> Download Checked
                </button>
            </div>
            -->

        </div>
    </form>

</div>

<?php

    if(isset($_GET['msg']) == '404'){
?>

<script>

    swal({
        title: 'Error',
        text: 'File does not exist!',
        type: 'error',
        allowOutsideClick: false
    })

</script>

<?php

    } elseif(isset($_GET['msg']) == '400'){
 ?>

        <script>

            swal({
                title: 'Error',
                text: 'No list selected!',
                type: 'error',
                allowOutsideClick: false
            })

        </script>

 <?php
    }
?>

<!-- ============ SCRIPT ================= -->
<!-- jQuery 2.0.2 -->
<script src="../jquery-2/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../js/bootstrap.min.js" type="text/javascript"></script>

<!-- DATA TABES SCRIPT -->

<script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<script src="../js/plugins/datatables/addon/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="../js/plugins/datatables/addon/buttons.flash.min.js" type="text/javascript"></script>
<script src="../js/plugins/datatables/addon/jszip.min.js" type="text/javascript"></script>
<script src="../js/plugins/datatables/addon/pdfmake.min.js" type="text/javascript"></script>
<script src="../js/plugins/datatables/addon/vfs_fonts.js" type="text/javascript"></script>
<script src="../js/plugins/datatables/addon/buttons.html5.min.js" type="text/javascript"></script>
<script src="../js/plugins/datatables/addon/buttons.print.min.js" type="text/javascript"></script>

<link href="../footable/footable-standalone/css/footable.standalone.css" rel="stylesheet" type="text/css" />
<link href="../footable/footable-standalone/css/footable.standalone.min.css" rel="stylesheet" type="text/css" />
<script src="../footable/jquery-3.5.1.js" type="text/javascript"></script>

<script src="../footable/footable-standalone/js/footable.js" type="text/javascript"></script>
<script src="../footable/footable-standalone/js/footable.min.js" type="text/javascript"></script>

<!-- FOOTABLE -->
<!--
<script src="../css/footable/js/footable.min.js" type="text/javascript"></script>
-->

<!-- AdminLTE App -->
<script src="../js/AdminLTE/app.js" type="text/javascript"></script>


<!-- page script -->
<script type="text/javascript">
    $(function() {
        $("#example2").dataTable( {
            /*
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel'
            ],
            */
            "scrollX": true,
            "filter" : true,
            "lengthChange" : false,
            "sort"         : true,
            "paginate"     : true,
            "autowidth"    : false
        } );
    });

</script>


<!--
<script type="text/javascript">
    jQuery(function($){
        $('.table').footable();
    });
</script>
-->

<script>
	$(document).ready( function () {
 		$('.table').footable();
	})
</script>
