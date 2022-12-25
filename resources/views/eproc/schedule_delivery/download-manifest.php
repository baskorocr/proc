<?php
/**
 * Copyright (c) 2018. Don't copy or use the source code without author permission for comercial purpose(s)
 */

include "conn/conn_proc.php";
include "schedule-delivery-query.php";
include "function.php";
?>

<body>
<div class="box-header with-border">

   <h3 class="box-title">Download Manifest Order</h3>


</div>
<hr style="margin-top: 1px;">

<div class="box-body">
    <!--
    <table class="table" data-show-toggle="false" data-expand-first="false" data-paging="true" data-sorting="true" data-filtering="false">
     -->

    <?php

        $id_user = $_SESSION['id_user'];

        $query = get_vendor_user($id_user);
        $row = mysqli_fetch_assoc($query);

        $id_vendor = isset($row['id_vendor']) ? $row['id_vendor'] : '';

        //echo $data['id_vendor'];

        $role = $_SESSION['role'];
    ?>

    <form role=form name="myForm" onSubmit="return downloadfunction()" action="zip_mf_all.php" method="post" enctype="multipart/form-data">

        <table id="example2" class="table table-bordered table-striped display nowrap"  style="width:100%">
        <thead>
                <tr>
                    <th><i class="fa fa-list"></i></th>
                    <th data-visible="true">Manifest</th>
                    <th>Delivery Date</th>
                    <th>PO Number</th>
                    <th data-breakpoints="xs">Vendor</th>
                    <th>Vendor Name</th>
                    <th>Email</th>
                    <th data-breakpoints="all"><i class="fa fa-envelope"></i></th>
                    <th data-breakpoints="all"><i class="fa fa-file"></i></th>
                    <th data-breakpoints="all"><i class="fa fa-download"></i></th>
                    <th data-breakpoints="all"><i class="fa fa-clock-o"></i></th>
                    <!--
                    <th data-breakpoints="all"><i class="fa fa-file"></i></th>
                    -->
                    <th data-breakpoints="all">File name</th>

                </tr>
            </thead>
            <tbody>

            <?php

                //$data['id_vendor'] = '211445';

            if($role == 'vendor') {
                $query_exec = get_all_manifest_group_2_by_vendor_mfo($id_vendor);
            } else {
                $query_exec = get_all_manifest_group_2_mfo();
            }

            $mfo_exist = array();

            while ($row = mysqli_fetch_assoc($query_exec)) {


                if($row['sent'] != '0000-00-00 00:00:00'){
                    $mail_stat = "<small><i class='fa fa-check-circle' style='color: green;'></i></small>";
                } else {
                    $mail_stat = "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";
                }

                if($row['downloaded'] != '0000-00-00 00:00:00'){
                    $dwld_stat = "<small><i class='fa fa-check-circle' style='color: green;'></i></small>";
                } else {
                    $dwld_stat = "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";
                }

                if($row['active'] != 'A'){
                    $active_stat = "<small><i class='fa fa-check-circle' style='color: green;'></i></small>";
                } else {
                    $active_stat = "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";
                }

                if(filter_var($row['username'], FILTER_VALIDATE_EMAIL) AND $row['status_user'] == "A") {
                    $vendor_mail_stat = "<small><i class='fa fa-check-circle' style='color: green;'></i></small>";
                    $vendor_mail = $row['username'] . " " . $vendor_mail_stat;
        
                }elseif(filter_var($row['username'], FILTER_VALIDATE_EMAIL) AND $row['status_user'] != "A"){
        
                    $vendor_mail_stat = "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";
                    $vendor_mail = $row['username'] . " " . $vendor_mail_stat;
        
                }else {
                    $vendor_mail_stat = "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";
                    $vendor_mail = "No mail ".$vendor_mail_stat;
                }

                $dateformat = strtotime($row['delivery_date']);
                //$dlv_date = date("d.m.Y", $dateformat);
				$dlv_date = date("Y-m-d", $dateformat);
                
                $filenm = $row['file_nm'];

                $diff = dateDifference($row['delivery_date'] , date("Y-m-d"),'%d' );

                //$filemf = $row['manifest'].".pdf";
                $filemf = $row['file_nm'];
                $mf_type = $row['mf_type'];
                $id_vendor = $row['id_vendor'];

                 //check file
                 if ($filenm != "") {
                    //activate
                    $btnlink = 'A';
                    $stat = '';
                    $file_exist = "<small><i class='fa fa-check-circle' style='color: green;'></i></small>";

                    //$filepdf = $filenm.".pdf";
                    $filepdf = $filenm;

                    //2 days active link
                    /*
                    if($diff >= 3){
                        $stat = 'disabled';
                    } else {
                        $stat = '';
                    }
                    */

  
                } else {
                    $btnlink = 'N';
                    $stat = 'disabled';
                    $file_exist = "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";
                    $filepdf = "-";

                }

                if($stat == 'disabled'){

                    $active = "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";

                } else {
                    $active = "<small><i class='fa fa-check-circle' style='color: green;'></i></small>";
                }
            ?>
                        <tr>
                            <td><input type="checkbox" name="selectmf[]" value="<?php echo $filemf; ?>" <?php echo $stat; ?> >
                                <input type="hidden" name="mftype" value ="<?php echo $mf_type; ?>" />
                                <input type="hidden" name="idvendor" value ="<?php echo $id_vendor; ?>" />
                            </td>

                            <td><?php echo $row['manifest']; ?></td>
                            <td><?php echo $dlv_date; ?></td>
                            <td><?php echo $row['po_num']; ?></td>
                            <td><?php echo $row['id_vendor']; ?></td>
                            <td><?php echo $row['nm_vendor']; ?></td>
                            <td><?php echo $vendor_mail; ?></td>

                            <td><?php echo $mail_stat; ?></td>
                            <td><?php echo $file_exist; ?></td>
                            <td><?php echo $dwld_stat; ?></td>

                            <td><?php echo $active; ?></td>
                            <td><?php echo $row['file_nm']; ?></td>

                        </tr>

            <?php
                    if($filenm != '') {
                        array_push($mfo_exist,  $row['manifest']);
                    }
                }

            ?>

            </tbody>

        </table>

        <?php


            $count_data = count($mfo_exist);

            if ($count_data >= 1) {
                ?>

                <div class="">
                        <!-- post array -->

                        <div class="box-footer">
                            <button type="submit" name="checked-po" class="btn btn-flat btn-success"><i
                                        class="fa fa-download"></i> Download Checked
                            </button>
                        </div>

                </div>

        <?php
           }
        ?>

    </form>

