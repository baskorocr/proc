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

    <?php
        
        $trn_id     = $_GET['stat'];
        $query      = get_transaction_type_id($trn_id);
        $name       = mysqli_fetch_assoc($query);
        $stat       = $name['trn_id'];
        $trn_name   = $name['trn_name'];

    ?>

   <h3 class="box-title">Document ISO Status [<?php echo $trn_name; ?>]</h3>

</div>
<hr style="margin-top: 1px;">

<div class="box-body">

    <?php

        $id_user = $_SESSION['id_user'];

        $query = get_vendor_user($id_user);
        $row = mysqli_fetch_assoc($query);
        //$id_vendor  = $row['id_vendor'];
        $data['id_vendor'] = $row['id_vendor'];
        $id_vendor = $row['id_vendor'];

        $role = $_SESSION['role'];
    ?>
   
    <form role=form name="myForm" onSubmit="return downloadfunction()" action="zip_iso_all.php" method="post" enctype="multipart/form-data">
        
        <table class="table table-striped display nowrap"  style="width:100%" data-striping="false" data-toggle-column="last" data-paging="true" data-sorting="true" data-filtering="true"> 
            <thead>
                 <?php
                    
                    //$data['id_vendor'] = '211445';
                    if($role == 'vendor') {
                        $query_exec = get_all_iso_data_by_vendor_stat($id_vendor, $stat);
                        //get_all_iso_data_by_vendor($id_vendor);

                    } else {
                        //$query_exec = get_all_iso_data();
                        $query_exec = get_all_iso_data_by_stat($stat);
                    }
                ?>
                    <tr>
                        <th data-breakpoints="xs sm md">Action</th>
                        <th data-breakpoints="xs sm md">Vendor Code</th>
                        <th >Vendor Name</th>
                        <th data-breakpoints="xs sm md">Material Supply</th>
                        <th data-breakpoints="xs sm md">Simplikasi</th>
                        <th >ISO Cert Num</th>
                        <th data-breakpoints="xs sm md" >ISO Cert Date</th>
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
                    ?>

                    <tr>
                        <!--
                        <td>
                            <input type="checkbox" name="selectiso[]" value="<?php echo $row['doc_path']; ?>" <?php //echo $stat; ?> >
                            <input type="hidden" name="trn_id"      value ="<?php echo $row['trn_id'];?>" />
                            <input type="hidden" name="id_vendor[]"   value ="<?php echo $row['id_vendor'];?>" />
                        </td>
                        -->
        
                        <td>
                            
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Choose
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu">

                                    <li>
                                        <a href="home.php?mnu=isoreview&trn_id=<?php echo $row['trn_id'];?>&doc_year=<?php echo $row['doc_year'];?>">
                                        <i class='fa fa-eye'></i> View</a>
                                    </li>

                                    <!-- check each lines has reference document-->
                                    <?php

                                        $query_check = get_all_iso_data_by_ref_trn_id($row['trn_id'], $row['doc_year']);
                                        $check_num   = mysqli_num_rows($query_check);

                                        if ($check_num == 0) 
                                        {
                                    ?>
                                        <li>
                                            <a href="home.php?mnu=isorenewal&trn_id=<?php echo $row['trn_id'];?>&doc_year=<?php echo $row['doc_year'];?>">
                                            <i class='fa fa-copy'></i> Renew</a>
                                        </li>
                                    <?php
                                        }
                                    ?>

                                    <?php if ( ($row['stat'] != 'A' AND $row['stat'] != 'E') ) {?>
                                        <li>
                                            <a href="home.php?mnu=isochange&trn_id=<?php echo $row['trn_id'];?>&doc_year=<?php echo $row['doc_year'];?>">
                                            <i class='fa fa-pencil'></i> Change</a>
                                        </li>
                                    <?php } ?>
                                    
                                    <?php if($role != 'vendor') { ?>
                                        
                                        <?php if ( ($row['stat'] != 'A' AND $row['stat'] != 'E') ) {?>
                                            <li>
                                                <a href="home.php?mnu=isorelease&trn_id=<?php echo $row['trn_id'];?>&doc_year=<?php echo $row['doc_year'];?>">
                                                <i class='fa fa-check-square-o'></i> Approval</a>
                                            </li>
                                        
                                            <li>
                                                <a href='doc_iso/act-dociso.php?act=del&mod=regiso&trn_id=<?php echo $row['trn_id'];?>&doc_year=<?php echo $row['doc_year'];?>' 
                                                    data-toggle='tooltip' onclick="return confirm('All reference data will be deleted. \n Are you sure want to delete this data [<?php echo $row['trn_id'];?>]?')">
                                                <i class='fa fa-trash-o'></i> Delete</a>
                                            </li>   
                                        <?php } ?>
                                        
                                    <?php } ?>
                                </ul>
                            </div>
                            
                        </td>

                        <td><?php echo $row['id_vendor'] ; ?></td>
                        <td><?php echo $row['nm_vendor'] ; ?></td>
                        <td><?php echo $row['mat_supply'] ; ?></td>
                        <td><?php echo $row['simply'] ; ?></td>
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
        
        <!--
        <div class="">
            <div class="box-footer">
                <button type="submit" name="checked-po" class="btn btn-flat btn-success">
                    <i class="fa fa-download"></i> Download Checked
                </button>
            </div>
        </div>
        -->
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