<?php
    //include "../conn/conn_proc.php";
    include "dociso-query.php";
    include "project_mgt/project-mgt-query.php";
    
?>

<div class="box-header">
    <h3 class="box-title">Renewal Document ISO</h3>   

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

        if ($row['stat'] == 'V') {

            $stat = '<span class="label label-success">Valid</span>';
        } else {
            $stat = '<span class="label label-danger">Expired</span>';
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

        if ($row['uom'] == "M"){
            $measure = "Months";
        } elseif($row['uom'] == "D"){
            $measure = "Days";
        } elseif($row['uom'] == "Y"){
            $measure = "Year";
        }
    ?>

    <!-- form start -->
    <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">

        <input type="hidden" name ="trn_id" value ="<?php echo $trn_id; ?>" />
        <input type="hidden" name ="doc_year" value ="<?php echo $doc_year; ?>" />
        <input type="hidden" name ="id_vendor" value ="<?php echo $row['id_vendor']; ?>" />
        <input type="hidden" name ="mat_supply" value ="<?php echo $row['mat_supply']; ?>" />
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

        <div class="form-group">
            <label>Material Supply</label> 
            <select class="form-control selectpicker" name="" data-live-search="true" required>
                <option value="<?php echo $row['mat_supply'] ; ?>"><?php echo $row['mat_supply'] ; ?></option>
            </select>
        </div>  
        <div class="checkbox">
            <label>
                <input type="checkbox" name="simply" <?php echo $simplify; ?> > Simplikasi
            </label>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">ISO Certified Number</label>
            <input type="text" class="form-control" name = "cert_num" value = "<?php echo $row['cert_num'] ; ?>" id="exampleInputEmail1" placeholder="ISO Certified Number">
        </div>
        <div class="form-group">
            <label>ISO Certified Date</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control" name="cert_date" value = "<?php echo $row['cert_date'] ; ?>" data-inputmask="'alias': 'dd.mm.yyyy'" data-mask/>
            </div><!-- /.input group -->
        </div><!-- /.form group -->
        <div class="form-group">
            <label>Certified</label>
            <select class="form-control selectpicker" name="cert_id" data-live-search="true">
                <?php   

                    $query_exec1 = get_all_mstcert_data();
                    while ($row1 = mysqli_fetch_assoc($query_exec1)) {
                        
                        $cert_id   = $row1['cert_id'];
                        $cert_name = $row1['cert_name'];

                        if($cert_id == $row['cert_id']) { $select = 'selected';} else {$select = '';}

                        echo "<option value=".$row1['cert_id']." $select>".$row1['cert_name']."</option>";
                        
                    }
                ?>
            </select>
        </div>  
        <div class="form-group">
            <label>ISO Type</label>
            <select class="form-control selectpicker" name="iso_type_id" data-live-search="true" >
                <option value="">-</option>
                <?php   

                    $query_exec1 = get_all_mstiso_data();
                    while ($row1 = mysqli_fetch_assoc($query_exec1)) {
                        
                        $iso_type_id   = $row1['iso_type_id'];
                        $iso_type_name = $row1['iso_type_name'];

                        if($iso_type_id == $row['iso_type_id']) { $select = 'selected';} else {$select = '';}
                        echo "<option value=".$row1['iso_type_id']." $select>".$row1['iso_type_name']."</option>";
                        
                    }
                ?>
            </select>
        </div>  

        <div class="form-group">
            <label>ISO Expired Date</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control" name="exp_date" value = "<?php echo $row['exp_date'] ; ?>" data-inputmask="'alias': 'dd.mm.yyyy'" data-mask />
            </div>
        </div>
        
        <div class="form-group">
            <label>Notify Before</label>
            <select class="form-control selectpicker" name="notif_id" data-live-search="true" disabled> 
		      	<option value="<?php echo $notif_id; ?>"><?php echo $row['notif_before']." ".$measure; ?></option>
            </select>
        </div> 

        <div class="form-group">
            <label>Remarks</label>
            <textarea class="form-control" rows="3" name="remark" placeholder="Enter ..." ><?php echo $row['remark']; ?></textarea>
        </div>

        <div class="form-group">
            <label for="">Last Document</label>
            <a href="DATA_DOCISO/viewpdf.php?id=<?php echo $row['id_vendor'];?>&nm=<?php echo $row['doc_path']; ?>" class="btn btn-flat" target="_blank" data-toggle='tooltip' title='click to preview' >
                <i class="fa fa-file"></i><label for="exampleInputFile">&nbsp; Click to Preview (<?php echo $row['doc_path']; ?>)</label>
            </a>
           
        </div>

        <div class="form-group">
            <label for="">File input</label>
            <input type='file' id='file' name='doc_iso' accept='.pdf' onchange='ValidateSize(this)'>
            <p class="help-block">upload ISO pdf file</p>
        </div>

        <div class="box-footer">
            <button type="submit" name="renew_doc" class="btn btn-warning">Renew</button>
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

            $cert_date_sp   = explode(".", $_POST['cert_date']);
            $cert_date_fm   = $cert_date_sp[2]."-".$cert_date_sp[1]."-".$cert_date_sp[0];
            $cert_date      = $cert_date_fm;


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

            $cert_id        = $_POST['cert_id']; 
            $iso_type_id    = $_POST['iso_type_id']; 

            $exp_date_sp   = explode(".", $_POST['exp_date']);
            $exp_date_fm   = $exp_date_sp[2]."-".$exp_date_sp[1]."-".$exp_date_sp[0];
            $exp_date      = $exp_date_fm; //check expire date with d-date
            $notif         = '-'.$notif_before.' '.$measure;
            $notify_date   = date('Y-m-d', strtotime($exp_date.$notif));

            $stat           = "V"; //check status
            $remark         = $_POST['remark'];
            $trn_type       = "U"; //"submitted"
            $notif_id       = $_POST['notif_id'];
            $id_user        = $_SESSION['id_user'];

            $upload_array = array();
            $upld_count = count($_FILES['doc_iso']['tmp_name']);
            for ($x = 0; $x < $upld_count; $x++){
                if ($_FILES['doc_iso']['tmp_name'][$x] != ""){
                    array_push($upload_array, '$x');
                }
            }

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

                $temp = explode(".", $_FILES["doc_iso"]["name"]);
                $newfilename = $cert_num ."_".$cert_date."_".$id_vendor.'.' . end($temp);
                
                if (move_uploaded_file($file_tmp,"$folder_iso/$id_vendor/" . $newfilename)){
                    $doc_path    = $newfilename;
                    $version_n   = intval($version_count_n) + 1;
                } else {
                    $doc_path    ="";
                    $version_n   = "";
                }       
            }
            
            update_regiso_data( $trn_id,
                                    $doc_year,
                                    $id_vendor, 
                                    $mat_supply,
                                    $simply,
                                    $cert_num,
                                    $cert_date,
                                    $cert_id,
                                    $iso_type_id,
                                    $exp_date,
                                    $stat,
                                    $doc_path,
                                    $remark,
                                    $trn_type,
                                    $notif_id,
                                    $notify_date,
                                    $id_user);

                insert_iso_log($trn_id, $doc_year, $id_user, $trn_type, $trn_date, $trn_time, $trn_detail);
                                        
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
                    window.location = (\'../view/home.php?mnu=isoreview&trn_id='.$trn_id.'&doc_year='.$doc_year.'\'); 
                });
                
                </script>
                ';
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

    </body>
</html>