</div>


<?php

/*
    if(isset($_POST['dwlpo'])){

        $data['po_num'] = $_POST['po'];
        //download status update
        update_po_download_mail($data);

        if(update_po_download_mail($data)) {
    */

?>
            <script>
                //var po = "<?php echo $_POST['po'];?>";
                //window.location = 'get-po.php?x=' + po;
            </script>
<?php
        //}
    //}

?>


<?php

    if(isset($_GET['msg']) == '404'){
?>

<script>

    swal({
        title: 'Error',
        text: 'File does not exist!',
        type: 'error',
        allowOutsideClick: false
    })

</script>

<?php

    } elseif(isset($_GET['msg']) == '400'){
 ?>

        <script>

            swal({
                title: 'Error',
                text: 'No list selected!',
                type: 'error',
                allowOutsideClick: false
            })

        </script>

 <?php
    }
?>

<!-- ============ SCRIPT ================= -->
<!-- jQuery 2.0.2 -->
<script src="../jquery-2/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../js/bootstrap.min.js" type="text/javascript"></script>

<!-- DATA TABES SCRIPT -->

<script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<script src="../js/plugins/datatables/addon/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="../js/plugins/datatables/addon/buttons.flash.min.js" type="text/javascript"></script>
<script src="../js/plugins/datatables/addon/jszip.min.js" type="text/javascript"></script>
<script src="../js/plugins/datatables/addon/pdfmake.min.js" type="text/javascript"></script>
<script src="../js/plugins/datatables/addon/vfs_fonts.js" type="text/javascript"></script>
<script src="../js/plugins/datatables/addon/buttons.html5.min.js" type="text/javascript"></script>
<script src="../js/plugins/datatables/addon/buttons.print.min.js" type="text/javascript"></script>

<!-- FOOTABLE -->
<!--
<script src="../css/footable/js/footable.min.js" type="text/javascript"></script>
-->

<!-- AdminLTE App -->
<script src="../js/AdminLTE/app.js" type="text/javascript"></script>


<!-- page script -->
<script type="text/javascript">
    $(function() {
        $("#example2").dataTable( {
            /*
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel'
            ],
            */
            "scrollX": true,
            "filter" : true,
            "lengthChange" : false,
            "sort"         : true,
            "paginate"     : true,
            "autowidth"    : false,
			"order": [[ 2, "desc" ]]
        } );
    });

</script>


<!--
<script type="text/javascript">
    jQuery(function($){
        $('.table').footable();
    });
</script>
-->
