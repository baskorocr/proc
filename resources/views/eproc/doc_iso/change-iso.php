<?php
    //include "../conn/conn_proc.php";
    include "dociso-query.php";
    include "project_mgt/project-mgt-query.php";
    include "dociso-func.php";
    
?>

<div class="box-header">
    <h3 class="box-title">Edit Document ISO</h3>   
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

        if($role == 'vendor') {
            $query_exec = get_all_iso_data_by_vendor_trn_id($vendor_id, $trn_id, $doc_year);
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

        /*
        if ($row['uom'] == "M"){
            $measure = "Months";
        } elseif($row['uom'] == "D"){
            $measure = "Days";
        } elseif($row['uom'] == "Y"){
            $measure = "Year";
        }
        */
    ?>

    <!-- form start -->
    <form role=form name="myForm" id="myForm" onSubmit="return myLoader()" action="" method="post" enctype="multipart/form-data">

        <input type="hidden" name ="trn_id" value ="<?php echo $trn_id; ?>" />
        <input type="hidden" name ="doc_year" value ="<?php echo $doc_year; ?>" />
        <input type="hidden" name ="id_vendor" value ="<?php echo $row['id_vendor']; ?>" />
        <input type="hidden" name ="mat_supply" value ="<?php echo $row['mat_supply']; ?>" />
        <input type="hidden" name ="notif_id" value ="<?php echo $row['notif_id']; ?>" />
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
            <select class="form-control selectpicker" data-live-search="true" required disabled>
                <option value='<?php echo $row['id_vendor']; ?>'><?php echo $row['id_vendor']." - ".$row['nm_vendor']; ?></option>  
            </select>
        </div>

        <!--
        <div class="form-group">
            <label>Material Supply</label> 
            <select class="form-control selectpicker" name="" data-live-search="true" required>
                <option value="<?php //echo $row['mat_supply'] ; ?>"><?php //echo $row['mat_supply'] ; ?></option>
            </select>
        </div>  
        --->

        <?php
            if($role != 'vendor') 
            {
        ?>
        <div class="form-group">
            <label>Material Supply</label>
            <input class="form-control" type="text" value="<?php echo $row['mat_supply'] ; ?>" name="mat_supply" placeholder="OHP, etc." id="mat_supp_id" onkeyup="uppercase('mat_supp_id')" required>
            <!--
            <select class="form-control selectpicker" name="mat_supply" data-live-search="true" required>
                <option value="OHP">OHP</option>
            </select>
            -->
        </div>  
        <?php  
            }  
        ?> 

        <?php 
            if ($role != "vendor") {
                $check  = "checked";    
        ?>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="simply" <?php echo $check; ?> disabled> Simplikasi
                </label>
            </div>
        <?php 
            } 
        ?>

        <!--
        <div class="form-group">
            <label>Certified</label>
            <select class="form-control selectpicker" name="cert_id" data-live-search="true">
            -->
                <?php   
                    /*
                    $query_exec1 = get_all_mstcert_data();
                    while ($row1 = mysqli_fetch_assoc($query_exec1)) {
                        
                        $cert_id   = $row1['cert_id'];
                        $cert_name = $row1['cert_name'];

                        if($cert_id == $row['cert_id']) { $select = 'selected';} else {$select = '';}

                        echo "<option value=".$row1['cert_id']." $select>".$row1['cert_name']."</option>";
                        
                    }
                    */
                ?>
                <!--
            </select>
        </div>  
        -->

        <div class="form-group">
            <label>Certified</label>
            <input class="form-control" type="text" value="<?php echo $row['cert_name'] ; ?>" name="cert_name" placeholder="BVCH, TUV, etc" id="cert_name_id" onkeyup="uppercase('cert_name_id')" disabled>
        </div>  
        
        <!--
        <div class="form-group">
            <label>ISO Type</label>
            <select class="form-control selectpicker" name="iso_type_id" data-live-search="true" >
                <option value="">-</option>
        -->
                <?php   

                    /*
                    $query_exec1 = get_all_mstiso_data();
                    while ($row1 = mysqli_fetch_assoc($query_exec1)) {
                        
                        $iso_type_id   = $row1['iso_type_id'];
                        $iso_type_name = $row1['iso_type_name'];

                        if($iso_type_id == $row['iso_type_id']) { $select = 'selected';} else {$select = '';}
                        echo "<option value=".$row1['iso_type_id']." $select>".$row1['iso_type_name']."</option>";
                        
                    }
                    */
                ?>
        <!--        
            </select>
        </div>
        -->

        <div class="form-group">
            <label>ISO Type</label>
            <input class="form-control" type="text" value="<?php echo $row['iso_type_name'] ; ?>" name="iso_type_name" placeholder="" id="iso_name_id" onkeyup="uppercase('iso_name_id')" disabled>
            <!--
            <select class="form-control selectpicker" name="iso_type_id" data-live-search="true">
                <option value="">-</option>
		      	<?php   
                    /*
                    $query_exec1 = get_all_mstiso_data();
                    while ($row1 = mysqli_fetch_assoc($query_exec1)) {
                        
                        $iso_type_id   = $row1['iso_type_id'];
                        $iso_type_name = $row1['iso_type_name'];

                        echo "<option value=".$row1['iso_type_id'].">".$row1['iso_type_name']."</option>";
                        
                    }
                    */
                ?>
            </select>
            -->
        </div>  

        <div class="form-group">
            <label for="exampleInputEmail1">ISO Certified Number</label>
            <input type="text" class="form-control" name = "cert_num" value = "<?php echo $row['cert_num'] ; ?>" placeholder="ISO Certified Number" id="iso_number_id" onkeyup="uppercase('iso_number_id')" disabled>
        </div>
        
        <!--
        <div class="form-group">
            <label>ISO Certified Date</label>
            <input type="date" class="form-control" name="cert_date" id="cert-date" value = "<?php //echo $row['cert_date_us'] ; ?>" required/>
        </div>
        -->

        <div class="form-group">
            <label>ISO Certified Date</label> &nbsp;<span id='message1'></span>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" id="cert-date" name="cert_date" class="form-control datepicker" autocomplete="off" value = "<?php echo $row['cert_date'] ; ?>" disabled/>
            </div>
        </div>
        
        <!--
        <div class="form-group">
            <label>ISO Expired Date</label> &nbsp;<span id='message'></span>
            <input type="date" class="form-control" name="exp_date" id="exp-date" value = "<?php //echo $row['exp_date_us'] ; ?>" required />
        </div>
        -->

        <div class="form-group">
            <label>ISO Expired Date</label> &nbsp;<span id='message2'></span>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" id="exp-date" name="exp_date" class="form-control datepicker" autocomplete="off" value = "<?php echo $row['exp_date'] ; ?>" disabled />
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
            <textarea class="form-control" rows="3" name="remark" placeholder="Enter ..." disabled ><?php echo $row['remark']; ?></textarea>
        </div>

        <div class="form-group">
            <label for="">Last Document</label>
            <a href="DATA_DOCISO/viewpdf.php?id=<?php echo $row['id_vendor'];?>&nm=<?php echo $row['doc_path']; ?>" class="btn btn-flat" target="_blank" data-toggle='tooltip' title='click to preview' >
                <i class="fa fa-file"></i><label for="exampleInputFile">&nbsp; Click to Preview (<?php echo $row['doc_path']; ?>)</label>
            </a>
           
        </div>

        

        <div class="box-footer">
            <button type="submit" name="change_doc" id="submit-btn" class="btn btn-primary">Approve</button>
            <button type="submit" name="change_doc" id="submit-btn" class="btn btn-primary">Reject</button>
        </div>
        
    </form>

</div>

    <?php
        if (isset($_POST['change_doc'])){

            $trn_id   = $_POST['trn_id'];
            $doc_year = $_POST['doc_year'];

            $trn_date   = date('Y-m-d');
            $trn_time   = date('H:i:s');
            $trn_detail = '';

            $id_vendor      = $_POST['id_vendor'];
            $mat_supply     = $_POST['mat_supply'];
            $folder_iso     = 'DATA_DOCISO';

            if ($_POST['simply'] == "on") {
                $simply      = 'X';
            } else {
                $simply      = '';
            }

            $cert_num       = $_POST['cert_num'];

            
            $cert_date_sp   = explode("/", $_POST['cert_date']);
            $cert_date_fm   = $cert_date_sp[2]."-".$cert_date_sp[1]."-".$cert_date_sp[0];
            $cert_date      = $cert_date_fm;
            
            //$cert_date       = $_POST['cert_date'];

            $query_notif = get_all_mstnotif_data();
            $row_notif = mysqli_fetch_assoc($query_notif);
                        
            $notif_id 	 	= $row_notif['notif_id'];
            $notif_before 	= $row_notif['notif_before'];
            $uom 	        = $row_notif['uom'];

            if ($row_notif['uom'] == "M"){
                $measure = "Months";
            } elseif($row_notif['uom'] == "D"){
                $measure = "Days";
            } elseif($row_notif['uom'] == "Y"){
                $measure = "Years";
            }

            //$cert_id        = $_POST['cert_id']; 
            //$iso_type_id    = $_POST['iso_type_id']; 

            $cert_name        = $_POST['cert_name']; 
            $iso_type_name    = $_POST['iso_type_name'];
            
            $exp_date_sp   = explode("/", $_POST['exp_date']);
            $exp_date_fm   = $exp_date_sp[2]."-".$exp_date_sp[1]."-".$exp_date_sp[0];
            $exp_date      = $exp_date_fm; //check expire date with d-date
            
            //$notif         = '-'.$notif_before.' '.$measure;
            //$notify_date   = date('Y-m-d', strtotime($exp_date.$notif));
            //$exp_date      = $_POST['exp_date'];

            $date_now = date("Y-m-d"); 
            if ($exp_date > $date_now) {
               //$stat = 'V';
               $stat = 'W';
            } else{
                $stat = 'E';
            }
   
            $remark         = $_POST['remark'];
            $trn_type       = "U"; //"submitted"
            $notif_id       = $_POST['notif_id'];
            $id_user        = $_SESSION['id_user'];

            $upload_array = array();
            $upld_count = count($_FILES['doc_iso']['tmp_name']);

            if (!empty($_FILES['doc_iso']['tmp_name'])) {
                for ($x = 0; $x < $upld_count; $x++){
                    if ($_FILES['doc_iso']['tmp_name'][$x] != ""){
                        array_push($upload_array, '$x');
                    }
                }
            }            

            //get emailing data
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

            //$trn_detail = 'Changed from '.$email['email'];
            if ($count_email_list == $count_valid_email){

                //$msg = mailtovendor($email);
                if(count($upload_array) == 0){ //check doc choosen
                    $doc_path = $row['doc_path'];
                }
                else 
                {
                    //create direktori
                    mkdir_r("$folder_iso/$id_vendor",0777);
                    $file_name  = $_FILES['doc_iso']['name'];
                    $file_size  = $_FILES['doc_iso']['size'];
                    $file_tmp   = $_FILES['doc_iso']['tmp_name'];
                    $file_type  = $_FILES['doc_iso']['type'];
                    $cert_date_file  = $cert_date_sp[2].$cert_date_sp[1].$cert_date_sp[0];
                    $temp = explode(".", $_FILES["doc_iso"]["name"]);
                    $newfilename = date('YmdHis').'_'.$cert_num ."_".$cert_date_file."_".$id_vendor.'.' . end($temp);
                    
                    if (move_uploaded_file($file_tmp,"$folder_iso/$id_vendor/" . $newfilename)){
                        $doc_path    = $newfilename;
                        //$version_n   = intval($version_count_n) + 1;
                    } else {
                        $doc_path    ="";
                        //$version_n   = "";
                    } 
                    
                }
                
                
                update_regiso_data( $trn_id,
                                    $doc_year,
                                    $id_vendor, 
                                    $mat_supply,
                                    $simply,
                                    $cert_num,
                                    $cert_date,
                                    $cert_name,
                                    $iso_type_name,
                                    $exp_date,
                                    $stat,
                                    $doc_path,
                                    $remark,
                                    $trn_type,
                                    $id_user);
                                                    

                //loop notif master."<br>";
                $query_notif = get_all_mstnotif_data();
                while ($row_notif = mysqli_fetch_assoc($query_notif)) {
                            
                    $notif_id 	 	= $row_notif['notif_id'];
                    $notif_before 	= $row_notif['notif_before'];
                    $uom 	        = $row_notif['uom'];
                    if ($row_notif['uom'] == "M"){
                        $measure = "Months";
                    } elseif($row_notif['uom'] == "D"){
                        $measure = "Days";
                    } elseif($row_notif['uom'] == "Y"){
                        $measure = "Years";
                    }
                    $notif         = '-'.$notif_before.' '.$measure;
                    $notify_date   = date('Y-m-d', strtotime($exp_date.$notif));
                    //update notif
                    update_notif_iso($trn_id, $doc_year, $notif_id, $notif_before, $uom, $notify_date);
                            
                }
                //end loop
                
                $ip_addr       = ip_detect();
                $trn_detail    = json_encode($email_list_stat);
                $msg = mail_iso_once($email_list_stat[0]);

                //$msg = 'success';
                
                if($msg == 'success'){
                    insert_iso_log($trn_id, $doc_year, $id_user, $trn_type, $trn_date, $trn_time, $ip_addr, $trn_detail);
                }
                
                    echo '
                    <script>
                    swal({
                        title: "Success!",
                        text: "Success update document",
                        type: "success",
                        customClass: \'swal-wide\',
                        allowOutsideClick: false
                    })
                        .then(function() {
                        window.location = (\'../view/home.php?'.token().'mnu=isoreport'.token2().'\');
                    });
                    
                    </script>
                    ';
                

            }
            else 
            {

                /*
                echo '
                <script>

                    swal({
                        title:"Error",
                        text: "Cannot update caused by invalid email receiver",
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
                                    <p><b>Cannot Change caused by invalid email!</b></p>
                                    
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
        <script src="../js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
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

            $(".datepicker").datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true,
            });

        </script>

        <script>
            function uppercase(elemID){
                var txt = document.getElementById(elemID);
                txt.value = txt.value.toUpperCase();
            }
        </script>

        <script>

            function formatDate(date) {
                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2) 
                    month = '0' + month;
                if (day.length < 2) 
                    day = '0' + day;

                //return [year, month, day].join('-');
                return [year+month+day];
            }

            function formatText(myTxt){

                var strArray = myTxt.split("/");
                var year     = strArray[2];
                var month    = strArray[1];
                var day     = strArray[0];

                return [year+month+day];
            }

            var today = new Date();
            var todayDate = formatDate(today);
            //var expdate = document.getElementById('exp-date').value;
            //var todayDate = Date.parse(todayDt);
            //var expDate = Date.parse($('#exp-date').val());
            //var expDate = new Date(document.getElementById('exp-date').value);

            $('#cert-date, #exp-date').on('change', function () {
                var expDate = "";
                var cerDate = "";
                expDate     = formatText(document.getElementById('exp-date').value);
                certDate    = formatText(document.getElementById('cert-date').value);

                //if ( ( $('#exp-date').val() > $('#cert-date').val() ) && ( $('#exp-date').val() > todayDate) ) {  //

                if (expDate != "NaN" && certDate != "NaN") {
                    if ( ( expDate > certDate ) && ( expDate > todayDate) ) {  //
                        $('#message1').html('<i class="fa fa-check-circle-o"></i>').css('color', 'green');
                        $('#message2').html('<i class="fa fa-check-circle-o"></i>').css('color', 'green');
                        //alert(expDate + " " + todayDate + " " + certDate );
                        document.getElementById("submit-btn").disabled = false;
                    } else  {
                        $('#message1').html('<i class="fa fa-exclamation-circle"></i>').css('color', 'red');
                        $('#message2').html('<i class="fa fa-exclamation-circle"></i>').css('color', 'red');
                        document.getElementById("submit-btn").disabled = true;
                        //alert(expDate + " " + todayDate + " " + certDate );
                    } 
                } else {
                    if (certDate == "NaN" ) {
                        $('#message1').html('<i class="fa fa-exclamation-circle"></i>').css('color', 'red');
                        document.getElementById("submit-btn").disabled = true;
                    }
                    if (expDate == "NaN" ) {
                        $('#message2').html('<i class="fa fa-exclamation-circle"></i>').css('color', 'red');
                        document.getElementById("submit-btn").disabled = true;
                    }
                }
            });
        </script> 

    </body>
</html>