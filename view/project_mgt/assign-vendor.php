<?php
/**
 * Copyright (c) 2017. Don't copy or use the source code without author permission for comercial purpose(s)
 */

    include "project-mgt-query.php";
    include "project-mgt-func.php";
?>
<script src="../select/dist/js/jquery.js"></script>
<link rel="stylesheet" href="../select/dist/css/multiselect.min.css">
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<script src="../select/dist/js/multiselect.min.js"></script>

<div class="box-header">
    <h3 class="box-title ">Assign Vendor</h3>   
</div>
<hr style="margin-top: 1px;">

<form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
	<div class="box-body"> 
		<div class="form-group">
            <label>Choose Project</label>
            <select class="form-control selectpicker" name="id_project" data-live-search="true">
		      	<?php   

                    //$query_exec1 = get_all_project_data();
                    $query_exec1 = get_proj_assign_data_uploaded();
                    $data_arr    = array();
                    $checked_arr = array();
                    while ($row1 = mysqli_fetch_assoc($query_exec1)) {
                        
                        $id_project = $row1['id_project'];
                        $nm_project = $row1['nm_project'];

                        echo "<option value=".$row1['id_project'].">".$row1['nm_project']."</option>";
                        
                    }// while ($row1 = mysqli_fetch_assoc($query_exec1))
                ?>
            </select>
            <div class="form-group">
                <button type="submit" id="show-data" name="show-data" class="btn btn-success btn-flat"><i class="fa fa-search"></i> Search</button></a>
            </div>
        </div>

