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
            <th>Check Parameters</th>
            <th style="width: 100px;">Check by Procurement</th>
            <th>Comment(s)</th>
            <th style="width: 100px;">Check by QA</th>
            <th>Comment(s)</th>
            <!--
            <th>Checker</th>
            -->
        </thead>
        <tbody>
            <?php 
                                    
                $query_exec5 = get_checklist_vendor_has_uploaded_data2($id_project, $id_product, $id_part, $id_doc_part, $id_vendor);
                while ($row5 = mysqli_fetch_assoc($query_exec5)) {
                    $check_params = $row5['check_params'];


                $query_exec6 = get_param_vendor_has_checked_data2($id_project, $id_product, $id_part, $id_doc_part, $check_params, $id_vendor);
                $row6 = mysqli_fetch_assoc($query_exec6);
                    $check_status_a   = $row6['check_status_a'];
                    $comment_a        = $row6['comment'];
                    $check_status_b = $row6['check_status_b'];
                    $comment_b      = $row6['comment_b'];
                    $nm_user      = $row6['nm_user'];

                    //stat check by proc
                if (($check_status_a == 1 AND $comment_a != "") OR ($check_status_a == 1 AND $comment_a == "")) {
                    $checked_a = "<h4><label class='label label-success text-md-center'><i class='fa fa-check-square-o'></i> Checked</label></h4>";
                } elseif ($check_status_a == 0 AND $comment_a != "") {
                    $checked_a = "<h4><label class='label label-danger text-md-center'><i class='fa fa-exclamation-circle'></i> Revision</label></h4>";
                } elseif ($check_status_a == 0 AND $comment_a == "") {
                    $checked_a = "<h4><label class='label label-warning text-md-center'><i class='fa fa-exclamation-circle'></i> Waiting...</label></h4>";
                }

                    //stat check by qa
                    if (($check_status_b == 1 AND $comment_b != "") OR ($check_status_b == 1 AND $comment_b == "")) {
                        $checked_b = "<h4><label class='label label-success text-md-center'><i class='fa fa-check-square-o'></i> Checked</label></h4>";
                    } elseif ($check_status_b == 0 AND $comment_b != "") {
                        $checked_b = "<h4><label class='label label-danger text-md-center'><i class='fa fa-exclamation-circle'></i> Revision</label></h4>";
                    } elseif ($check_status_b == 0 AND $comment_b == "") {
                        $checked_b = "<h4><label class='label label-warning text-md-center'><i class='fa fa-exclamation-circle'></i> Waiting...</label></h4>";
                    }

                $htmname   = $id_project."_".$id_product."_".$id_part."_".$id_doc_part."_".$check_params;

                /*
                $htm_nm   = preg_replace('/\s+/', '', $string);
                $htm_name = str_replace('-', '', $htm_nm);
                */

            ?>
                <tr>
                    <td><label><?php echo $check_params;?></label></td>

                    <td><?php echo $checked_a; ?></td>
                    <td><textarea type="text" class="form-control" name="<?php echo $htmname."_a"; ?>" placeholder="comments..." rows='4' disabled><?php echo $comment_a; ?></textarea>
                    </td>

                    <td><?php echo $checked_b; ?></td>
                    <td><textarea type="text" class="form-control" name="<?php echo $htmname."_b"; ?>" placeholder="comments..." rows='4' disabled><?php echo $comment_b; ?></textarea>
                    </td>
                    <!--
                    <td><?php echo $nm_user; ?>
                    -->

                    <input type="hidden" name="list_arr[]" value="<?php echo $check_params; ?>" >

                </tr>

            <?php

                } // while ($row5 = mysqli_fetch_assoc($query_exec5))

                //echo count($check_param_arr);
            ?>
        </tbody>
        </table>
    </div>
</div>
</form>

<?php 
    
    /*
    if(isset($_POST['update-check'])) {

        $checker_id = $_SESSION['id_user'];
        $count_param_arr =  count($_POST['list_arr']);
        //echo $count_param_arr."</br>";

        $query_exec6 = get_checklist_doc_has_uploaded_data($id_project, $id_product, $id_part, $id_doc_part); 
        while ($row6 = mysqli_fetch_assoc($query_exec6)) {

            $id_project_2     = $row6['id_project'];
            $id_product_2     = $row6['id_product'];
            $id_part_2        = $row6['id_part'];
            $id_doc_part_2    = $row6['id_doc_part'];
            $check_params_2   = $row6['check_params'];

            $htmname          = $id_project_2."_".$id_product_2."_".$id_part_2."_".$id_doc_part_2."_".$check_params_2;
            $check_stat_2     = $_POST[$htmname];
            $comment          = $_POST[$htmname."_2"];

            //echo $htmname."_".$_POST[$htmname]."</br>";

            update_doc_chek_params($id_project_2, $id_product_2, $id_part_2, $id_doc_part_2, $check_params_2, $check_stat_2, $checker_id, $comment);

        }//while ($row6 = mysqli_fetch_assoc($query_exec6))     

        echo"
        <script>
            window.alert('Update check success!');
            window.location=('home.php?mnu=vuplddraw');
        </script>";

        
    }// if(isset($_POST['update-check']))
*/
?>


<script src="../jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="../js/AdminLTE/app.js" type="text/javascript"></script>


    </body>
</html>