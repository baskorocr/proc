

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

   <h3 class="box-title">Document ISO Report</h3>

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

        <div class="col-lg-2 col-xs-3">
            <!-- small box -->
            <?php
                if($role == 'vendor') {
                    $query_exec_submtd = get_reg_iso_by_trn_type('S', $id_vendor);
                } else {
                    $query_exec_submtd = get_reg_iso_by_trn_type('S', '');
                }
                $count_submtd = mysqli_num_rows($query_exec_submtd);
            ?>
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3><?php echo $count_submtd; ?></h3>
                    <p>Submited Document</p>
                </div>
                <div class="icon">
                    <i class="ion ion-document"></i>
                </div>
                <a href="home.php?<?php echo token(); ?>mnu=isodoctype<?php echo token2(); ?>&typ=S" class="small-box-footer" target="_blank">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->

        <div class="col-lg-2 col-xs-3">
            <!-- small box -->
            <?php
                if($role == 'vendor') {
                    $query_exec_updated = get_reg_iso_by_trn_type('U', $id_vendor);
                } else {
                    $query_exec_updated = get_reg_iso_by_trn_type('U', '');
                }
                
                $count_updated = mysqli_num_rows($query_exec_updated);
            ?>
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3><?php echo $count_updated; ?></h3>
                    <p>Updated Document</p>
                </div>
                <div class="icon">
                    <i class="ion ion-document"></i>
                </div>
                <a href="home.php?<?php echo token(); ?>mnu=isodoctype<?php echo token2(); ?>&typ=U" class="small-box-footer" target="_blank">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->

        <div class="col-lg-2 col-xs-3">
            <!-- small box -->
            <?php

                if($role == 'vendor') {
                    $query_exec_rejctd = get_reg_iso_by_trn_type('C', $id_vendor);
                } else {
                    $query_exec_rejctd = get_reg_iso_by_trn_type('C','');
                }
                $count_rejctd = mysqli_num_rows($query_exec_rejctd);
            ?>
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?php echo $count_rejctd; ?></h3>
                    <p>Rejected Document</p>
                </div>
                <div class="icon">
                    <i class="ion ion-document"></i>
                </div>
                <a href="home.php?<?php echo token(); ?>mnu=isodoctype<?php echo token2(); ?>&typ=C" class="small-box-footer" target="_blank">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->

        <div class="col-lg-2 col-xs-3">
            <!-- small box -->
            <?php

                if($role == 'vendor') {
                    $query_exec_approved = get_reg_iso_by_trn_type('R', $id_vendor);
                } else {
                    $query_exec_approved = get_reg_iso_by_trn_type('R', '');
                }
                $count_approved = mysqli_num_rows($query_exec_approved);
            ?>
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?php echo $count_approved; ?></h3>
                    <p>Approved Document</p>
                </div>
                <div class="icon">
                    <i class="ion ion-document"></i>
                </div>
                <a href="home.php?<?php echo token(); ?>mnu=isodoctype<?php echo token2(); ?>&typ=R" class="small-box-footer" target="_blank">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->

        <div class="col-lg-2 col-xs-4">
            <!-- small box -->
            <?php
                if($role == 'vendor') {
                    $query_exec_notifd = get_reg_iso_by_trn_type('E', $id_vendor);
                } else {
                    $query_exec_notifd = get_reg_iso_by_trn_type('E', '');
                }
                $count_notifd = mysqli_num_rows($query_exec_notifd);
            ?>
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3><?php echo $count_notifd; ?></h3>
                    <p>Notified Document</p>
                </div>
                <div class="icon">
                    <i class="ion ion-document"></i>
                </div>
                <a href="home.php?<?php echo token(); ?>mnu=isodoctype<?php echo token2(); ?>&typ=I" class="small-box-footer" target="_blank">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->

        <div class="col-lg-2 col-xs-4">
            <!-- small box -->
            <?php
                if($role == 'vendor') {
                    $query_exec_tot = get_all_iso_data_by_vendor($id_vendor);
                } else {
                    $query_exec_tot = get_all_iso_data();
                }
                $count_tot = mysqli_num_rows($query_exec_tot);
            ?>
            <div class="small-box bg-navy">
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

    <!--   -->
    <form role=form name="myForm" onSubmit="return downloadfunction()" action="zip_iso_all.php" method="post" enctype="multipart/form-data">
        
		<table class="table table-striped display nowrap"  style="width:100%" > 
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
						<th data-breakpoints="xs sm md">Action</th>
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
                        <th data-breakpoints="all" >Doc Number</th>
                        <th data-breakpoints="all" >Ref Number</th>
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
                                        <a href="home.php?<?php echo token(); ?>mnu=isoreview<?php echo token2(); ?>&trn_id=<?php echo $row['trn_id'];?>&doc_year=<?php echo $row['doc_year'];?>">
                                        <i class='fa fa-eye'></i> View</a>
                                    </li>

                                    <?php

                                        $query_check = get_all_iso_data_by_ref_trn_id($row['trn_id'], $row['doc_year']);
                                        $check_num   = mysqli_num_rows($query_check);

                                        if ( ($check_num == 0 AND $row['trn_type'] == 'R') OR $row['trn_type'] == 'I') 
                                        {
                                    ?>
                                        <li>
                                            <a href="home.php?<?php echo token(); ?>mnu=isorenewal<?php echo token2(); ?>&trn_id=<?php echo $row['trn_id'];?>&doc_year=<?php echo $row['doc_year'];?>">
                                            <i class='fa fa-copy'></i> Renew</a>
                                        </li>
                                    <?php
                                        }
                                    ?>
 
                                    <?php if ( ($row['stat'] != 'N' AND $row['stat'] != 'E' ) AND $row['trn_type'] != 'R' AND $row['trn_type'] != 'I') {?>
                                        <li>
                                            <a href="home.php?<?php echo token(); ?>mnu=isochange<?php echo token2(); ?>&trn_id=<?php echo $row['trn_id'];?>&doc_year=<?php echo $row['doc_year'];?>">
                                            <i class='fa fa-pencil'></i> Change</a>
                                        </li>
                                    <?php } ?>
                                    
                                    <?php if($role != 'vendor') { ?>
                                        
                                        <?php if ( ( $row['stat'] != 'N' AND $row['stat'] != 'E') AND $row['trn_type'] != 'R' AND $row['trn_type'] != 'I' ) {?>
                                            <li>
                                                <a href="home.php?<?php echo token(); ?>mnu=isorelease<?php echo token2(); ?>&trn_id=<?php echo $row['trn_id'];?>&doc_year=<?php echo $row['doc_year'];?>">
                                                <i class='fa fa-check-square-o'></i> Approval</a>
                                            </li>
										
                                            <li>
                                                <a href='doc_iso/act-dociso.php?act=del&mod=regiso&trn_id=<?php echo $row['trn_id'];?>&doc_year=<?php echo $row['doc_year'];?>&id_user=<?php echo $_SESSION['id_user']; ?>' 
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
                        <td><?php echo $simplify; ?></td>
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
                        <td><?php echo $row['trn_id']."-".$row['doc_year'] ; ?></td> 
                          
                        <?php
                            if ( $row['ref_doc'] == '0000000000') {
                                echo "<td></td>";
                            }  else {
                            ?>
                                <td>
                                    <a href="home.php?<?php echo token(); ?>mnu=isoreview<?php echo token2(); ?>&trn_id=<?php echo $row['ref_doc'];?>&doc_year=<?php echo $row['ref_doc_year'];?>" 
                                        target="_blank">
                                        <?php echo $row['ref_doc']."-".$row['ref_doc_year']; ?>
                                    </a> 
                                </td>
                        <?php    
                            }

                        ?>   

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
<!--
<script src="../jquery-2/jquery.min.js"></script>
-->
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

<script>
	$(document).ready( function () {
 		$('.table').footable();
	})
</script>