</form>

    <?php

        if (isset($_POST['show-data'])){

            $id_project= $_POST['id_project'];

            /*
            $idproj_arr     = array();
            $idprod_arr     = array();
            $idpart_arr     = array();
            $iddoc_arr      = array();
            $checkparams_arr = array();
            */

            $query = get_proj_doc_has_uploaded_data($id_project);
            $row = mysqli_fetch_assoc($query);
    ?>

    <div class="form-group">
        <label>[<?php echo $row['nm_project']; ?>] </label>
        <hr style="margin-top: -4px;">
	</div>

    <form role=form name="myForm" id="myFormProd" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">

        <input type="hidden" name="id_project" value="<?php echo $id_project; ?>"/>
        <div class="form-group">
        <label>Choose Product</label>
        <select class="form-control selectpicker" name="id_product" data-live-search="true">
            <?php
             $query_exec3 = get_group_all_join_prod_part_data2($id_project, 'P'); 
                    while ($row3 = mysqli_fetch_assoc($query_exec3)) {
                        $id_prod = $row3['id_product'];
                        $nm_prod = $row3['nm_product'];

                        echo "<option value='$id_prod'>".$nm_prod."</option>";
                    }
            ?>
        </select>
        <div class="form-group">
            <button type="submit" id="show-product-part" name="show-product-part" class="btn-sm btn-flat"><i class="fa fa-search"></i> Search</button></a>
        </div>
    </div>
    </form>

    <?php 

        }//if (isset($_POST['show-data']))

        if(isset($_POST['show-product-part'])){

            $id_project = $_POST['id_project'];
            $id_prodx   = $_POST['id_product'];

            $query = get_proj_doc_has_uploaded_data($id_project);
            $row = mysqli_fetch_assoc($query);
    ?>

<form role=form name="myFormAssign" id="myFormAssign" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">

    <input type="hidden" name="id_project" value="<?php echo $id_project; ?>"/>
        <div class="form-group">
            <div class="form-group">
                <label>[<?php echo $row['nm_project']; ?>] </label>
                <hr style="margin-top: -4px;">
            </div>

    <form role=form name="myForm" id="myFormProd" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
        <label>Choose Product</label>
        <select class="form-control selectpicker" name="id_product" data-live-search="true">
            <?php
             $query_exec3 = get_group_all_join_prod_part_data2($id_project, 'P');
                    while ($row3 = mysqli_fetch_assoc($query_exec3)) {
                        $id_prod = $row3['id_product'];
                        $nm_prod = $row3['nm_product'];

                        echo "<option value='$id_prod'>".$nm_prod."</option>";
                    }
            ?>
        </select>
        <div class="form-group">
            <button type="submit" id="show-product-part" name="show-product-part" class="btn-sm btn-flat"><i class="fa fa-search"></i> Search</button></a>
        </div>
        </div>

        <label>Choose Vendor</label>
            <select class="form-control selectpicker" name="id_vendor" data-live-search="true" required>
                <?php
                    //vendor yang aktif dan belum di assign di project tersebut
                    $query_exec_c = get_vendor_has_assigned($id_project);
                    $count   = mysqli_num_rows($query_exec_c);

                    /*
                    if ($count != 0) {

                        $query_exec = get_all_active_vendor_data();
                        while ($row = mysqli_fetch_assoc($query_exec)) {
                            $id_vendor = $row['id_vendor'];
                            $nm_vendor = $row['nm_vendor'];
                            $alias     = $row['allias'];

                            $query_exec_c = get_vendor_has_assigned($id_project);
                            while($row_data = mysqli_fetch_assoc($query_exec_c)){
                            $id_arr = $row_data['id_vendor'];

                                if ($id_vendor == $id_arr){
                                    break;
                                }

                            } //while($row_data = mysqli_fetch_assoc($query_exec_c))

                            if ($id_vendor != $id_arr){

                                echo "<option value='$id_vendor'>".$nm_vendor." (".$alias.")</option>";

                            }// if ($id_vendor != $id_arr)

                        } //while ($row = mysqli_fetch_assoc($query_exec))

                    } elseif ($count == 0) {

                        $query_exec = get_all_active_vendor_data();
                        while ($row = mysqli_fetch_assoc($query_exec)) {
                            $id_vendor = $row['id_vendor'];
                            $nm_vendor = $row['nm_vendor'];
                            $alias     = $row['allias'];

                            echo "<option value='$id_vendor'>".$nm_vendor." (".$alias.")</option>";

                        } //while ($row = mysqli_fetch_assoc($query_exec))

                    } //elseif ($count == 0)
                    */

                   // if ($count != 0) {
                        $query_exec = get_all_active_vendor_data();
                        while ($row = mysqli_fetch_assoc($query_exec)) {
                            $id_vendor = $row['id_vendor'];
                            $nm_vendor = $row['nm_vendor'];
                            $alias = $row['allias'];

                            echo "<option value='$id_vendor'>".$nm_vendor." (".$alias.")</option>";

                        }
                   // }

                ?>
            </select>
        </div>

    <?php
        $query2 = get_prod_data_by_id($id_prodx);
        $row_prod = mysqli_fetch_assoc($query2);

        $id_product = $_POST['id_product'];
    ?>

    <div class="box-body">
    <label>[<?php echo $row_prod['nm_product']; ?>] </label>
        <hr style="margin-top: -4px;">

        <input type="hidden" name="id_project" value="<?php echo $id_project; ?>"/>

        <?php

            $count = mysqli_num_rows($query_exec3);
            $required_input = array();

        ?>
        <table class="table table-bordered table-striped">
            <th>Part Name</th>
            <th>Doc Status</th>
            <th>Choose Part</th>
            <th>Has Assigned to </th>

            <?php

                $query_exec4 = get_group_all_join_prod_part_data3($id_project, $id_product, 'P');
                while ($row4 = mysqli_fetch_assoc($query_exec4)) {
                    $nm_part = $row4['nm_part'];
                    $nm_prod = $row4['nm_product'];
                    $string   = $nm_prod.'_'.$nm_part;
                    $htm_nm   = preg_replace('/\s+/', '', $string);
                    $htm_name = str_replace('-', '', $htm_nm);

                    $id_project_1 = $row4['id_project'];
                    $id_product_1 = $row4['id_product'];
                    $id_part_1    = $row4['id_part'];

                    //count row check per doc
                    $query_exec_a   = get_proj_doc_assign_part_doc_all_new($id_project_1, $id_product_1, $id_part_1);
                    $row_a          = mysqli_fetch_assoc($query_exec_a);
                    $count_row_a    = mysqli_num_rows($query_exec_a);

                    $query_exec_b   = get_proj_doc_assign_sum_part_doc_all_new($id_project_1, $id_product_1, $id_part_1);
                    $row_b          = mysqli_fetch_assoc($query_exec_b);
                    $count_row_b    = $row_b['check_status'];

                    if ($count_row_a == $count_row_b AND mysqli_num_rows($query_exec_a) > 0){
                        $disabled = "";
                        $doc_completion = "<small class ='badge bg-green' data-toggle='tooltip' title='Mandatory document complete'>
                                                <i class='fa fa-check-square-o'></i> 
                                            Assignment allowed</small>";
                    } elseif ($count_row_a != $count_row_b AND mysqli_num_rows($query_exec_a) > 0) {
                        $disabled = "disabled";
                        $doc_completion = "<small class ='badge bg-red' data-toggle='tooltip' title='Mandatory document not completed'>
                                                <i class='fa fa-warning'></i> 
                                                Assignment not allowed</small>";
                    }

                    echo"
                    <tr>
                        <td><label>".$nm_part. "</label></td>
                        <td>".$doc_completion."</td>
                        <td><input type='checkbox' id='$htm_name' name='$htm_name' $disabled></td>
                    ";

                    echo '<input type="hidden" name="id_part[]" value="<?php echo $id_part_1; ?>"/>';

                    $query_execute =  proj_prod_part_vendor_assigned($id_project_1, $id_product_1, $id_part_1);

                    echo "    
                          <td>";
                                $no = 1;
                                while ($row_ex = mysqli_fetch_assoc($query_execute)) {
                                    $nm_vendor = $row_ex['nm_vendor'];
                                    $alias     = $row_ex['allias'];
                                    echo "<label>".$no.") ".$nm_vendor." (".$alias.")</label><br>";
                                    $no++;
                                }
                    echo "
                           </td>
                    </tr>";

                }//while ($row4 = mysqli_fetch_assoc($query_exec4))

            ?>
        </table>
    </div>

    <div class="box-footer">
    	<button type="submit" name="assign-vendor" class="btn btn-flat btn-primary" onclick="assigning()"><i class="fa fa-check-square-o"></i> Assign</button>
    </div>

</form>

<?php

      }//if(isset($_POST['show-product-part']))

    if (isset($_POST['assign-vendor'])){

        $id_project = $_POST['id_project'];
        $id_vendor  = $_POST['id_vendor'];

        $query_exec5 = get_group_all_join_proj_prod_part_doc_data($id_project, "V");
        while ($row5 = mysqli_fetch_assoc($query_exec5)) {
            $id_product = $row5['id_product'];
            $nm_product = $row5['nm_product'];
            $id_part = $row5['id_part'];
            $nm_part = $row5['nm_part'];
            $id_doc_part = $row5['id_doc_part'];
            $nm_doc = $row5['nm_doc_part'];
            $doc_required = $row5['doc_required'];

            $nm_part = $row5['nm_part'];
            $nm_prod = $row5['nm_product'];
            $string = $nm_prod . '_' . $nm_part;
            $htm_nm = preg_replace('/\s+/', '', $string);
            $htm_name = str_replace('-', '', $htm_nm);

            if (isset($_POST[$htm_name])) {
                $query_executes = get_proj_vendor_assign_data_vendor($id_project, $id_product, $id_part, $id_vendor);
                $num_rows = mysqli_num_rows($query_executes);

                if ($num_rows == 0) {
                    insert_proj_vendor_upload($id_project, $id_product, $id_part, $id_doc_part, "", "", "", "", "", "", $id_vendor);
                } //if ($num_row == 0)

            }//if (isset($_POST[$htm_name]))

        } //while ($row5 = mysqli_fetch_assoc($query_exec5))

        $query_exec6 = get_group_all_join_prod_part_data4($id_project, '');
        while ($row6 = mysqli_fetch_assoc($query_exec6)) {
            $id_product = $row6['id_product'];
            $id_part = $row6['id_part'];
            $id_doc_part = $row6['id_doc_part'];
            $check_params = $row6['check_params'];
            $doc_type = $row6['doc_type'];

            $nm_part = $row6['nm_part'];
            $nm_prod = $row6['nm_product'];
            $string = $nm_prod . '_' . $nm_part;
            $htm_nm = preg_replace('/\s+/', '', $string);
            $htm_name = str_replace('-', '', $htm_nm);

            if (isset($_POST[$htm_name])) {
                //echo $id_project."-".$id_product."-".$id_part."-".$id_doc_part."-".$check_params."-".$doc_type."-".$id_vendor."<br>";
                $query_executes2 = get_proj_vendor_assign_data_vendor2($id_project, $id_product, $id_part, $id_doc_part, $check_params, $id_vendor);
                $num_rows2 = mysqli_num_rows($query_executes2);

                if ($num_rows2 == 0) {
                    insert_proj_vendor_assign($id_project, $id_product, $id_part, $id_doc_part, $check_params, $id_vendor);
                }//if ($num_row == 0)

            }//if (isset($_POST[$htm_name]))

        }//while ($row6 = mysqli_fetch_assoc($query_exec6))

        /*
        echo " <script> window.alert('Success Assigned!'); 
                        window.location=('home.php?mnu=monitoring');
               </script>";
        */
        echo '
        <script>
        swal({
            title: "Success!",
            text: "Success Assigned Vendor!",
            type: "success",
            customClass: \'swal-wide\',
            allowOutsideClick: false
        })
            .then(function() {
            window.location = (\'home.php?mnu=monitoring\');
        });
        
        </script>
        ';

    }//if (isset($_POST['assign-vendor']))
?>

 <!-- AdminLTE App -->
<script src="../../js/AdminLTE/app.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#multiple-checkboxes').multiselect();
    });
</script>

<script>

    function assigning() {
        swal({
            title: 'Vendor Assignment',
            text: 'Please wait...',
            allowOutsideClick: false,
            onOpen: function () {
                swal.showLoading()
            }
        });
    }

</script>
 



        