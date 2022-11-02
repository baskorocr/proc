<?php

include "../conn/conn.php";
include "project-mgt-query.php";


$string = $_GET['id_data'];
$data = explode(",", $string);

$id_project = $data[0];
$id_product = $data[1];
$id_part    = $data[2];
$id_doc_part= $data[3];
$id_vendor  = $data[4]; 

$doc_type   = 'V';


$query_exec = get_group_all_join_proj_prod_part_data($id_project, $id_product, $id_part, "V"); 
$row = mysqli_fetch_assoc($query_exec);
$proj = $row['nm_project'];
$prod = $row['nm_product'];
$part = $row['nm_part'];

$name = $proj." - ". $prod ." - ". $part;  
 
?>

<div class="box-header">
    <h3 class="box-title"><label>Check Document Vendor</label>
    </br>
    [<?php echo $name; ?>]
    </h3>

</div>
<hr style="margin-top: 1px;">

<form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
        
    <input type="hidden" name ="id_vendor" value="<?php echo $id_vendor; ?>">
    <?php

        //$check_param_arr = array();

        $query_exec4 = get_group_all_vendor_proj_prod_part_data($id_project, $id_product, $id_part, $id_doc_part, $doc_type, $id_vendor); 
        $row4 = mysqli_fetch_assoc($query_exec4);
                $id_doc_part = $row4['id_doc_part'];
                $nm_doc_part = $row4['nm_doc_part'];
                $ver         =$row4['version_n'];
    ?>        

<div class = "table-responsive">
    <div class="box-body">
        <table class="table table-bordered table-striped">
                <label><?php echo $nm_doc_part." [Ver. 0".$ver."]"; ?></label></br>
            

        <thead>
            <th>No</th>
            <th>Check Parameters</th>
            <th style="width: 100px;">Check by Procurement</th>
            <th>Comment(s)</th>
            <th style="width: 100px;">Check by QA</th>
            <th>Comment(s)</th>
        </thead>
        <tbody>
            <?php 
                 $no = 1;
                $query_exec5 = get_checklist_vendor_has_uploaded_data2($id_project, $id_product, $id_part, $id_doc_part, $id_vendor); 
                while ($row5 = mysqli_fetch_assoc($query_exec5)) {
                    $check_params = $row5['check_params'];


                $query_exec6 = get_param_vendor_has_checked_data2($id_project, $id_product, $id_part, $id_doc_part, $check_params, $id_vendor);
                $row6 = mysqli_fetch_assoc($query_exec6);
                $check_status_a   = $row6['check_status_a'];
                $comment_a        = $row6['comment'];
                $check_status_b = $row6['check_status_b'];
                $comment_b      = $row6['comment_b'];

                    if($_SESSION['role']=='admin' or $_SESSION['role']=='proc'){

                        $disabled_proc = "";
                        $disabled_qa   = " disabled";

                    } elseif($_SESSION['role']=='admin' or $_SESSION['role']=='qa'){

                        $disabled_proc = " disabled";
                        $disabled_qa   = "";
                    }

                    if ($check_status_a == 1) {
                        $checked_a = "checked";
                    } elseif ($check_status_a == 0) {
                        $checked_a = "";
                    }

                    if ($check_status_b == 1) {
                        $checked_b = "checked";
                    } elseif ($check_status_b == 0) {
                        $checked_b = "";
                    }

                //}

                //$string   = $id_project."_".$id_product."_".$id_part."_".$id_doc_part."_".$check_params."_".$id_vendor;
                $string   = $id_project."_".$id_product."_".$id_part."_".$id_doc_part."_".$row5['id_assign']."_".$id_vendor;
                $htm_nm   = preg_replace('/\s+/', '', $string);
                $htmname = str_replace('_', '', $htm_nm);

            ?>
                <tr>
                    <td style ="width: 10px;"><?php echo $no; ?></td>
                    <td><label><?php echo $check_params;?></label></td>

                    <td>
                        <input type="checkbox" name="<?php echo $htmname; ?>" value="1" <?php echo $checked_a; echo $disabled_proc; ?> >
                    </td>
                     <td><textarea type="text" class="form-control" name="<?php echo $htmname."_1"; ?>" placeholder="input comment" rows="4" <?php echo $disabled_proc; ?> ><?php echo $comment_a; ?></textarea>
                    </td>

                    <td>
                        <input type="checkbox" name="<?php echo $htmname."_b"; ?>" value="1" <?php echo $checked_b; echo $disabled_qa; ?> >
                    </td>
                    <td><textarea type="text" class="form-control" name="<?php echo $htmname."_2"; ?>" placeholder="input comment" rows="4" <?php echo $disabled_qa; ?> ><?php echo $comment_b; ?></textarea>
                    </td>

                    <input type="hidden" name="list_arr[]" value="<?php echo $check_params; ?>" >

                </tr>

            <?php
                    $no++;
                } // while ($row5 = mysqli_fetch_assoc($query_exec5))

                //echo count($check_param_arr);
            ?>
        </tbody>
        </table>
    </div>
