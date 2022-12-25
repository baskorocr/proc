<?php
    //include "../conn/conn_proc.php";
    include "dociso-query.php";
    include "project_mgt/project-mgt-query.php";
    
?>

<div class="box-header">
    <h3 class="box-title">Review ISO Document </h3>   

    <!--
    <div class="pull-right box-tools">
        <div class="btn-group">
            <a href="#" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
            <ul class="dropdown-menu pull-right" role="menu">
                <li><a href="#addModalx" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-plus-square"></i>Create ISO Notify</a>
                </li>
            </ul>
        </div>
    </div>
     -->

</div><!-- /.box-header -->

<hr style="margin-top: 1px;">

<div class="box-body table-responsive">    
    
    <?php 

        $id_user = $_SESSION['id_user'];

        $query = get_vendor_user($id_user);
        $row = mysqli_fetch_assoc($query);
        //$id_vendor  = $row['id_vendor'];
        $data['id_vendor'] = $row['id_vendor'];
        $vendor_id = $row['id_vendor'];

        $role = $_SESSION['role'];

        $trn_id     = $_GET['trn_id'];
        $doc_year   = $_GET['doc_year'];

        if($role == 'vendor') {
            $query_exec = get_all_iso_data_by_vendor_trn_id($vendor_id, $trn_id, $doc_year);
        } else {
            $query_exec = get_all_iso_data_by_trn_id($trn_id, $doc_year);
        }
        
        /*
        $row = mysqli_fetch_assoc($query_exec);

        if ($row['stat'] == 'V') {

            $stat = '<span class="label label-success">Valid</span>';
        } else {
            $stat = '<span class="label label-danger">Expired</span>';
        }
        */
        $row = mysqli_fetch_assoc($query_exec);

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

        if ($row['simply'] == 'X'){
            $simplify = "checked";
        } else {
            $simplify = '';
        }
    ?>

    <!-- form start -->
    <form role="form">

        <div class="form-group">
            <label>Doc Status</label>
            <h4>
                <?php echo $stat; ?>
            </h4>
        </div>
        <div class="form-group">
            <label>Doc Process</label>
            <h4>
                <?php echo $doc_proccess; ?>
            </h4>
        </div>
        <div class="form-group">
            <label>Vendor</label>
            <select class="form-control selectpicker" name="id_vendor" data-live-search="true" required disabled>
                <option value='<?php echo $row['id_vendor']; ?>'><?php echo $row['id_vendor']." - ".$row['nm_vendor']; ?></option>  
            </select>
        </div>

        <?php
            if($role != 'vendor') 
            {
        ?>
        <div class="form-group">
            <label>Material Supply</label> 
            <select class="form-control selectpicker" name="" data-live-search="true" required disabled>
                <option value="<?php echo $row['mat_supply'] ; ?>"><?php echo $row['mat_supply'] ; ?></option>
            </select>
        </div>  
        <div class="checkbox">
            <label>
                <input type="checkbox" name="simply" <?php echo $simplify; ?> disabled> Simplikasi
            </label>
        </div>
        <?php
            }
        ?>

        <div class="form-group">
            <label>Certified</label>
            <select class="form-control selectpicker" name="cert_id" data-live-search="true" disabled>
		        <option value="<?php echo $row['cert_name'] ; ?>"><?php echo $row['cert_name'] ; ?></option> 
            </select>
        </div>  
        <div class="form-group">
            <label>ISO Type</label>
            <select class="form-control selectpicker" name="iso_type_id" data-live-search="true" disabled>
                <option value="<?php echo $row['iso_type_name'] ; ?>"><?php echo $row['iso_type_name'] ; ?></option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">ISO Certified Number</label>
            <input type="email" class="form-control" value = "<?php echo $row['cert_num'] ; ?>" id="exampleInputEmail1" placeholder="ISO Certified Number" disabled>
        </div>
        <div class="form-group">
            <label>ISO Certified Date</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control" value = "<?php echo $row['cert_date'] ; ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask disabled/>
            </div><!-- /.input group -->
        </div><!-- /.form group -->
        
        <div class="form-group">
            <label>ISO Expired Date</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control" value = "<?php echo $row['exp_date'] ; ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask disabled/>
            </div>
        </div> 

        <div class="form-group">
        <label>Notify Before</label>
            <div class="box ">
        
                <div class="box-body" style="">
                    <div class="table-responsive">

                        <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>Notif ID</th>
                                <th>Notify Before</th>
                                <th>Notify Date</th>
                                <th>Notified at</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php   
                                $query_exec1 = get_all_notif_iso($trn_id, $doc_year);
                                while ($row1 = mysqli_fetch_assoc($query_exec1)) {
                                    
                                    $notif_id 	 	= $row1['notif_id'];
                                    //$notif_seq      = $row1['notif_seq'];
                                    $notif_before 	= $row1['notif_before'];
                                    $uom 	        = $row1['uom'];
                                    $notify_date	= date('d/m/Y', strtotime($row1['notify_date']));

                                    if ( $row1['notified_at'] == '0000-00-00 00:00:00') {
                                        $notified_at = "";
                                    } else {
                                        $notified_at = date('d/m/Y H:i:s', strtotime($row1['notified_at'])); //$row1['notified_at'];
                                    }
                                   
                                    if ($row1['uom'] == "M"){
                                        $measure = "Months";
                                    } elseif($row1['uom'] == "D"){
                                        $measure = "Days";
                                    } elseif($row1['uom'] == "Y"){
                                        $measure = "Year";
                                    }
                            ?>
                            <tr>
                                <td><?php echo $notif_id;?></td>
                                <td><?php echo $notif_before." ".$measure;?></td>   
                                <td><?php echo $notify_date;?></td>
                                <td><?php echo $notified_at;?></td>
                            </tr>
                            <?php
                                }
                            ?>
                            </tbody>
                        </table>

                    </div>
                </div>
    
          </div>
        </div>

        <div class="form-group">
            <label>Remarks</label>
            <textarea class="form-control" rows="3" placeholder="Enter ..." disabled><?php echo $row['remark']; ?>
            </textarea>
        </div>

        <div class="form-group">
            <a href="DATA_DOCISO/viewpdf.php?id=<?php echo $row['id_vendor'];?>&nm=<?php echo $row['doc_path']; ?>" class="btn btn-flat" target="_blank" data-toggle='tooltip' title='click to preview' >
                <i class="fa fa-file"></i><label for="exampleInputFile">&nbsp; Click to Preview (<?php echo $row['doc_path']; ?>)</label>
            </a>
           
        </div>
        
    </form>

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