<?php
/**
 * Copyright (c) 2018. Don't copy or use the source code without author permission for comercial purpose(s)
 */

require "lib/excel_reader.php";
//include "../conn/conn_proc.php";
include "purch-proc-query.php";
include "function.php";
?>

<div class="box-header with-border">

   <h3 class="box-title">PO Mailing</h3>


</div>
<!--
<hr style="margin-top: 1px;">
-->

<div class="box-body">
    <!--
    <table class="table" data-show-toggle="false" data-expand-first="false" data-paging="true" data-sorting="true" data-filtering="false">
     -->

    <?php

        $query_batch = get_max_batch();
        $data = mysqli_fetch_assoc($query_batch);
        $batch = $data['batch'];

        /*recheck*/
        $query_po = get_max_po_apprv_data();
        $data_batchpo = mysqli_num_rows($query_po);

    
        if ($data_batchpo != 0) {
            ?>


            <div align="right">

                <form role=form name="myForm" id="myForm" onSubmit="return mailfunction()" action="home.php?mnu=batchpo"
                      method="post" enctype="multipart/form-data">

                    <input type="hidden" name="batch" value="<?php echo $batch; ?>">

                    <div class="box-footer">
                        <button type="submit" id="mail" name="mail" class="btn btn-success"><i
                                    class="fa fa-envelope"></i> Send Mail
                        </button>
                    </div>


                </form>

            </div>

            <?php
        }

            //mail
            //send to vendor mail
            //update po_list-sent = datenow

            if(isset($_POST['mail'])){

                $querypoaprv = get_max_po_apprv_data_group_idvendor();
                $mail_arr = array();
                $data['batch'] = $_POST['batch'];

                while ($rowpo = mysqli_fetch_assoc($querypoaprv)) {

                    $email['email'] = $rowpo['username'];
                    $email['id_vendor'] = $rowpo['id_vendor'];
                    $email['nm_vendor'] = $rowpo['nm_vendor'];

                    //$data['po_num'] = $rowpo['po_num'];
                    $data['id_vendor'] = $rowpo['id_vendor'];

                    if (filter_var($email['email'], FILTER_VALIDATE_EMAIL)){
                        //$msg = mailtovendor($email);
                        
                        $msg = mailtovendordetail($email);

                        if($msg == 'success'){
                            update_po_sent_mail($data);
                            array_push($mail_arr, "ok");
                        }

                    }

                }

                //$name="hidrian.suharman@dp.dharmap.com";
                //$msg = mailtovendor($name);

                $count_po = mysqli_num_rows($querypoaprv);

                if(count($mail_arr) >= 1 AND count($mail_arr) == $count_po){ //$msg == 'success'

                    //update status sent untuk po list dengan batch

            ?>

                    <script>

                        swal({
                            title: 'Success',
                            text: 'Email has sent to vendors',
                            type: 'success',
                            allowOutsideClick: false
                        })
                            .then(function () {
                                window.location = ('home.php?mnu=dlistpo');
                            })

                        //window.location.replace("index.php?mnu=e7c95ff6c282f4621fd47b967f48bf42");
                    </script>

            <?php

                } elseif(count($mail_arr) >= 1 AND count($mail_arr) != $count_po) {
            ?>

                    <script>

                        swal({
                            title: 'Info',
                            text: 'Some email not sent caused by invalid email',
                            type: 'warning',
                            allowOutsideClick: false
                        })
                            .then(function () {
                                window.location = ('home.php?mnu=dlistpo');
                            })

                    </script>

            <?php

                } elseif(count($mail_arr) < 1)  {
            ?>

                    <script>

                        swal({
                            title: 'Warning',
                            text: 'Email cannot be sent',
                            type: 'warning',
                            allowOutsideClick: false
                        })

                    </script>

            <?php

                } else {
            ?>

                    <script>

                        swal({
                            title: 'Error',
                            text: 'Something went wrong',
                            type: 'error',
                            allowOutsideClick: false
                        })

                    </script>
            <?php
                }

            }//Isset

    ?>

    <table id="example2" class="table table-bordered table-striped table-hover display nowrap"  style="width:100%">
    <thead>
            <tr>
                <th data-visible="true">PO Number</th>
                <th>Plant</th>
                <th data-breakpoints="xs">Vendor</th>
                <th>Vendor Name</th>
                <th data-breakpoints="xs">Doc Date</th>
                <th data-breakpoints="xs">Vendor Mail</th>
                <th data-breakpoints="all"><i class="fa fa-check"></i></th>
                <th data-breakpoints="all"><i class="fa fa-file"></i></th>
                <th data-breakpoints="xs">Upload Date</th>
                <th data-breakpoints="xs">Upload Group</th>
                <th data-breakpoints="all">Filename</i></th>

            </tr>
        </thead>
        <tbody class="table-data">

        <?php
            /*
            $query_exec = get_max_po_apprv_data();

            while ($row = mysqli_fetch_assoc($query_exec)) {

                if($row['relind'] == '1'){
                    $rel_stat = "<small><i class='fa fa-check-circle' style='color: green;'></i></small>";
                } else {
                    $rel_stat = "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";
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

                $filenm = getfileponame($row['po_num']); //.".pdf"

                //check file
                if ($filenm != "") {
                    //activate
                    $btnlink = 'A';
                    $file_exist = "<small><i class='fa fa-check-circle' style='color: green;'></i></small>";
                    $filepdf = $filenm.".pdf";
                } else {
                    $btnlink = 'N';
                    $file_exist = "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";
                    $filepdf = "-";
                }
                $dateformat = strtotime($row['doc_date']);
                $doc_date = date("d.m.Y", $dateformat);
         ?>

                <tr>
                    <td><?php echo $row['po_num']; ?></td>
                    <td><?php echo $row['plant']; ?></td>
                    <td><?php echo $row['id_vendor']; ?></td>
                    <td><?php echo $row['nm_vendor']; ?></td>
                    <td><?php echo $doc_date; ?></td>
                    <td><?php echo $vendor_mail; ?></td>
                    <td><?php echo $rel_stat; ?></td>
                    <td><?php echo $file_exist; ?></td>
                    <td><?php echo $filepdf; ?></td>
                </tr>

        <?php
                if($filenm != '') {
                    array_push($po_exist,  $row['po_num']);
                }

            }
        */
        ?>

        </tbody>

    </table>


</div>



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
<script>
    $(document).ready(function(){

        /*
        setInterval(function(){
            $("#example2").DataTable().ajax.reload();
        }, 5000);
        */

    });
</script>

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
            "order": ['5', 'asc'],
            "ajax": "purchasing_process/data/data-po-batch-mail.php",
            "columns": [
                { "data": "po_num" },
                { "data": "plant" },
                { "data": "id_vendor" },
                { "data": "nm_vendor" },
                { "data": "doc_date" },
                { "data": "mail" },
                { "data": "rel_stat" },
                { "data": "file_exist" },
                { "data": "upload_date" },
                { "data": "upload_group" },
                { "data": "filepdf" }
            ]
        } );
    });

</script>

<script>
    function mailfunction(){
        swal({
            title: 'Emailing',
            text: 'It may take a little longer, depends on your data...',
            allowOutsideClick: false,
            onOpen: function () {
                swal.showLoading()
            }
        })

    }
</script>

<!--
<script type="text/javascript">
    $(function() {
        $("#example1").dataTable();
        $('#example2').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false,
            "bProcessing": true,
            "ScrollX": true
        });
    });
</script>
-->

<!--
<script type="text/javascript">
    jQuery(function($){
        $('.table').footable();
    });
</script>
-->