</div>
    <div class="box-footer">
       	<button type="submit" id="update-check" name="update-check" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Check</button>
    </div>
</form>

<?php 
    
    if(isset($_POST['update-check'])) {

        $checker_id         = $_SESSION['id_user'];
        $count_param_arr    =  count($_POST['list_arr']);
        $id_vendor          = $_POST['id_vendor'];
        //echo $count_param_arr."</br>";

        $query_exec6 = get_checklist_vendor_has_uploaded_data2($id_project, $id_product, $id_part, $id_doc_part, $id_vendor); 
        while ($row6 = mysqli_fetch_assoc($query_exec6)) {

            $id_project_2     = $row6['id_project'];
            $id_product_2     = $row6['id_product'];
            $id_part_2        = $row6['id_part'];
            $id_doc_part_2    = $row6['id_doc_part'];
            $check_params_2   = $row6['check_params'];
            $id_vendor_2      = $row6['id_vendor'];

            //$string             = $id_project_2."_".$id_product_2."_".$id_part_2."_".$id_doc_part_2."_".$check_params_2."_".$id_vendor_2;
            $string             = $id_project_2."_".$id_product_2."_".$id_part_2."_".$id_doc_part_2."_".$row6['id_assign']."_".$id_vendor_2;
            $htm_nm             = preg_replace('/\s+/', '', $string);
            $htmname            = str_replace('_', '', $htm_nm);
            
            $checked_stat_a     = $_POST[$htmname];
            $commented_a        = $_POST[$htmname."_1"];
            $checked_stat_b     = $_POST[$htmname."_b"];
            $commented_b        = $_POST[$htmname."_2"];

            //echo $htmname."_".$_POST[$htmname]."</br>";
            //if user == proc
            if ( $_SESSION['role']=='proc') {

                update_doc_check_params_vendor2($id_project_2, $id_product_2, $id_part_2, $id_doc_part_2, $check_params_2, $checked_stat_a, $checker_id, $commented_a, $id_vendor_2);

            } else if ( $_SESSION['role']=='qa') {

                update_doc_check_params_vendor3($id_project_2, $id_product_2, $id_part_2, $id_doc_part_2, $check_params_2, $checked_stat_b, $checker_id, $commented_b, $id_vendor_2);

            }//if ( $_SESSION['role']=='proc')

        }//while ($row6 = mysqli_fetch_assoc($query_exec6))     

        /*
        echo"
        <script>
            window.alert('Update check success!');
            window.location=('home.php?mnu=vupldeng');
        </script>";
        */

        echo '
        <script>
        swal({
            title: "Success!",
            text: "Update document check success!",
            type: "success",
            customClass: \'swal-wide\',
            allowOutsideClick: false
        })
            .then(function() {
            window.location = (\'home.php?mnu=vupldeng\');
        });
        
        </script>
        ';

        
    }// if(isset($_POST['update-check']))

?>


<script src="../jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="../js/AdminLTE/app.js" type="text/javascript"></script>


    </body>
</html>