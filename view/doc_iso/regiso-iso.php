<?php
    //include "../conn/conn_proc.php";
    include "dociso-query.php";
    include "project_mgt/project-mgt-query.php";
    include "dociso-func.php";
    
?>

<div class="box-header">
    <h3 class="box-title">Register ISO Document</h3>   
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

<div class="box-body table-responsive" >   

     <?php

        $id_user = $_SESSION['id_user'];

        $query = get_vendor_user($id_user);
        $row = mysqli_fetch_assoc($query);
        //$id_vendor  = $row['id_vendor'];
        $data['id_vendor'] = isset($row['id_vendor']) ? $row['id_vendor'] : '';
        $vendor_id = isset($row['id_vendor']) ? $row['id_vendor'] : '';

        $role = $_SESSION['role'];
    ?>                     

    <!-- form start -->
    <form role=form name="myForm" id="myForm" onSubmit="return myLoader()" action="" method="post" enctype="multipart/form-data">
        
        <?php
        if($role == 'vendor') 
        {
            $option = "disabled"; 
        ?>
            <input type="hidden" name ="id_vendor" value ="<?php echo $vendor_id; ?>">
        <?php  
        }  
        ?> 
        
        <div class="form-group">
            <label>Vendor</label>
            <select class="form-control selectpicker" name="id_vendor" data-live-search="true" required <?php echo $option; ?> >
                <?php
                    
                    $query_exec = get_all_active_vendor_data();
     
                    while ($row = mysqli_fetch_assoc($query_exec)) {
                        $id_vendor = $row['id_vendor'];
                        $nm_vendor = $row['nm_vendor'];
                        $alias = $row['allias']; 

                        if ($vendor_id == $id_vendor) { $select = "selected"; } else {$select = "";}
                        echo "<option value='$id_vendor' $select >".$nm_vendor." (".$alias.")</option>";  
                    }
                    
                ?>
            </select>
        </div>
        
        <?php
            if($role != 'vendor') 
            {
        ?>
        <div class="form-group">
            <label>Material Supply</label>
            <input class="form-control" type="text" name="mat_supply" placeholder="OHP, etc." id="mat_supp_id" onkeyup="uppercase('mat_supp_id')" >
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
                    <input type="checkbox" name="simply" <?php echo $check; ?> > Simplikasi
                </label>
            </div>
        <?php 
            } 
        ?>

        <div class="form-group">
            <label>Certified</label>
            <input class="form-control" type="text" name="cert_name" placeholder="BVCH, TUV, etc" id="cert_name_id" onkeyup="uppercase('cert_name_id')" >
            <!--
            <select class="form-control selectpicker" name="cert_id" data-live-search="true">
		      	<?php   
                    /*
                    $query_exec1 = get_all_mstcert_data();
                    while ($row1 = mysqli_fetch_assoc($query_exec1)) {
                        
                        $cert_id   = $row1['cert_id'];
                        $cert_name = $row1['cert_name'];

                        echo "<option value=".$row1['cert_id'].">".$row1['cert_name']."</option>";
                        
                    }
                    */
                ?>
            </select>
            -->
        </div>  

        <div class="form-group">
            <label>ISO Type</label>
            <input class="form-control" type="text" name="iso_type_name" placeholder="" id="iso_name_id" onkeyup="uppercase('iso_name_id')" >
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
            <label for="">ISO Certified Number</label>
            <input type="text" class="form-control"  name="cert_num" placeholder="ISO Certified Number" id="iso_number_id" onkeyup="uppercase('iso_number_id')" required>
        </div>
        
        <div class="form-group">
            <label>ISO Certified Date</label> &nbsp;<span id='message1'></span>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" id="cert-date" name="cert_date" class="form-control datepicker" autocomplete="off"  required/>
            </div>
        </div>
      
        <div class="form-group">
            <label>ISO Expired Date</label> &nbsp;<span id='message2'></span>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" id="exp-date" name="exp_date" class="form-control datepicker" autocomplete="off"  required />
            </div>
        </div>    
        
        <!--
        <div class="form-group">
            <label>Notify Before</label>
                -->
		      	<?php   
                    /*
                    $query_exec1 = get_all_mstnotif_data();
                    while ($row1 = mysqli_fetch_assoc($query_exec1)) {
                        
                        $notif_id 	 	= $row1['notif_id'];
                        $notif_before 	= $row1['notif_before'];
                        $uom 	        = $row1['uom'];

                        if ($row1['uom'] == "M"){
                            $measure = "Months";
                        } elseif($row1['uom'] == "D"){
                            $measure = "Days";
                        } elseif($row1['uom'] == "Y"){
                            $measure = "Year";
                        }

                        //echo "<input type="text" value=".$notif_id.">".$notif_before." ".$measure."</input>";
                        echo "<input type='text' value=".$notif_id.">";
                        
                    }
                    */
                ?>
            

            <?php 
                /*
                $query_exec1    = get_all_mstnotif_data();
                $row1           = mysqli_fetch_assoc($query_exec1);
                $notif_id 	 	= $row1['notif_id'];
                */
            ?>
            <!--
            <input type="hidden" name = "notif_id" class="form-control" value="<?php echo $notif_id; ?>"/>
            
        </div> 
        -->
        
        <div class="form-group">
        <label>Notify Before</label>
            <div class="box ">
        
                <div class="box-body" style="">
                    <div class="table-responsive">

                        <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>Notif ID</th>
                                <th>Notify Sequence</th>
                                <th>Notify Before</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php   
                                $query_exec1 = get_all_mstnotif_data();
                                while ($row1 = mysqli_fetch_assoc($query_exec1)) {
                                    
                                    $notif_id 	 	= $row1['notif_id'];
                                    $notif_seq      = $row1['notif_seq'];
                                    $notif_before 	= $row1['notif_before'];
                                    $uom 	        = $row1['uom'];

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
                                <td><?php echo $notif_seq;?></td>
                                <td><?php echo $notif_before." ".$measure;?></td>   
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
            <textarea class="form-control" name="remark" rows="3" placeholder="Enter ..."></textarea>
        </div>

        <div class="form-group">
            <label for="">File input</label>
            <input type='file' id='file' name='doc_iso' accept='.pdf' onchange='ValidateSize(this)' required>
            <p class="help-block">upload ISO pdf file</p>
        </div>
        
        <?php

            $query_mstnotif = get_all_mstnotif_data();
            $count_mstnotif = mysqli_num_rows($query_mstnotif);

            if($count_mstnotif == 0) {
                $btn_stat = 'disabled';
                $btn_comment = "Master notify termin not defined";
            } else {
                $btn_stat = '';
                $btn_comment = "";
            }
            
        ?>
    
        <div class="box-footer">
            <button type="submit" name="submit-add" id="submit-btn" class="btn btn-primary" <?php echo $btn_stat; ?> onclick="uploadDoc()">
            Submit
            </button>
            <p class="help-block"><?php echo $btn_comment; ?></p>
        </div>
    </form>         
    
    <!--
    <div class="form-group">
        <label>Tanggal:</label>
        <input type="text" name="tanggal" class="form-control datepicker" required/>
    </div>
    -->
            
</div>

<?php 
    if (isset($_POST['submit-add'])){

        $doc_type = 'ISO';
        $doc_year = date('Y');
        $query_numrange = get_number_range($doc_type, $doc_year);
        $row_numrange   = mysqli_fetch_assoc($query_numrange);
        $count_numrange = mysqli_num_rows($query_numrange);

        //echo $count_numrange;
        
        if( $count_numrange == 0){

            echo "<script>
                      swal({
                         title: 'Error',
                         text: 'Please maintain Document Number!',
                         type: 'error',
                         allowOutsideClick: false
                      })
                      .then(function() {
                        window.location = ('../view/home.php?".token()."mnu=regiso".token2()."');
                    });
                  </script>";

            exit; 
        } 

        $trn_id   = $row_numrange['trn_num'];
        $doc_year = $row_numrange['doc_year'];

        $trn_date   = date('Y-m-d');
        $trn_time   = date('H:i:s');
        
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
        
        //$cert_date      = $_POST['cert_date'];

        //$cert_id        = $_POST['cert_id']; 
        $cert_name        = $_POST['cert_name']; 
        //$iso_type_id    = $_POST['iso_type_id']; 
        $iso_type_name    = $_POST['iso_type_name']; 
        
        
        $exp_date_sp   = explode("/", $_POST['exp_date']);
        $exp_date_fm   = $exp_date_sp[2]."-".$exp_date_sp[1]."-".$exp_date_sp[0];
        $exp_date      = $exp_date_fm; //check expire date with d-date
        
        //$exp_date      = $_POST['exp_date'];
        
        $date_now = date("Y-m-d"); 
        
        if ($exp_date > $date_now) {
           $stat = 'W';
        }else {
            $stat = 'E';
        }
        
        $query_check_certnum = get_regiso_data_by_certf_num($id_vendor, $cert_num);
        $cert_num_check = mysqli_num_rows($query_check_certnum);

        if ($cert_num_check >= 1){
            echo "<script>
                      swal({
                         title: 'Error',
                         text: 'Certification Number already exist!',
                         type: 'error',
                         allowOutsideClick: false
                      })
                      .then(function() {
                        window.location = ('../view/home.php?".token()."mnu=regiso".token2()."');
                    });
                  </script>";
            exit;
        }
        //set status to waiting

        //$stat = "";

        $remark         = $_POST['remark'];
        $trn_type       = "S"; 
        //$notif_id       = $_POST['notif_id'];
        $id_user        = $_SESSION['id_user'];

        //get emailing data
        $email_list_stat    = array();
        $mnu_obj            = "dociso";
        $query_iso          = get_user_iso_mail($id_vendor, $mnu_obj);
        //$rowiso     = mysqli_fetch_assoc($query_iso);

        while ($rowiso = mysqli_fetch_assoc($query_iso)) {
            $email['email']     = $rowiso['username'];
            $email['name']      = $rowiso['nm_user'];
            $email['role']      = $rowiso['role'];
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

        $upload_array = array();
        $upld_count = count($_FILES['doc_iso']['tmp_name']);
        for ($x = 0; $x < $upld_count; $x++){
            if ($_FILES['doc_iso']['tmp_name'][$x] != ""){
                array_push($upload_array, '$x');
            }
        }

        if(count($upload_array) == 0){ //check doc choosen

            echo "<script>
                      swal({
                         title: 'Error',
                         text: 'No file choosen!',
                         type: 'error',
                         allowOutsideClick: false
                      })
                  </script>";
      
        }
        else {

            //echo $id_vendor."<br>";
            //echo "Total :".$count_email_list."<br>";
            //echo "Valid :".$count_valid_email."<br>";
            //print_r($email_list_stat);            

            //$trn_detail = 'Submitted from '.$email['email'];

            //get all data email Cc

            if ($count_email_list == $count_valid_email){
                  
                //update number range
                update_number_range($doc_type, $doc_year);

                //create direktori
                mkdir_r("$folder_iso/$id_vendor",0777);

                //$query_exec_data2 = get_doc_ver($id_project_new, $id_product_new, $id_part_new, $id_doc_part_new[$key]);
                //$version_count   = mysqli_fetch_assoc($query_exec_data2);
                //$version_count_n = $version_count['version_n'];

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

                //$msg = mailtovendor($email);

                $ref_doc        = "";
                $ref_doc_year   = "";
                $trn_detail     = json_encode($email_list_stat);

                insert_regiso_data( $trn_id,
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
                                $ref_doc,
								$ref_doc_year,
                                $id_user);
                                
            
                //loop notif master
                
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

                    //insert notif
                    if ( $exp_date > $notify_date ) {
                        insert_notif_iso($trn_id, $doc_year, $notif_id, $notif_before, $uom, $notify_date);
                    }
                }
                //end loop
                
                $ip_addr    = ip_detect();
                $msg        = mail_iso_once($email_list_stat[0]);

                //print_r($email_list_stat[0]);
                //$msg = 'success';
                
                if($msg == 'success'){
                    insert_iso_log($trn_id, $doc_year, $id_user, $trn_type, $trn_date, $trn_time, $ip_addr, $trn_detail);
                }

                echo '
                <script>
                swal({
                    title: "Success!",
                    text: "Success submit document",
                    type: "success",
                    customClass: \'swal-wide\',
                    allowOutsideClick: false
                })
                    .then(function() {
                    window.location = (\'../view/home.php?'.token().'mnu=isoreport'.token2().'\');
                });
                
                </script>
                ';

            } else {

                /*
                echo '
                <script>

                    swal({
                        title:"Error",
                        text: "Cannot register caused by invalid email receiver",
                        type: "warning",
                        allowOutsideClick: false
                    });
                        
                </script>
                ';*/
                
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
                                    <p><b>Cannot Register caused by invalid email!</b></p>
                                    
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
    } 

?>  
        <!-- jQuery 2.0.2 -->
        <script src="../jquery-2/jquery.min.js"></script>
        <!--
        <script src="../footable/jquery-3.5.1.js" type="text/javascript"></script>
        -->
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
      

        <script type="text/javascript">
            //    validasi form (hanya file .xls yang diijinkan)
            function validateForm()
            {
                function hasExtension(inputID, exts) {
                    var fileName = document.getElementById(inputID).value;
                    return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
                }

                if(!hasExtension('data', ['.pdf'])){
                    alert("Only PDF file allowed!");
                    return false;
                } 
                else {
                    swal({
                        title: 'Transaction Process',
                        text: 'Please wait...',
                        allowOutsideClick: false,
                        onOpen: function () {
                            swal.showLoading()
                        }
                    });
                }
                
            }

            $(".datepicker").datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true,
            });
        
        </script>

        <script>
            function uploadDoc() {
            $("#myForm").on("submit", function(e){

                var file = document.getElementById('file');

                // 1 MB = 1048576 this size is in bytes
                if (file && file.size < (1048576 * 5)) {  //5 MB   // 2MB = 2097152

                    //Submit form
                    //alert('ok');
                    swal({
                        title: 'Processing',
                        text: 'Uploading your document...',
                        allowOutsideClick: false,
                        onOpen: function () {
                            swal.showLoading()
                        }
                    })

                } else {

                    e.preventDefault();
                    //Prevent default and display error
                    //alert('ng');
                    swal({
                        title: 'Upload error!',
                        text: 'File(s) are empty or reached maximum size!',
                        type: 'error',
                        allowOutsideClick: false
                    })
                        .then(function () {
                            window.location = ('../view/home.php?'.token().'mnu=regiso'.token2().'/'); 
                        })
                }
            });
        }
        </script>

        <script>
            function ValidateSize(file) {
                var FileSize = file.files[0].size / 1024 / 1024; // in MB
                if (FileSize > 1) {
                    swal({
                        title: 'Maximum file size 1 MB!',
                        text: 'Please compress your document to decrease file size (http://www.freepdfcompressor.com/)',
                        type: 'error',
                        allowOutsideClick: false
                    });
                    $(file).val(''); //for clearing with Jquery
                } else {

                }
            }
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