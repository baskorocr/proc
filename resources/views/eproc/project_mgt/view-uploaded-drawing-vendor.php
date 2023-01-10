<?php

//require "lib/excel_reader.php";
//include "../conn/connection.php";
//include "data-model/my-query.php";

include "project-mgt-query.php";
include "project-mgt-func.php";

?>


<div class="box-header">
    <h3 class="box-title">View Uploaded Document for Vendor</h3>
</div>
<hr style="margin-top: 1px;">

<div class="box-body"> 
    <form role=form name="myForm1" id="myForm1" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
    <?php
        $id_user = $_SESSION['id_user'];

        $query = get_vendor_user($id_user);
        $row = mysqli_fetch_assoc($query);
        $id_vendor  = isset($row['id_vendor']) ? $row['id_vendor'] : '';

    ?>
        <div class="form-group">
        <label>Choose Project</label>
            <select class="form-control selectpicker" name="id_project" data-live-search="true" required>
                <?php      
                    /*
                        get assigned project to this id vendor
                    */

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
</div>    

<?php 

    if (isset($_POST['show-data'])){

        $query_get_data = get_project_data_by_id($_POST['id_project']);
        $row_data = mysqli_fetch_assoc($query_get_data);
        $nm_project = $row_data['nm_project'];

?> 

<form role=form name="myForm2" id="myForm2" onSubmit="return validateForm()" action="DATA/zip_it.php" method="post" enctype="multipart/form-data" target=_blank>

    <label>[<?php echo $nm_project; ?>]</label>
    <div class="box box-body box-primary">
    <label>Project Document List</label>   
        <input type = "hidden" name="id_vendor" value = "<?php echo $id_vendor; ?>" >

    <div class="table-responsive">
        <table id="example2" class="table table-bordered table-striped">
            <thead>
                <th>Proj.</th>
                <th>Product</th>
                <th>Part</th>
                <th>Document </th>
                <th>Ver.</th>
                <th>Upl. Date</th>
                <th>Upload stat (M)</th>
            </thead>
            <tbody>

                <?php

                    $no = 1;
                    $id_project = $_POST['id_project'];
                    $arr        = array();
                    $arr_mdt    = array();
                    $arr2       = array();
                    $arr2_mdt   = array();
                    $files      = array();

                    $arr_check = array();

                    $query_exec2 = get_vendor_has_assigned_detail2($id_project, $id_vendor, 'P');
                    while ($row2 = mysqli_fetch_assoc($query_exec2)) {   

                        $id_product = $row2['id_product'];
                        $id_part    = $row2['id_part'];
                        $id_doc_part= $row2['id_doc_part'];
                        $doc_required = $row2['doc_required'];

                        //check doc part sum check and doc count di id_project, id_product, id_part and id_vendor
                        //count row check per doc

                        $query_exec_a   = get_proj_doc_assign_part_doc_all2_new($id_project, $id_product, $id_part, $id_doc_part);
                        $row_a          = mysqli_fetch_assoc($query_exec_a);
                        $count_row_a    = mysqli_num_rows($query_exec_a);

                        $query_exec_b   = get_proj_doc_assign_sum_part_doc_all2_new($id_project, $id_product, $id_part, $id_doc_part);
                        $row_b          = mysqli_fetch_assoc($query_exec_b);
                        $count_row_b    = $row_b['check_status'];

                        if ($count_row_a == $count_row_b AND mysqli_num_rows($query_exec_a) > 0 AND $row2['upload_path'] != ""){
                            $status = "<h4><span class='badge bg-green'>Uploaded ($doc_required)</span></h4>";
                            $act    ="";
                            $nm_user = $row2['nm_user'];
                            $show_data = "Y";
                            array_push($arr, "1"); // array doc yang ada path nya
                            
                            if ($row2['doc_required'] == "Y"){
                                array_push($arr_mdt, "Y");
                            }

                        } else {
                            $status = "<h4><span class='badge bg-yellow'> Waiting ($doc_required)...</span></h4>";
                            $act    = "disabled";
                            $nm_user = "";
                            $show_data = "N";
                        }

                        $query_exec3 = get_proj_doc_assign_data($id_project, $id_product, $id_part, $id_doc_part);
                        $row3 = mysqli_fetch_assoc($query_exec3);

                        $query_exec4 = get_proj_doc_assign_data_status($id_project, $id_product, $id_part, $id_doc_part);
                        $row4 = mysqli_fetch_assoc($query_exec4);

                        $count_row3 = mysqli_num_rows($query_exec3);
                        $sum_check = $row4['check_status'];



                        $nama_data = $row2['file_nm'];
                        $temp = explode(".", $nama_data);
                        $filename = $temp[0];

                        $data = $row2['id_project'].",".$row2['id_product'].",".$row2['id_part'].",".$row2['id_doc_part'];

                        $ver            = $row2['version_n'];
                        $upldate        = $row2['upload_date'];


                        if ($ver == 0 or $ver == "" ){
                            $version = "<center> - </center>";
                            $upload_date = "<center> - </center>";
                        } elseif($ver > 0 or $ver != "" ) {
                            $version = "Ver 0".$ver;
                            $upload_date = $upldate;
                        }


                        if ($count_row3 == $sum_check){
                            $stat_check =  "<h4><span class='badge bg-blue'>Completed ($sum_check/$count_row3)</span></h4>";
                        } else {
                            $stat_check =  "<h4><span class='badge bg-red'>Uncomplete ($sum_check/$count_row3)</span></h4>";
                            $version = "<center> - </center>";
                            $upload_date = "<center> - </center>";
                        }

                        ?>

                <tr>
                    <td><?php echo $row2['nm_project'];?></td>
                    <td><?php echo $row2['nm_product'];?></td>
                    <td><?php echo $row2['nm_part'];?></td>
                    <td><?php echo $row2['nm_doc_part'];?></td>
                    <td><?php echo $version;?></td>
                    <td><?php echo $upload_date;?></td>
                    <td>
                        <a href="DATA/viewpdf.php?id=<?php echo $id_project;?>&nm=<?php echo $filename; ?>" class="btn btn-flat <?php echo $act;?>" target="_blank" data-toggle='tooltip' title='click to preview' >
                           <?php echo $status;?>
                        </a>
                    </td>

                    <?php 
                        if ($temp[1] != ""){
                    ?>

                    <input type="hidden" name="files[]" value="<?php echo $id_project."/".$nama_data; ?>" >

                    <?php
                        }// if ($temp[1] != ""){
                    ?>

                    <input type="hidden" name="nm_file" value="<?php echo $row2['nm_project']; ?>" >
                </tr>

                <?php
                        array_push($arr2, $row2['id_project']); // all doc

                        if ($row2['doc_required'] == "Y"){
                            array_push($arr2_mdt, "Y");
                        }

                        $no++;

                    } //while ($row2 = mysqli_fetch_assoc($query_exec2))
                ?>
            </tbody>

        </table>
        </br>
    </div>
    </div> <!-- <div class="box box-body box-primary"> -->

    <div class="box-footer">
        <button type="submit" id="download" name="download" class="btn btn-flat btn-primary"><i class="fa fa-download"></i> Download</button>
    </div>

<?php

    } //if (isset($_POST['show-data'])) 
?>

</form>

<?php
    if (isset($_POST['download'])){

        $file_data  = $_POST['files'];
        $id_project = $_POST['id_project']; 
        $count      = count($file_data);
        $files      = array();
        $id_vendor  = $_POST['id_vendor'];

        $no = 0;
        for ($i = 0; $i < $count; $i++){
            $no++;
            echo ($no)."_".$file_data[$i]."<br>";
            array_push($files, $file_data[$i]);
        }
        
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
         
                if(!hasExtension('vendordata', ['.pdf'])){
                    alert("Only PDF file allowed!");
                    return false;
                }
            }
        </script>

        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": true,
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
        </script>

    </body>
</html>