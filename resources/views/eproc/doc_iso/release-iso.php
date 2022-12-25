<?php
    //include "../conn/conn_proc.php";
    include "dociso-query.php";
    include "project_mgt/project-mgt-query.php";
    include "dociso-func.php";
    
?>

<div class="box-header">
    <h3 class="box-title">Approve/Reject Document ISO</h3>   

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

        $trn_id     = $_GET['trn_id'];
        $doc_year   = $_GET['doc_year'];

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
            //$query_exec = get_po_by_vendor($data);
        } else {
            $query_exec = get_all_iso_data_by_trn_id($trn_id, $doc_year);
        }
        
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
    <form role=form name="myForm" id="myForm" onSubmit="return myLoader()" action="" method="post" enctype="multipart/form-data">

        <input type="hidden" name ="trn_id" value ="<?php echo $trn_id; ?>" />
        <input type="hidden" name ="doc_year" value ="<?php echo $doc_year; ?>" />
        <input type="hidden" name ="vendor_id" value ="<?php echo $vendor_id; ?>">
        <input type="hidden" name ="id_vendor" value ="<?php echo $row['id_vendor']; ?>">
        <input type="hidden" name ="exp_date" value ="<?php echo $row['exp_date'] ; ?>">
        
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
            <select class="form-control selectpicker" name="" data-live-search="true" required disabled>
                <option value='<?php echo $row['id_vendor']; ?>'><?php echo $row['id_vendor']." - ".$row['nm_vendor']; ?></option>  
            </select>
        </div>

        <div class="form-group">
            <label>Material Supply</label>
            <input class="form-control" type="text" value="<?php echo $row['mat_supply'] ; ?>" name="mat_supply" placeholder="OHP, etc." id="mat_supp_id" onkeyup="uppercase('mat_supp_id')" required>
        </div>  

        <div class="checkbox">
            <label>
                <input type="checkbox" name="simplf" <?php echo $simplify; ?> > Simplikasi
            </label>
        </div>

        <div class="form-group">
            <label>Certified</label>
            <input class="form-control" type="text" name="cert_name" value="<?php echo $row['cert_name'] ; ?>" id="cert_name_id" onkeyup="uppercase('cert_name_id')" disabled>
        </div>  

        <div class="form-group">
            <label>ISO Type</label>
            <input class="form-control" type="text" name="iso_type_name" value="<?php echo $row['iso_type_name'] ; ?>" id="iso_name_id" onkeyup="uppercase('iso_name_id')" disabled>
        </div>  

        <div class="form-group">
            <label for="exampleInputEmail1">ISO Certified Number</label>
            <input type="text" class="form-control" value = "<?php echo $row['cert_num'] ; ?>" placeholder="ISO Certified Number" disabled>
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
        
        <?php 
        if ($row['trn_type'] != 'R') 
        {
        ?>
        <div class="box-footer">
            <button type="submit" name="approve_doc" class="btn btn-success">Approve</button>
            <button type="submit" name="reject_doc"  class="btn btn-danger">Reject</button>
        </div>
        <?php
        }
        ?>
        
    </form>

</div>

