<?php

//require "lib/excel_reader.php";
include "project-mgt-query.php";
include "project-mgt-func.php";
include "../lib/function.php";

set_time_limit (400);


?>

<div class="box-header">
    <h3 class="box-title">Upload Document Project</h3>
</div><!-- /.box-header -->
<hr style="margin-top: 1px;">

    <!-- form start -->
<div class="box-body">
  
    <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Choose Project</label>
                <select class="form-control selectpicker" name="id_project" data-live-search="true" required>
                    <?php      
                        //list project yang sudah assign product
                        $query_exec1 = get_assigned_project_data();
                        
                        while ($row1 = mysqli_fetch_assoc($query_exec1)) {
                            echo "<option value=".$row1['id_project'].">".$row1['nm_project']."</option>";
                        }     
                    ?>
                </select>
                <br>
                <button type="submit" id="show-data" name="show-data" class="btn btn-success btn-flat">
                <i class="fa fa-search"></i> Search
                </button>
        </div> 
    </form> 
    <br>

    <?php

        if (isset($_POST['show-data'])){

            $id_project = $_POST['id_project'];
            $doc_type   ='P';

            $query_exec = get_project_data_by_id($id_project);
            $row = mysqli_fetch_assoc($query_exec);
            $nm_project_a = $row['nm_project'];

    ?>  
        <label>Project Name: [<?php echo $nm_project_a; ?>]</label>
        <form role=form name="myForm1" id="myForm1" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name ="id_project" value="<?php echo $id_project; ?>">
            <div class="box box-body box-primary">
                <div class="form-group">
                <label>Choose Product - Part</label>

                <select class="form-control selectpicker" name="prod_part" data-live-search="true" required>
                <?php      
                    $query_exec_a = get_group_all_join_prod_part_data($id_project, $doc_type); 
                        
                    while ($row_a = mysqli_fetch_assoc($query_exec_a)) {
                        echo "<option value=".$row_a['id_product']."_".$row_a['id_part'].">".$row_a['nm_product']." - ".$row_a['nm_part']."</option>";
                    }     
                ?>
                </select>
                
                <div class="form-group">
                    <a href =""><button type="submit" id="show-data2" name="show-data2" class="btn btn-flat-sm"><i class="fa fa-search"></i> Search</button></a>
                </div>
            </div>  

        </form>


    <?php
        }


    ?>

    <?php 
        $col = array();
        $query_exec2 = get_doc_type_data_all("P");
        while ($row2 = mysqli_fetch_assoc($query_exec2)) {
            $col[] = $row2['nm_doc_part'];

            $doc_type = $row2['doc_type'];
            $nm_doc  = $row2['nm_doc_part'];
            $assigned  = $row2['assigned'];

        }

    if (isset($_POST['show-data2']))
    {
        $id_project = $_POST['id_project'];
        $doc_type   ='P';

        $data       = explode("_", $_POST['prod_part']);
        $id_product = $data[0];
        $id_part    = $data[1];

        $query_exec = get_group_all_join_proj_prod_part_data($id_project, $id_product, $id_part, $doc_type);
        $row = mysqli_fetch_assoc($query_exec);
        $nm_project_a = $row['nm_project'];

    ?>
<label>Project Name: [<?php echo $nm_project_a; ?>]</label>
<form role=form name="myForm2" id="myForm2" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">

<div class="box box-body box-primary">
    <div class="form-group">
    <input type="hidden" name ="id_project" value="<?php echo $id_project; ?>">
    <input type ="hidden" name ="id_product" value="<?php echo $id_product; ?>">
    <input type ="hidden" name ="id_part" value="<?php echo $id_part; ?>">

        <label>Choose Product - Part</label>
            <select class="form-control selectpicker" name="prod_part" data-live-search="true" required>
                <?php
                    $query_exec_a = get_group_all_join_prod_part_data($id_project, $doc_type);

                    while ($row_a = mysqli_fetch_assoc($query_exec_a)) {
                        echo "<option value=".$row_a['id_product']."_".$row_a['id_part'].">".$row_a['nm_product']." - ".$row_a['nm_part']."</option>";
                    }
                ?>
            </select>
        <div class="form-group">
            <a href =""><button type="submit" id="show-data2" name="show-data2" class="btn btn-flat-sm"><i class="fa fa-search"></i> Search</button></a>
        </div>
    </div>

    <div class="form-group">

        <input type="hidden" name="id_project" value="<?php echo $id_project; ?>"/>

        <?php
            $query_exec = get_group_all_join_proj_prod_part_data($id_project, $id_product, $id_part, $doc_type);
            $row = mysqli_fetch_assoc($query_exec);
            $nm_project_a = $row['nm_project'];
            $nm_product_a = $row['nm_product'];
            $nm_part_a = $row['nm_part'];
        ?>

        <label><?php echo $nm_product_a." - ".$nm_part_a; ?></label>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <th>Document name</th>
            <th>Upload File</th>
            <th> Status </th>
            <th>Required Type</th>
            <th>Version</th>
            <th>Upload n-Times</th>

            <?php if ($_SESSION['role'] == "admin") { ?>
            <th>Permission</th>
            <?php } ?>

        <?php

            $doc_arr        = array();
            $data_arr       = array();
            $checked_arr    = array();
            $completed_arr  = array();

            $query_exec_b = get_proj_assign_data_all3($id_project, $id_product, $id_part, $doc_type); //Procurement
            while ($row_b = mysqli_fetch_assoc($query_exec_b)) {

                $id_doc_part    = $row_b['id_doc_part'];
                $nm_doc_part    = $row_b['nm_doc_part'];
                $required       = $row_b['doc_required'];
                $upload_path    = $row_b['upload_path'];
                $upload_n       = $row_b['upload_n'];
                $permit_n       = $row_b['permit_n'];
                $doc_upl_nm     = $row_b['file_nm'];
                $ver            = $row_b['version_n'];

                $idproj = $row_b['id_project'];
                $idprod = $row_b['id_product'];
                $idpart = $row_b['id_part'];

                $nama_data = $row_b['file_nm'];
                $temp = explode(".", $nama_data);
                $filename = $temp[0];

                $data = $row_b['id_project'].",".$row_b['id_product'].",".$row_b['id_part'].",".$row_b['id_doc_part'];
                $dataproj =  $row_b['id_project'].",".$row_b['id_product'].",".$row_b['id_part'];

                if ($required == "M"){
                    $doc_required = "<h4><label class='label label-success text-md-center'>Mandatory</label></h4>";
                } elseif ($required == "Y") {
                    $doc_required = "<h4><label class='label label-primary text-md-center'>Required</label></h4>";
                } elseif ($required == "N") {
                    $doc_required = "<h4><label class='label label-warning text-md-center'>Not-Required</label></h4>";
                }

                if ($upload_path == ""){
                    $stat_check = "<h4><span class='badge bg-red'>No upload</span></h4>";
                    $dis_btn = "";
                    $doc_name = $nm_doc_part.".pdf";
                    $doc_version = "<center>-</center>";
                    $doc_upload = "<center>-</center>";
                    $act    ="disabled";
                } else {

                    $query_exec3 = get_proj_doc_assign_data($id_project, $id_product, $id_part, $id_doc_part);
                    $row3 = mysqli_fetch_assoc($query_exec3);

                    $query_exec4 = get_proj_doc_assign_data_status($id_project, $id_product, $id_part, $id_doc_part);
                    $row4 = mysqli_fetch_assoc($query_exec4);

                    $count_row3 = mysqli_num_rows($query_exec3);
                    $sum_check = $row4['check_status'];

                    if ($count_row3 == $sum_check){
                        $stat_check =  "<h4><span class='badge bg-blue'>Completed ($sum_check/$count_row3)</span></h4>";
                        array_push($completed_arr, 'completed');
                        $dis_btn = "style=\"display: none\"";
                        $doc_name = "<h4><span class='badge bg-green'>Completed Check</span></h4>"; //$doc_upl_nm
                    } else {
                        $stat_check =  "<a href='home.php?".token()."mnu=checkdoceng".token2()."&id_data=".$data."'><h4><span class='badge bg-orange btn-flat'>Uncomplete ($sum_check/$count_row3)</span></h4></a>";
                        $dis_btn = "";
                        $doc_name = $nm_doc_part.".pdf";
                    }

                    $doc_version = "<h4><span class='badge bg-green'>Ver 0".$ver."</span></h4>";
                    $doc_upload  = "<center>$upload_n</center>";
                    $act    ="";
                    //FIRST PERMISSION
                    if ($permit_n == 1 ){

                        $permit = "
                                <a href='' class='btn btn-flat' disabled>
                                    <span class='badge bg-green btn btn-flat'> ACTIVATED</span>
                                </a>
                        ";
                    }  else {

                        $permit = "
                                <a href='project_mgt/act-project-mgt.php?act=permitupl&data=".$dataproj."' data-toggle='tooltip' title='click to activate' class='btn btn-flat'>
                                    <span class='badge bg-red btn btn-flat'> OFF</span>
                                </a>
                        ";
                    } //elseif ($permit_n == 0)

                    //SECOND PERMISSION
                    if ($permit_n == 2){

                        $permit2 = "
                                <a href='' class='btn btn-flat' disabled>
                                    <span class='badge bg-green btn btn-flat' > ACTIVATED</span>
                                </a>
                        ";
                    } else {

                        $permit2 = "
                                <a href='project_mgt/act-project-mgt.php?act=permitupl&data=".$dataproj."' data-toggle='tooltip' title='click to activate' class='btn btn-flat'>
                                    <span class='badge bg-red btn btn-flat'> OFF</span>
                                </a>
                        ";
                    } //elseif ($permit_n == 0)
                }

        ?>
            <tr>
                <td>
                    <label><?php echo $nm_doc_part; ?></label>
                     <?php
                       if  ($upload_n >= 4) {
                    ?>
                        <p><small>
                            <span class='badge bg-red'>Upload time (<?php echo $upload_n; ?>)</span>
                        </small></p>
                    <?php
                       }
                    ?>
                </td>
                <td><input type='file' id='file' name='doc[]' accept='.pdf' <?php echo $dis_btn; ?> onchange='ValidateSize(this)' > <!-- id='<?php echo $id_doc_part; ?>' -->
                    <p class='help-block' id ="information"><?php echo $doc_name; ?></p>
                </td>
                <td><?php echo $stat_check; ?></td>
                <td><?php echo $doc_required; ?></td>
                <td>
                    <a href="DATA/viewpdf.php?id=<?php echo $id_project;?>&nm=<?php echo $filename; ?>" class="btn btn-flat <?php echo $act;?>" target="_blank" data-toggle='tooltip' title='click to preview' >
                        <?php echo $doc_version;?>
                    </a>
                </td>
                <td><?php echo $doc_upload; ?></td>
                <?php if ($_SESSION['role'] == "admin") { ?>
                <td>
                    <?php
                       if  ($upload_n >= 5) {
                           //echo $permit;

                            if ($permit_n == 0 ) {

                                 echo "<label>N-1</label>";
                                 echo $permit;

                            } elseif ($permit_n == 1 ){

                                 echo "<label>N-2</label>";
                                 echo $permit2;

                            } elseif ($permit_n == 2 ) {

                                echo "<label>N-1</label>";
                                echo $permit2;
                                echo "<br>";
                                echo "<label>N-2</label>";
                                echo $permit2;

                            }//if ($permit_n == 0)

                       }//($upload_n >= 5)
                    ?>
                </td>
                <?php }//if ($_SESSION['role'] == "admin") ?>
            </tr>

            <input type="hidden" name="doc_arr[]" value="<?php echo $id_doc_part; ?>" >

        <?php
                //array_push($doc_arr, $id_doc_part);

            }//while ($row_b = mysqli_fetch_assoc($query_exec_b))

        ?>


        </table>
    </div> <!-- table responsive -->
    </div> <!-- <div class="form-group"> -->
</div>
       </div>

    <?php
        if (count($completed_arr) != mysqli_num_rows($query_exec_b) ) {
            //$open_a = "<!--";
            //$close_a= "-->";


            //echo $open_a;
            ?>

            <div class="box-footer">
                <button type="submit" id="upload" name="upload" class="btn btn-primary btn-flat" onclick="uploadDoc()">
                    <i class="fa fa-upload"></i> Upload
                </button>
            </div>

            <?php //echo $close_a;
        }
    ?>

</div>

<?php

    } //if (isset($_POST['show-data']))
