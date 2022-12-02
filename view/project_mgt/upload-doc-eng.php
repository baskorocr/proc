<?php

require "lib/excel_reader.php";
include "project-mgt-query.php";
include "project-mgt-func.php";

set_time_limit (400);

?>

<div class="box-header">
    <h3 class="box-title">Upload Required Document</h3>
</div><!-- /.box-header -->
<hr style="margin-top: 1px;">

    <!-- form start -->
    <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
    <?php
        $id_user = $_SESSION['id_user'];

        $query = get_vendor_user($id_user);
        $row = mysqli_fetch_assoc($query);
        $id_vendor  = isset($row['id_vendor']) ? $row['id_vendor'] : '';

    ?>
        <div class="box-body">
        <input type="hidden" name ="id_vendor" value="<?php echo $id_vendor; ?>">
            <div class="form-group">
                <label>Choose Project</label>
                    <select class="form-control selectpicker" name="id_project" data-live-search="true" required>
                        <?php      
                             $query_exec1 = get_all_project_vendor_assign($id_vendor);
                            
                            while ($row1 = mysqli_fetch_assoc($query_exec1)) {
                                echo "<option value=".$row1['id_project'].">".$row1['nm_project']."</option>";
                            }      
                        ?>
                    </select>
                    <div class="form-group">
                        <a href =""><button type="submit" id="show-data" name="show-data" class="btn btn-success btn-flat"><i class="fa fa-search"></i> Search</button></a>
                    </div>
            </div>  
    </form>
             
    <?php

        if(isset($_POST['show-data'])){

            $id_project = $_POST['id_project'];
            $doc_type   ='V';
            $id_vendor = $_POST['id_vendor'];

            $query_data = get_project_data_by_id($id_project);
            $row_data = mysqli_fetch_assoc($query_data);

    ?>

    <label>[<?php echo $row_data['nm_project']; ?>]</label>
    <form role=form name="myForm1" id="myForm1" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
        <div class="box box-body box-primary">
        <div class="box-body">
            <input type="hidden" name ="id_project" value="<?php echo $id_project; ?>">
            <input type="hidden" name ="id_vendor" value="<?php echo $id_vendor; ?>">
            <div class="form-group">
                <label>Choose Product - Part</label>
                    <select class="form-control selectpicker" name="prod_part" data-live-search="true" required>
                        <?php      
                            $query_exec_a = get_vendor_prod_part_data($id_project, $doc_type, $id_vendor);
                        
                            while ($row_a = mysqli_fetch_assoc($query_exec_a)) {
                                echo "<option value=".$row_a['id_product']."_".$row_a['id_part'].">(".$row_a['part_num'].") ".$row_a['nm_part']."</option>";
                            }     
                        ?>
                    </select>
                    
                <div class="form-group">
                    <a href =""><button type="submit" id="show-data2" name="show-data2" class="btn btn-flat-sm"><i class="fa fa-search"></i> Search</button></a>
                </div>
            </div> 
        </div>
    </form>

    <?php
        }

    ?>

    <?php

        if(isset($_POST['show-data2'])){

            $id_project = $_POST['id_project'];
            $doc_type   ='V';
            $id_vendor  = $_POST['id_vendor'];

            $data       = explode("_", $_POST['prod_part']);
            $id_product = $data[0];
            $id_part    = $data[1];

            $query_data = get_project_data_by_id($id_project);
            $row_data = mysqli_fetch_assoc($query_data);
    ?>

    <label>[<?php echo $row_data['nm_project']; ?>]</label>
    <form role=form name="myForm1" id="myForm1" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
        <div class="box box-body box-primary">
        <div class="box-body">

            <input type="hidden" name ="id_project" value="<?php echo $id_project; ?>">
            <input type="hidden" name ="id_vendor" value="<?php echo $id_vendor; ?>">

            <div class="form-group">
                <label>Choose Product - Part</label>
                    <select class="form-control selectpicker" name="prod_part" data-live-search="true" required>
                        <?php      
                            $query_exec_a = get_vendor_prod_part_data($id_project, $doc_type, $id_vendor);
                        
                            while ($row_a = mysqli_fetch_assoc($query_exec_a)) {
                                echo "<option value=".$row_a['id_product']."_".$row_a['id_part'].">(".$row_a['part_num'].") ".$row_a['nm_part']."</option>";
                            }     
                        ?>
                    </select>
                    
                <div class="form-group">
                    <a href =""><button type="submit" id="show-data2" name="show-data2" class="btn btn-flat-sm"><i class="fa fa-search"></i> Search</button></a>
                </div>
            </div>  
    </form>

    <form role=form name="myForm2" id="myForm2" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <input type="hidden" name="id_project" value="<?php echo $id_project; ?>"/>
            <input type="hidden" name="id_product" value="<?php echo $id_product; ?>"/>
            <input type="hidden" name="id_part" value="<?php echo $id_part; ?>"/>
            <input type="hidden" name="id_vendor" value="<?php echo $id_vendor; ?>"/>

            <?php
                $query_exec = get_vendor_prod_part_doc_data($id_project, $id_product, $id_part, $doc_type, $id_vendor);
                $row = mysqli_fetch_assoc($query_exec);
                $nm_product_a = $row['nm_product'];
                $nm_part_a = $row['nm_part'];
            ?>

            <label><?php echo $nm_product_a." - ".$nm_part_a; ?></label>
            <hr style="margin-top:-2px;">

        <div class = "table-responsive">
            <table class="table table-bordered table-striped">
                <th>Document name</th>
                <th>Upload File</th>
                <th> Status </th>
                <th>Version</th>
                <th>Upload n-Times</th>

                <?php

                    $doc_arr      = array();
                    $completed_arr  = array();
                    $query_exec_b = get_vendor_prod_part_doc_data($id_project, $id_product, $id_part, $doc_type, $id_vendor);
                    while ($row_b = mysqli_fetch_assoc($query_exec_b)) {

                        $id_doc_part    = $row_b['id_doc_part'];
                        $nm_doc_part    = $row_b['nm_doc_part'];
                        $upload_path    = $row_b['upload_path'];
                        $doc_upl_nm     = $row_b['file_nm'];

                        $ver            = $row_b['version_n'];
                        $upload_n       = $row_b['upload_n'];

                        $nama_data = $row_b['file_nm'];
                        $temp = explode(".", $nama_data);
                        $filename = $temp[0];
                        $pathname = $id_vendor."/".$filename;

                        $data = $row_b['id_project'].",".$row_b['id_product'].",".$row_b['id_part'].",".$row_b['id_doc_part'].",".$id_vendor;

                        if ($upload_path == ""){
                            $stat_check = "<h4><span class='badge bg-red'>No upload</span></h4>";
                            $dis_btn = "";
                            $doc_name = $nm_doc_part.".pdf";

                            $doc_version = "<center>-</center>";
                            $doc_upload = "<center>-</center>";
                            $act    ="disabled";
                        } else {

                            $query_exec3 = get_proj_doc_assign_data_vendor($id_project, $id_product, $id_part, $id_doc_part, $id_vendor);
                            $row3 = mysqli_fetch_assoc($query_exec3);

                            $query_exec4 = get_proj_doc_assign_data_status_vendor($id_project, $id_product, $id_part, $id_doc_part, $id_vendor);
                            $row4 = mysqli_fetch_assoc($query_exec4);

                            $query_exec5 = get_proj_doc_assign_data_status_vendor2($id_project, $id_product, $id_part, $id_doc_part, $id_vendor);
                            $row5 = mysqli_fetch_assoc($query_exec5);

                            $count_row3 = mysql_num_rows($query_exec3);
                            $sum_check_a = $row4['check_status'];
                            $sum_check_b = $row5['check_status_b'];

                            $sum_tobe_checked   = $count_row3 + $count_row3;
                            $sum_checked        = $sum_check_a + $sum_check_b;

                            if ($sum_tobe_checked  == $sum_checked){
                                $stat_check =  "<h4><span class='badge bg-blue'>Completed ($sum_checked/$sum_tobe_checked)</span></h4>";
                                array_push($completed_arr, 'completed');
                                $dis_btn = "style=\"display: none;\" ";
                                $doc_name = "<h4><span class='badge bg-green'>Completed Check</span></h4>"; //$doc_upl_nm
                            } else {
                                $stat_check =  "<a href='home.php?mnu=checkvendview&id_data=".$data."'><h4><span class='badge bg-orange btn-flat'>Uncomplete ($sum_checked/$sum_tobe_checked)</span></h4></a>";
                                $dis_btn = "";
                                $doc_name = $nm_doc_part.".pdf";
                            }

                            $doc_version = "<h4><span class='badge bg-green'>Ver 0".$ver."</span></h4>";
                            $doc_upload  = "<center>$upload_n</center>";
                            $act    ="";
                        }

                ?>

                <tr>
                    <td><label><?php echo $nm_doc_part; ?></label></td>
                    <td><input type='file' id='file' name='doc[]' accept='.pdf, .xls' <?php echo $dis_btn; ?> onchange='ValidateSize(this)' >
                        <!-- id = '<?php echo $id_doc_part; ?>' -->
                        <p class='help-block'><?php echo $doc_name; ?></p>
                    </td>
                    <td><?php echo $stat_check; ?></td>
                    <td>
                        <a href="DATA/viewpdf_2.php?id=<?php echo $id_project;?>&p=<?php echo $pathname; ?>&nm=<?php echo $filename; ?>" class="btn btn-flat <?php echo $act;?>" target="_blank" data-toggle='tooltip' title='click to preview' >
                            <?php echo $doc_version;?>
                        </a>
                    </td>
                    <td><?php echo $doc_upload; ?></td>
                </tr>

                <input type="hidden" name="doc_arr[]" value="<?php echo $id_doc_part; ?>" >

                <?php
                    }
                ?>

            </table>
        </div>
    </div>

        <?php
            if (count($completed_arr) == mysql_num_rows($query_exec_b) ){
                $open_a = "<!--";
                $close_a= "-->";
            }

            echo $open_a;
        ?>

        <div class="box-footer">
            <button type="submit" id="upload" name="upload" class="btn btn-flat btn-primary" onclick="uploadReq()"><i class="fa fa-upload" ></i> Upload</button>
        </div>

        <?php echo $close_a; ?>
    
    </form>

    <?php
        }//if(isset($_POST['show-data2']))
    ?>

    <?php

        if (isset($_POST['upload'])){

            $id_project         = $_POST['id_project'];
            $doc_type           ='V';
            $id_product         = $_POST['id_product'];
            $id_part            = $_POST['id_part'];
            $id_vendor          = $_POST['id_vendor'];
            $id_doc_part_new    = $_POST['doc_arr'];

            $query_exec_data = get_upload_sequence_vendor($id_project, $id_product, $id_part, $id_vendor);
            $upload_count   = mysqli_fetch_assoc($query_exec_data);
            $upload_count_n = $upload_count['upload_n'];
            $upload_n = intval($upload_count_n) + 1;

            $nm_doc_part        = array();

            $upload_array = array();
            $upld_count = count($_FILES['doc']['tmp_name']);
            for ($x = 0; $x < $upld_count; $x++){
                if ($_FILES['doc']['tmp_name'][$x] != ""){
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

            } else {

                $query_exec = get_upload_vendor_data($id_project, $id_product, $id_part, $id_vendor, $doc_type);
                while ($row_exec = mysqli_fetch_assoc($query_exec)) {
                    $product = $row_exec['nm_product'];
                    $part = $row_exec['nm_part'];
                    $doc_part = $row_exec['nm_doc_part'];

                    array_push($nm_doc_part, $doc_part);
                }

                mkdir_r("DATA/$id_project/$id_vendor", 0777);

                foreach ($_FILES['doc']['tmp_name'] as $key => $tmp_name) {

                    $file_name = $_FILES['doc']['name'][$key];
                    $file_size = $_FILES['doc']['size'][$key];
                    $file_tmp = $_FILES['doc']['tmp_name'][$key];
                    $file_type = $_FILES['doc']['type'][$key];

                    if ($file_tmp != "") {

                        /*
                        $query_exec_data = get_upload_sequence2($id_project, $id_product, $id_part, $id_doc_part_new[$key]);
                        $upload_count = mysqli_fetch_assoc($query_exec_data);
                        $upload_count_n = $upload_count['upload_n'];
                        $upload_n = intval($upload_count_n) + 1;
                        */

                        $query_exec_data2 = get_doc_ver_vendor($id_project, $id_product, $id_part, $id_doc_part_new[$key], $id_vendor);
                        $version_count   = mysqli_fetch_assoc($query_exec_data2);
                        $version_count_n = $version_count['version_n'];
                        $version_n      = intval($version_count_n) + 1;

                        $uploader_id = $_SESSION['id_user'];

                        $query = get_group_all_join_proj_prod_part_data3($id_project, $id_product, $id_part, $doc_type, $id_vendor);
                        $rows = mysqli_fetch_assoc($query);
                        $nm_product_file = $rows['nm_product'];
                        $nm_part_file = $rows['nm_part'];
                        $nm_vendor = $rows['nm_vendor'];
                        $nm_vendor_file = preg_replace('/\s+/', '-', $nm_vendor);

                        $temp = explode(".", $_FILES["doc"]["name"][$key]);
                        $newfilename = $nm_vendor_file . "_" . $nm_product_file . "_" . $nm_part_file . "_" . $nm_doc_part[$key] . "_ver" . $version_n  . '.' . end($temp);

                        /*
                            nama product pasti nama file di array
                            sehingga nama nya akan selalu restart ke product 1
                            begitu juga nama part
                            pasti akan selalu restart ke part A
                        */

                        if (move_uploaded_file($file_tmp, "DATA/$id_project/$id_vendor/" . $newfilename)) {
                            $upload_path = "DATA/$id_project/$id_vendor/" . $newfilename;
                            //$upload_n = intval($upload_count_n) + 1;
                            //$version_n = $upload_n;
                            $upload_n       = intval($upload_count_n) + 1;
                            $version_n      = intval($version_count_n) + 1;
                        } else {
                            $upload_path = "";
                            //$upload_n = "";
                            //$version_n = $upload_n;
                            $upload_n       = "";
                            $version_n      = "";
                        }

                        update_vendor_doc_upload($id_project, $id_product, $id_part, $id_doc_part_new[$key], $newfilename, $upload_n, $version_n, $uploader_id, $upload_path, $id_vendor);

                    }//if ($file_tmp  != "")

                }//foreach($_FILES['doc']['tmp_name'] as $key => $tmp_name)

                //echo "<script> alert('Success uploaded document');</script>";

                echo '
            <script>
                swal({
                    title: "Success!",
                    text: "Success uploaded document!",
                    type: "success",
                    showLoaderOnConfirm: true,
                    customClass: \'swal-wide\',
                    allowOutsideClick: true
                });
            </script>
            ';

            }//else if doc check

        }//if upload

    ?>


        <!-- jQuery 2.0.2 
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        -->
         <script src="../jquery-2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="../js/AdminLTE/app.js" type="text/javascript"></script>

        <script type="text/javascript">
        //    validasi form (hanya file .xls yang diijinkan)
            function validateForm()
            {
                function hasExtension(inputID, exts) {
                    var fileName = document.getElementById(inputID).value;
                    return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
                }
         
                if(!hasExtension('vendordata', ['.pdf']) || !hasExtension('vendordata', ['.xls']) ){
                    alert("Only PDF or XLS file allowed!");
                    return false;
                }
            }
        </script>

    <script>
    function uploadReq() {
        $("#myForm2").on("submit", function(e){

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
                        window.location = ('../view/home.php?mnu=uplddoceng');
                    })
            }
        });
    }
</script>

    <script>
        function ValidateSize(file) {
            var FileSize = file.files[0].size / 1024 / 1024; // in MB
            if (FileSize > 5) {
                swal({
                    title: 'Maximum file size 5 MB!',
                    text: 'Please compress your document to decrease file size (http://www.freepdfcompressor.com/)',
                    type: 'error',
                    allowOutsideClick: false
                });
                $(file).val(''); //for clearing with Jquery
            } else {

            }
        }
    </script>

    </body>
</html>