<?php 

    $id_user    = $_SESSION['id_user'];
    $trn_date   = date('Y-m-d');
    $trn_time   = date('H:i:s');
    $trn_detail = '';
    $ip_addr    = ip_detect();
    

    if (isset($_POST['approve_doc'])){

        $trn_id     = $_POST['trn_id'];
        $doc_year   = $_POST['doc_year'];
        $trn_type   = 'R';
        $id_vendor  = $_POST['id_vendor'];

        $mat_supply = $_POST['mat_supply'];

        $exp_date_sp   = explode("/", $_POST['exp_date']);
        $exp_date_fm   = $exp_date_sp[2]."-".$exp_date_sp[1]."-".$exp_date_sp[0];
        $exp_date      = $exp_date_fm; //check expire date with d-date

        //echo $_POST['simplf'] ;
        if ($_POST['simplf'] == "on") {
            $simply      = 'X';
        } else {
            $simply      = '';
        }

        $date_now = date("Y-m-d"); 
        if ($exp_date > $date_now) {
           $stat = 'V';
        }else {
            $stat = 'E';
        }

        //update_trn_reg_iso($trn_id, $doc_year, $trn_type);
        approval_trn_reg_iso($trn_id, $doc_year, $simply, $mat_supply, $trn_type);
        approval_stat_reg_iso($trn_id, $doc_year, $simply, $stat);

        $email_list_stat    = array();
        $mnu_obj = "dociso";
        $query_iso  = get_user_iso_mail($id_vendor, $mnu_obj);
        //$rowiso     = mysqli_fetch_assoc($query_iso);

        while ($rowiso = mysqli_fetch_assoc($query_iso)) {
            $email['email']     = $rowiso['username'];
            $email['id_vendor'] = $rowiso['id_vendor'];
            $email['nm_vendor'] = $rowiso['nm_vendor'];
            $email['trn_id']    = $trn_id;
            $email['doc_year']  = $doc_year;
            $email['trn_type']  = $trn_type;
            $email['mailing']   = 'To';

            if (filter_var($email['email'], FILTER_VALIDATE_EMAIL)){
                $email['valid'] = 'Valid';
            } else {
                $email['valid'] = 'Invalid';
            }
            $email_list_stat[] = $email;
        }

        $query_cc   = get_all_user_iso_mail($id_vendor, $mnu_obj);

        while ($row_cc = mysqli_fetch_assoc($query_cc)) {
            $email['email']     = $row_cc['username'];
            $email['name']      = $row_cc['nm_user'];
            $email['role']      = $row_cc['role'];
            $email['id_vendor'] = $row_cc['id_vendor'];
            $email['nm_vendor'] = $row_cc['nm_vendor'];
            $email['trn_id']    = $trn_id;
            $email['doc_year']  = $doc_year;
            $email['trn_type']  = $trn_type;
            $email['mailing']   = 'Cc';
            if (filter_var($email['email'], FILTER_VALIDATE_EMAIL)){
                $email['valid'] = 'Valid';
            } else {
                $email['valid'] = 'Invalid';
            }
            $email_list_stat[] = $email;
        }
            
        
        $count_email_list  = count($email_list_stat); 
        $count_valid_email = array_count_values(array_column($email_list_stat, 'valid'))['Valid'];

        //$trn_detail = 'Approval from '.$email['email'];

        if ($count_email_list == $count_valid_email){

            $msg = mail_iso_once($email_list_stat[0]);
            //$msg = 'success';
                    
            if($msg == 'success'){
                insert_iso_log($trn_id, $doc_year, $id_user, $trn_type, $trn_date, $trn_time, $ip_addr, $trn_detail);
            }

            echo '
            <script>
            swal({
                title: "Success!",
                text: "Success approve document",
                type: "success",
                customClass: \'swal-wide\',
                allowOutsideClick: false
            })
                .then(function() {
                window.location = (\'../view/home.php?'.token().'mnu=isoreview&trn_id='.$trn_id.'&doc_year='.$doc_year.''.token2().'\');
            });
            
            </script>
            ';

        } else {

            /*
            echo '
                <script>

                    swal({
                        title:"Error",
                        text: "Cannot approve caused by invalid email receiver",
                        type: "warning",
                        allowOutsideClick: false
                    });
                        
                </script>
            ';
            */
        ?>

            <div class="container">
                <!-- UPLOAD MODAL -->
                <div class="modal fade" id="modal-error" role="dialog">
                    <div class="modal-dialog">
                    
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header bg-red">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Error</h4>
                            </div>
                            <div class="modal-body">
                                <p><b>Cannot Release caused by invalid email!</b></p>
                                
                                <div class="box box-danger">
                                    
                                    <!-- /.box-header -->
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Email (username)</th>
                                                    <th>Name</th>
                                                    <th>Valid Email</th>
                                                </tr>
                                                <?php
                                                    
                                                    $no = 1;
                                                    for($x = 0; $x < $count_email_list; $x++) {
                                                        if ($email_list_stat[$x]['valid'] == 'Valid') {
                                                            $valid = '<span class="label label-success">'.$email_list_stat[$x]['valid'].'</span>';
                                                        } else {
                                                            $valid = '<span class="label label-danger">'.$email_list_stat[$x]['valid'].'</span>';
                                                        }
        
                                                ?>
                                                <tr>
                                                    <td><?php echo $no; ?></td>
                                                    <td><?php echo $email_list_stat[$x]['email']." [".$email_list_stat[$x]['mailing']."]"; ?></td>
                                                    <td><?php echo $email_list_stat[$x]['name']; ?></td>
                                                    <td><?php echo $valid; ?></td>
                                                </tr>
                                                <?php
                                                        $no++;
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
                            </div>
                                
                        </div>
                        
                    </div>
                </div>
            </div>
               
            <script>  
                $("#modal-error").modal('show');
            </script>

        <?php
        }
        
    } elseif (isset($_POST['reject_doc'])){
       
        $trn_id     = $_POST['trn_id'];
        $doc_year   = $_POST['doc_year'];
        $trn_type   = 'C';

        $mat_supply = $_POST['mat_supply'];

        $exp_date_sp   = explode("/", $_POST['exp_date']);
        $exp_date_fm   = $exp_date_sp[2]."-".$exp_date_sp[1]."-".$exp_date_sp[0];
        $exp_date      = $exp_date_fm; //check expire date with d-date

        if ($_POST['simplf'] == "on") {
            $simply      = 'X';
        } else {
            $simply      = '';
        }

        $date_now = date("Y-m-d"); 
        if ($exp_date > $date_now) {
           $stat = 'V';
        }else {
            $stat = 'E';
        }
        
        //update_trn_reg_iso($trn_id, $doc_year, $trn_type);
        approval_trn_reg_iso($trn_id, $doc_year, $simply, $mat_supply, $trn_type);
        approval_stat_reg_iso($trn_id, $doc_year, $simply, $stat);      

        $email_list_stat    = array();
        $mnu_obj            = "dociso";
        $query_iso          = get_user_iso_mail($id_vendor, $mnu_obj);
        //$rowiso     = mysqli_fetch_assoc($query_iso);

        while ($rowiso = mysqli_fetch_assoc($query_iso)) {
            $email['email']     = $rowiso['username'];
            $email['id_vendor'] = $rowiso['id_vendor'];
            $email['nm_vendor'] = $rowiso['nm_vendor'];
            $email['trn_id']    = $trn_id;
            $email['doc_year']  = $doc_year;
            $email['trn_type']  = $trn_type;
            $trn_detail = 'Rejected from '.$email['email'];
            $email['mailing']   = 'To';

            if (filter_var($email['email'], FILTER_VALIDATE_EMAIL)){
                $email['valid'] = 'Valid';
            } else {
                $email['valid'] = 'Invalid';
            }
            $email_list_stat[] = $email;
        }

        $query_cc   = get_all_user_iso_mail($id_vendor, $mnu_obj);
            //$row_cc     = mysqli_fetch_assoc($query_cc);

        while ($row_cc = mysqli_fetch_assoc($query_cc)) {
            $email['email']     = $row_cc['username'];
            $email['name']      = $row_cc['nm_user'];
            $email['role']      = $row_cc['role'];
            $email['id_vendor'] = $row_cc['id_vendor'];
            $email['nm_vendor'] = $row_cc['nm_vendor'];
            $email['trn_id']    = $trn_id;
            $email['doc_year']  = $doc_year;
            $email['trn_type']  = $trn_type;
            $email['mailing']   = 'Cc';
            if (filter_var($email['email'], FILTER_VALIDATE_EMAIL)){
                $email['valid'] = 'Valid';
            } else {
                $email['valid'] = 'Invalid';
            }
            $email_list_stat[] = $email;
        }
            
        $count_email_list  = count($email_list_stat); 
        $count_valid_email = array_count_values(array_column($email_list_stat, 'valid'))['Valid'];

        if ($count_email_list == $count_valid_email){

            $msg = mail_iso_once($email_list_stat[0]);
            //$msg = 'success';

            if($msg == 'success'){
                insert_iso_log($trn_id, $doc_year, $id_user, $trn_type, $trn_date, $trn_time, $ip_addr, $trn_detail);
            }

            echo '
            <script>
            swal({
                title: "Success!",
                text: "Success reject document",
                type: "success",
                customClass: \'swal-wide\',
                allowOutsideClick: false
            })
                .then(function() {
                window.location = (\'../view/home.php?'.token().'mnu=isoreview&trn_id='.$trn_id.'&doc_year='.$doc_year.''.token2().'\');
            });
            
            </script>
            ';
            
        } else {

            /*
            echo '
                <script>

                    swal({
                        title:"Error",
                        text: "Cannot reject caused by invalid email receiver",
                        type: "warning",
                        allowOutsideClick: false
                    });
                        
                </script>
            ';
            */
        ?>

            <div class="container">
                <!-- UPLOAD MODAL -->
                <div class="modal fade" id="modal-error" role="dialog">
                    <div class="modal-dialog">
                    
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header bg-red">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Error</h4>
                            </div>
                            <div class="modal-body">
                                <p><b>Cannot Reject caused by invalid email!</b></p>
                                
                                <div class="box box-danger">
                                    
                                    <!-- /.box-header -->
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Email (username)</th>
                                                    <th>Name</th>
                                                    <th>Valid Email</th>
                                                </tr>
                                                <?php
                                                    
                                                    $no = 1;
                                                    for($x = 0; $x < $count_email_list; $x++) {
                                                        if ($email_list_stat[$x]['valid'] == 'Valid') {
                                                            $valid = '<span class="label label-success">'.$email_list_stat[$x]['valid'].'</span>';
                                                        } else {
                                                            $valid = '<span class="label label-danger">'.$email_list_stat[$x]['valid'].'</span>';
                                                        }
        
                                                ?>
                                                <tr>
                                                    <td><?php echo $no; ?></td>
                                                    <td><?php echo $email_list_stat[$x]['email']." [".$email_list_stat[$x]['mailing']."]"; ?></td>
                                                    <td><?php echo $email_list_stat[$x]['name']; ?></td>
                                                    <td><?php echo $valid; ?></td>
                                                </tr>
                                                <?php
                                                        $no++;
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
                            </div>
                            
                        </div>
                    
                    </div>
                </div>
            </div>
               
            <script>  
                $("#modal-error").modal('show');
            </script>

        <?php

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

        <script>
            function myLoader(){

                swal({
                    title: 'Transaction Progress',
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    onOpen: function () {
                        swal.showLoading()
                    }
                })

            }

        </script>

        <script>
            function uppercase(elemID){
                var txt = document.getElementById(elemID);
                txt.value = txt.value.toUpperCase();
            }
        </script>

    </body>
</html>