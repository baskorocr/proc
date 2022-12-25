<?php

//require "lib/excel_reader.php";
//include "../conn/connection.php";
//include "data-model/my-query.php";

include "project-mgt-query.php";
include "project-mgt-func.php";

set_time_limit (400);

?>


<div class="box-header">
    <h3 class="box-title">Check Uploaded Document from Vendor</h3>
</div>
<hr style="margin-top: 1px;">

<form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">

<div class="box-body"> 
        <div class="form-group">
        <label>Choose Project</label>
            <select class="form-control selectpicker" name="id_project" data-live-search="true" required>
                <?php      

                    //project yang sudah upload semua
                    $query_exec1 = get_proj_vendor_upload_data();
                            
                    while ($row1 = mysqli_fetch_assoc($query_exec1)) {
                        echo "<option value=".$row1['id_project'].">".$row1['nm_project']."</option>";
                    }      
                ?>
            </select>

            <div class="form-group">
                <a href =""><button type="submit" id="show-data" name="show-data" class="btn btn-success btn-flat"><i class="fa fa-search"></i> Search</button></a>
            </div>
        </div>
</div>   
</form>

<?php 

    if (isset($_POST['show-data'])){

        $id_project = $_POST['id_project'];

        $query_exec = get_project_data_by_id($id_project);
        $row = mysqli_fetch_assoc($query_exec);
        $nm_project_a = $row['nm_project'];

?> 

<label>[<?php echo $nm_project_a; ?>]</label> 
<form role=form name="myForm1" id="myForm1" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
    <div class="box box-body box-primary">
        <div class="box-header">
            <input type="hidden" name ="id_project" value="<?php echo $id_project; ?>">
            <label class="pull-left">Choose Vendor</label>
            <select class="form-control selectpicker" name="id_vendor" data-live-search="true" required>
                <?php  
                    //vendor yang terkait project tersebut
                    $query_exec1 = get_vendor_assign_data($id_project);
                            
                    while ($row1 = mysqli_fetch_assoc($query_exec1)) {
                        echo "<option value=".$row1['id_vendor'].">".$row1['nm_vendor']." (".$row1['allias'].")</option>";
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

    } //if (isset($_POST['show-data']))

     if (isset($_POST['show-data2'])){

        $id_project = $_POST['id_project'];
        $id_vendor  = $_POST['id_vendor'];

        $query_exec = get_project_data_by_id($id_project);
        $row = mysqli_fetch_assoc($query_exec);
        $nm_project_a = $row['nm_project'];
?>          
        
<label>[<?php echo $nm_project_a; ?>]</label>               
<form role=form name="myForm2" id="myForm2" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
    <div class="box box-body box-primary">
        <div class="box-header">
            <input type="hidden" name ="id_project" value="<?php echo $id_project; ?>">
            <input type="hidden" name ="id_vendor" value="<?php echo $id_vendor; ?>">
            <label class="pull-left">Choose Vendor</label>
            <select class="form-control selectpicker" name="id_vendor" data-live-search="true" required>
                <?php  
                    //vendor yang terkait project tersebut
                    $query_exec1 = get_vendor_assign_data($id_project);
                            
                    while ($row1 = mysqli_fetch_assoc($query_exec1)) {
                        echo "<option value=".$row1['id_vendor'].">".$row1['nm_vendor']." (".$row1['allias'].")</option>";
                    }         
                ?>
            </select>

            <div class="form-group">
                <a href =""><button type="submit" id="show-data2" name="show-data2" class="btn btn-flat-sm"><i class="fa fa-search"></i> Search</button></a>
            </div>

            <?php

                $query_exec = get_vendor_data_by_id($id_vendor);
                $row = mysqli_fetch_assoc($query_exec);
                $nm_vendor_a = $row['nm_vendor'];
                $allias      = $row['allias'];

            ?>

            <label>[<?php echo $nm_vendor_a." - ".$allias; ?>]</label>
            <hr style="margin-top: -5px;">
            <label class="pull-left">Project Document List</label>
        </div> 

    <div class="table-responsive">
        <table id="example2" class="table table-bordered table-striped">
            <thead>
                <th># </th>
                <th>Id Project</th>
                <th>Proj.</th>
                <th>Prod.</th>
                <th>Part</th>
                <th>Doc. </th>
                <th>Ver.</th>
                <th>Upl. Date</th>
                <th>Uplder</th>
                <th>Upload stat (M)</th>
                <th>Check stat (C/N) </th>
            </thead>
            <tbody>

                <?php

                    $no = 1;
                    $arr        = array();
                    $arr_mdt    = array();
                    $arr_req    = array();
                    $arr_nreq   = array();

                    $arr2       = array();
                    $arr2_mdt   = array();
                    $arr2_req    = array();
                    $arr2_nreq   = array();

                    $arr_check = array();

                    $query_exec2 = get_vendor_doc_has_uploaded_data($id_project, $id_vendor);
                    while ($row2 = mysqli_fetch_assoc($query_exec2)) {   

                        $id_product = $row2['id_product'];
                        $id_part    = $row2['id_part'];
                        $id_doc_part= $row2['id_doc_part'];
                        $doc_required = $row2['doc_required'];

                        if ($row2['upload_path'] != ""){
                            $status = "<h4><span class='badge bg-green'>Uploaded ($doc_required)</span></h4>";
                            $act    ="";
                            $nm_user = $row2['nm_user'];
                            array_push($arr, "1"); // array doc yang ada path nya

                            if ($row2['doc_required'] == "M"){
                                array_push($arr_mdt, "M");
                            }

                            if ($row2['doc_required'] == "Y"){
                                array_push($arr_req, "Y");
                            }

                            if ($row2['doc_required'] == "N"){
                                array_push($arr_nreq, "N");
                            }

                        } else {
                            $status = "<h4><span class='badge bg-yellow'> Waiting ($doc_required)...</span></h4>";
                            $act    = "disabled";
                            $nm_user = "";
                        }

                        $query_exec3 = get_proj_doc_assign_data_vendor($id_project, $id_product, $id_part, $id_doc_part, $id_vendor);
                        $row3 = mysqli_fetch_assoc($query_exec3);

                        $query_exec4 = get_proj_doc_assign_data_status_vendor($id_project, $id_product, $id_part, $id_doc_part, $id_vendor);
                        $row4 = mysqli_fetch_assoc($query_exec4);

                        $query_exec_b = get_proj_doc_assign_data_status_vendor2($id_project, $id_product, $id_part, $id_doc_part, $id_vendor);
                        $row_b = mysqli_fetch_assoc($query_exec_b);

                        $count_row3  = mysqli_num_rows($query_exec3);
                        $sum_check   = $row4['check_status'];
                        $sum_check_b = $row_b['check_status_b'];

                        $sum_tobe_checked = $count_row3 + $count_row3;
                        $sum_checked      = $sum_check + $sum_check_b;

                        $sum_of_row  = array();

                        if ($sum_tobe_checked == $sum_checked){
                            $stat_check =  "<h4><span class='badge bg-blue'>Completed ($sum_checked/$sum_tobe_checked)</span></h4>";
                        } else {
                            $stat_check =  "<h4><span class='badge bg-red'>Uncomplete ($sum_checked/$sum_tobe_checked)</span></h4>";
                        }

                        $nama_data = $row2['file_nm'];
                        $temp = explode(".", $nama_data);
                        $filename = $temp[0];
                        $pathname = $id_vendor."/".$filename;

                        $data = $row2['id_project'].",".$row2['id_product'].",".$row2['id_part'].",".$row2['id_doc_part'].",".$id_vendor;

                        $ver            = $row2['version_n'];
                        $upldate        = $row2['upload_date'];

                        if ($ver == 0 or $ver == ""){
                            $version = "<center> - </center>";
                            $upload_date = "<center> - </center>";
                        } elseif ($ver > 0 or $ver != "") {
                            $version = "Ver 0".$ver;
                            $upload_date = $upldate;
                        }
                ?>

                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $row2['id_project'];?></td>
                    <td><?php echo $row2['nm_project'];?></td>
                    <td><?php echo $row2['nm_product'];?></td>
                    <td><?php echo $row2['nm_part'];?></td>
                    <td><?php echo $row2['nm_doc_part'];?></td>
                    <td><?php echo $version;?></td>
                    <td><?php echo $upload_date;?></td>
                    <td><?php echo $nm_user;?></td>
                    <td>
                        <a href="DATA/viewpdf_2.php?id=<?php echo $id_project;?>&p=<?php echo $pathname; ?>&nm=<?php echo $filename; ?>" class="btn btn-flat <?php echo $act;?>" target="_blank" data-toggle='tooltip' title='click to preview' >
                           <?php echo $status;?>
                        </a>
                    </td>
                    <td>
                        <a href="home.php?mnu=checkdocproc&id_data=<?php echo $data;?>" class="btn btn-flat <?php echo $act;?>" data-toggle='tooltip' title='check document'>
                           <?php echo $stat_check;?>
                        </a>
                    </td>
                </tr>

                <?php
                        array_push($arr2, $row2['id_project']); // all doc

                        if ($row2['doc_required'] == "M"){
                            array_push($arr2_mdt, "M");
                        }

                        if ($row2['doc_required'] == "Y"){
                            array_push($arr2_req, "Y");
                        }

                        if ($row2['doc_required'] == "N"){
                            array_push($arr2_nreq, "N");
                        }

                        $no++;  
                    } //while ($row2 = mysqli_fetch_assoc($query_exec2))


                ?>

            </tbody>
        </table>
        </br>
        </div>
    </div> <!-- <div class="box box-body box-primary"> -->

<?php

    /*
    echo "Document uploaded (all)               : ".count($arr)."</br>";
    echo "Document uploaded (mandatory)         : ".count($arr_mdt)."</br>";
    echo "Document uploaded (required)         : ".count($arr_req)."</br>";
    echo "Document uploaded (not-required)         : ".count($arr_nreq)."</br>";
    echo '<br>';
    echo "Document to be completed (all)        : ".count($arr2)."</br>";
    echo "Document to be completed (mandatory)  : ".count($arr2_mdt)."</br>";
    echo "Document to be completed (required)         : ".count($arr2_req)."</br>";
    echo "Document to be completed (not-required)         : ".count($arr2_nreq)."</br>";
    */

    $count_arr_upload   = count($arr_mdt);
    $count_arr_exist    = count($arr2_mdt);
    
if ($count_arr_upload == $count_arr_exist ){

?>

</br>
<!--
    <div class="box-footer">
        <button type="submit" id="update-data" name="update-data" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Confirm</button>
    </div>
-->
</form>


<?php

    }//if ($count_arr_upload == $count_arr_exist )

} //if (isset($_POST['show-data2'])) 

elseif(isset($_POST['update-data'])){
/*  
    $count_arr = count($arr_update_assign);
    loop as much as $count_arr
        $data = explode("_",$count_arr)
        $id_project = $data[0];
        ...
        ... 
        where condition
        $id_project, $id_product, $id_part, $id_doc, $check_params
*/

}//elseif(isset($_POST['update-data']))

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
                    alert("Hanya file PDF yang diijinkan.");
                    return false;
                }
            }
        </script>

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