?>                                 

</form>

</div> 

<?php

if (isset($_POST['upload'])){

    $id_project_new     = $_POST['id_project'];
    $dest_path          = "DATA/$id_project_new";   
    $data               = explode("_", $_POST['prod_part']);
    $id_product_new     = $_POST['id_product'];
    $id_part_new        = $_POST['id_part'];
    $id_doc_part_new    = $_POST['doc_arr'];


    $query_exec_data = get_upload_sequence($id_project_new, $id_product_new, $id_part_new);
    $upload_count   = mysqli_fetch_assoc($query_exec_data);
    $upload_count_n = $upload_count['upload_n'];
    $upload_n = intval($upload_count_n) + 1;
    //echo $id_product_new."_".$id_part_new;
   
    $nm_product         = array();
    $nm_part            = array();
    $nm_doc_part        = array();

    $query_exec5 = get_group_all_join_proj_prod_part_doc_data($id_project_new, "P");
    while ($row5 = mysqli_fetch_assoc($query_exec5)){
        $product     = $row5['nm_product'];
        $part        = $row5['nm_part'];
        $doc_part    = $row5['nm_doc_part'];

        array_push($nm_part, $part);
        array_push($nm_doc_part, $doc_part);
        array_push($nm_product, $product);
    }
  
    $data_count       = get_group_all_join_proj_prod_part_data_required($id_project_new, $id_product_new, $id_part_new, 'P', 'Y', 'M');
    $row_data_count   = mysqli_num_rows($data_count);    
    $count_doc        = count($id_doc_part_new);
  
    //get document count to be uploaded where id_project, id_product, id_part and doc_type = 'P' and required ='Y'
    //if upload_n == 5 notif maximum upload reached please contact admin

    //if nothing posted
    //$_FILES['qis']['error'] == 4 AND $_FILES['drawing']['error'] == 4

    $upload_array = array();
    $upld_count = count($_FILES['doc']['tmp_name']);
    for ($x = 0; $x < $upld_count; $x++){
        if ($_FILES['doc']['tmp_name'][$x] != ""){
            array_push($upload_array, '$x');
        }
    }

    //error
    if(count($upload_array) == 0){ //check doc choosen

      echo "<script>
                swal({
                   title: 'Error',
                   text: 'No file choosen!',
                   type: 'error',
                   allowOutsideClick: false
                })
            </script>";

    } else { //

        $row_query          = get_all_proj_doc_upload_data($id_project_new);
        $row_proj_upload    = mysqli_num_rows($row_query);

        $row_query_ass      = get_proj_assign_data($id_project_new);
        $row_project_assign = mysqli_num_rows($row_query_ass);

        //check if data exist
        //if no data
        if ($row_proj_upload == 0 AND $row_project_assign == 0) {

            //create direktori
            mkdir_r("DATA/$id_project_new",0777);

            $query_exec5 = get_group_all_join_proj_prod_part_doc_data($id_project_new, "P");
            while ($row5 = mysqli_fetch_assoc($query_exec5)) {
                $id_product     = $row5['id_product'];
                $nm_product     = $row5['nm_product'];
                $id_part        = $row5['id_part'];
                $nm_part        = $row5['nm_part'];
                $id_doc_part    = $row5['id_doc_part'];
                $nm_doc         = $row5['nm_doc_part'];
                $doc_required   = $row5['doc_required'];

                insert_proj_doc_upload($id_project_new, $id_product, $id_part, $id_doc_part, $doc_required, "", "", "", "", "");

            } //while ($row5 = mysqli_fetch_assoc($query_exec5))

            //insert detail data to proj_doc_assign
            $idproj_arr         = array();
            $idprod_arr         = array();
            $idpart_arr         = array();
            $iddoc_arr          = array();
            $checkparams_arr    = array();

            $i = 0;

            $query_exec6 = get_all_join_data($id_project_new, "P");
            while ($row6 = mysqli_fetch_assoc($query_exec6)) {

                $idproj_arr[]       = $row6['id_project'];
                $idprod_arr[]       = $row6['id_product'];
                $idpart_arr[]       = $row6['id_part'];
                $iddoc_arr[]        = $row6['id_doc_part'];
                $checkparams_arr[]  = $row6['check_params'];

                insert_proj_doc_assign($idproj_arr[$i], $idprod_arr[$i], $idpart_arr[$i], $iddoc_arr[$i], $checkparams_arr[$i]);

                $i++;

            } //while ($row6 = mysqli_fetch_assoc($query_exec6))

            foreach($_FILES['doc']['tmp_name'] as $key => $tmp_name)
            {

                $file_name  = $_FILES['doc']['name'][$key];
                $file_size  = $_FILES['doc']['size'][$key];
                $file_tmp   = $_FILES['doc']['tmp_name'][$key];
                $file_type  = $_FILES['doc']['type'][$key];

                //$query_exec_data = get_upload_sequence($id_project_new, $id_product_new, $id_part_new, $id_doc_part_new[$key]);
                /*
                $query_exec_data = get_upload_sequence($id_project_new, $id_product_new, $id_part_new);
                $upload_count   = mysqli_fetch_assoc($query_exec_data);
                $upload_count_n = $upload_count['upload_n'];
                $upload_n = intval($upload_count_n) + 1;
                */

                $query_exec_data2 = get_doc_ver($id_project_new, $id_product_new, $id_part_new, $id_doc_part_new[$key]);
                $version_count   = mysqli_fetch_assoc($query_exec_data2);
                $version_count_n = $version_count['version_n'];
                $version_n      = intval($version_count_n) + 1;
                $uploader_id = $_SESSION['id_user'];

                $query = get_group_all_join_proj_prod_part_data($id_project_new, $id_product_new, $id_part_new, 'P');
                $rows = mysqli_fetch_assoc($query);
                $nm_product_file = $rows['nm_product'];
                $nm_part_file    = $rows['nm_part'];

                $temp = explode(".", $_FILES["doc"]["name"][$key]);
                $newfilename = $nm_product_file."_".$nm_part_file ."_".$nm_doc_part[$key]."_ver".$version_n. '.' . end($temp);

                if (move_uploaded_file($file_tmp,"DATA/$id_project_new/" . $newfilename)){
                    $upload_path    ="DATA/$id_project_new/".$newfilename;
                    $upload_n       = intval($upload_count_n) + 1;
                    $version_n      = intval($version_count_n) + 1;
                } else {
                    $upload_path    ="";
                    $upload_n       = "";
                    $version_n      = "";
                }

                update_proj_doc_upload($id_project_new, $id_product_new, $id_part_new, $id_doc_part_new[$key], $newfilename, $upload_n, $version_n, $uploader_id, $upload_path);

                //echo "<script> alert('Upload success'); </script>";

            }//foreach($_FILES['doc']['tmp_name'] as $key => $tmp_name)

            //echo "<script> alert('Upload success'); </script>";

            echo '
            <script>
                swal({
                    title: "Success",
                    text: "Upload success!",
                    type: "success",
                    customClass: \'swal-wide\',
                    allowOutsideClick: true
                });
            </script>
            ';

        }//if ($row_proj_upload == 0)

        //else if data exist
        elseif ($row_proj_upload > 0 AND $row_project_assign > 0)
        {

            $query_exec = get_upload_sequence($id_project_new, $id_product_new, $id_part_new);
            $upload_count   = mysqli_fetch_assoc($query_exec);
            $upload_count_x = $upload_count['upload_n'];
            $upload_x = intval($upload_count_x);

            //get permit 1
            $query_exec1 = get_permit($id_project_new, $id_product_new, $id_part_new);
            $permit_count1   = mysqli_fetch_assoc($query_exec1);
            $permit_count_1 = $permit_count1['permit_n'];
            $permit_x = intval($permit_count_1);

            $permit_max1 = 6;
            $permit_max2 = 7;

            if ($permit_x == 1){
                $permit1 = $permit_x;
            } elseif ($permit_x == 2) {
                $permit2 = $permit_x;
            }

            if ($upload_x < 5 OR ($permit_max1 == ($upload_x + $permit1)) OR ($permit_max2 == ($upload_x + $permit2)) ) {

                foreach($_FILES['doc']['tmp_name'] as $key => $tmp_name)
                {

                    $file_name  = $_FILES['doc']['name'][$key];
                    $file_size  = $_FILES['doc']['size'][$key];
                    $file_tmp   = $_FILES['doc']['tmp_name'][$key];
                    $file_type  = $_FILES['doc']['type'][$key];

                    if ($file_tmp  != ""){

                        //$query_exec_data = get_upload_sequence($id_project_new, $id_product_new, $id_part_new, $id_doc_part_new[$key]);
                        /*
                        $query_exec_data = get_upload_sequence($id_project_new, $id_product_new, $id_part_new);
                        $upload_count   = mysqli_fetch_assoc($query_exec_data);
                        $upload_count_n = $upload_count['upload_n'];
                        $upload_n = intval($upload_count_n) + 1;
                        */

                        $query_exec_data2 = get_doc_ver($id_project_new, $id_product_new, $id_part_new, $id_doc_part_new[$key]);
                        $version_count   = mysqli_fetch_assoc($query_exec_data2);
                        $version_count_n = $version_count['version_n'];
                        $version_n      = intval($version_count_n) + 1;
                        $uploader_id = $_SESSION['id_user'];

                        $query = get_group_all_join_proj_prod_part_data($id_project_new, $id_product_new, $id_part_new, 'P');
                        $rows = mysqli_fetch_assoc($query);
                        $nm_product_file = $rows['nm_product'];
                        $nm_part_file    = $rows['nm_part'];

                        $temp = explode(".", $_FILES["doc"]["name"][$key]);
                        $newfilename = $nm_product_file."_".$nm_part_file."_".$nm_doc_part[$key]."_ver".$version_n. '.' . end($temp);

                        /*
                            nama product pasti nama file di array
                            sehingga nama nya akan selalu restart ke product 1
                            begitu juga nama part
                            pasti akan selalu restart ke part A
                        */

                        if (move_uploaded_file($file_tmp,"DATA/$id_project_new/" . $newfilename)){
                            $upload_path    ="DATA/$id_project_new/".$newfilename;
                            $upload_n       = intval($upload_count_n) + 1;
                            $version_n      = intval($version_count_n) + 1;
                        } else {
                            $upload_path    ="";
                            $upload_n       = "";
                            $version_n      = "";
                        }

                        update_proj_doc_upload($id_project_new, $id_product_new, $id_part_new, $id_doc_part_new[$key], $newfilename, $upload_n, $version_n, $uploader_id, $upload_path);

                        //echo "<script> alert('Upload success'); </script>";

                    }//if ($file_tmp  != "")

                }//foreach($_FILES['doc']['tmp_name'] as $key => $tmp_name)

                //echo "<script> alert('Upload success'); </script>";

                echo '
                    <script>
                        swal({
                            title: "Success",
                            text: "Upload success!",
                            type: "success",
                            customClass: \'swal-wide\',
                            allowOutsideClick: true
                        });
                    </script>
                ';

            }// if ($upload_n < 5)

            elseif ($upload_x >= 5 OR $permit_x == 0 ) {

                echo '
                    <div class="callout callout-danger alert-dismissable bg-red">
                        <center>
                            <medium><i class="fa fa-warning"></i> You\'ve reached maximum upload. Please contact administrator for re-upload permission!</medium>
                        </center>
                    </div>
                ';

            }

        }//elseif ($row_proj_upload > 0)

    } //elseif of check doc choosen


}

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

                if(!hasExtension('data', ['.pdf'])){
                    alert("Only PDF file allowed!");
                    return false;
                }
            }
        
        </script>

        <script>
        function uploadDoc() {
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
                            window.location = ('../view/home.php?mnu=uplddraw');
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