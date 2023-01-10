<?php

include "../conn/conn.php";
include "project-mgt-query.php";


$string = $_GET['id_data'];
$data = explode(",", $string);

$id_project = $data[0];
$id_product = $data[1];
$id_part    = $data[2];
$id_doc_part= $data[3];

$query_exec = get_group_all_join_proj_prod_part_data($id_project, $id_product, $id_part, "P"); 
$row = mysqli_fetch_assoc($query_exec);
$proj = $row['nm_project'];
$prod = $row['nm_product'];
$part = $row['nm_part'];

$name = $proj." - ". $prod ." - ". $part;    
?>

<div class="box-header">
    <h3 class="box-title"><label>Check Document</label>
    </br>
    [<?php echo $name; ?>]
    </h3>
</div>
<hr style="margin-top: 1px;">

<form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
        
    <?php

        //$check_param_arr = array();

        $query_exec4 = get_group_all_join_proj_prod_part_data2($id_project, $id_product, $id_part, $id_doc_part, "P"); 
        $row4 = mysqli_fetch_assoc($query_exec4);
                $id_doc_part = $row4['id_doc_part'];
                $nm_doc_part = $row4['nm_doc_part'];
                $ver         = $row4['version_n'];
    ?>        

<div class = "table-responsive">
    <div class="box-body">
        <table class="table table-bordered table-striped">
                <label><?php echo $nm_doc_part." [Ver. 0".$ver."]"; ?></label></br>

        <thead>
            <th>Check Parameters</th>
            <th style="width: 100px;">Check by Procurement</th>
            <th >Comment(s)</th>
        </thead>
        <tbody>
            <?php 
                                    
                $query_exec5 = get_checklist_doc_has_uploaded_data($id_project, $id_product, $id_part, $id_doc_part); 
                while ($row5 = mysqli_fetch_assoc($query_exec5)) {
                    $check_params = $row5['check_params'];

                $query_exec6 = get_param_doc_has_checked_data($id_project, $id_product, $id_part, $id_doc_part, $check_params);
                $row6 = mysqli_fetch_assoc($query_exec6);
                $check_status = $row6['check_status'];
                $comment      = $row6['comment'];

                if($_SESSION['role']=='admin'){

                    if ($check_status == 1) {
                        $checked = "checked";
                        $disable = "";
                    } elseif ($check_status == 0) {
                        $checked = "";
                        $disable = "";
                    }

                } else {

                    if ($check_status == 1) {
                        $checked = "checked"; //harusnya pake disable
                        $disable = ""; //disable
                    } elseif ($check_status == 0) {
                        $checked = "";
                        $disable = "";
                    }
                }

                //$string   = $id_project."_".$id_product."_".$id_part."_".$id_doc_part."_".$check_params;
                $string   = $id_project."_".$id_product."_".$id_part."_".$id_doc_part."_".$row5['id_assign'];
                $htm_nm   = preg_replace('/\s+/', '', $string);
                $htmname = str_replace('_', '', $htm_nm);

            ?>
                <tr>
                    <td><label><?php echo $check_params;?></label></td>

                    <!--
                    <td><input type="checkbox" name="dataval[]"  <?php echo $checked; ?> > 
                    </td>
                    -->

                    <td>
                        <input type="checkbox" name="<?php echo $htmname; ?>" value="1" <?php echo $checked; ?> >
                    </td>
                    <td><textarea type="text" class="form-control" name="<?php echo $htmname."_2"; ?>" placeholder="input comment" rows="4" <?php echo $disable; ?> ><?php echo $comment; ?></textarea>
                    </td>

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
    <div class="box-footer">
       	<button type="submit" id="update-check" name="update-check" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Check</button>
    </div>
</form>

<?php 
    
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

            //$string           = $id_project_2."_".$id_product_2."_".$id_part_2."_".$id_doc_part_2."_".$check_params_2;
            $string           = $id_project_2."_".$id_product_2."_".$id_part_2."_".$id_doc_part_2."_".$row6['id_assign'];
            $htm_nm           = preg_replace('/\s+/', '', $string);
            $htmname          = str_replace('_', '', $htm_nm);
            $check_stat_2     = $_POST[$htmname];
            $comment          = $_POST[$htmname."_2"];

            //echo $htmname."_".$_POST[$htmname]."</br>";

            update_doc_chek_params($id_project_2, $id_product_2, $id_part_2, $id_doc_part_2, $check_params_2, $check_stat_2, $checker_id, $comment);

        }//while ($row6 = mysqli_fetch_assoc($query_exec6))     

        /*
        echo"
        <script>
            window.alert('Update check success!');
            window.location=('home.php?mnu=vuplddraw');
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
            window.location = (\'home.php?mnu=vuplddraw\');
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