<?php
/**
 * Copyright (c) 2018. Don't copy or use the source code without author permission for comercial purpose(s)
 */

require "lib/excel_reader.php";
//include "../conn/conn_proc.php";
include "purch-proc-query.php";
include "function.php";

include "project_mgt/project-mgt-query.php";
?>

<body>
<div class="box-header with-border">

   <h3 class="box-title">Download PO for Vendor</h3>


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
        //$id_vendor  = $row['id_vendor'];
        $data['id_vendor'] = $row['id_vendor'];

        $role = $_SESSION['role'];
    ?>

    <form role=form name="myForm" onSubmit="return downloadfunction()" action="zip_po_all.php" method="post" enctype="multipart/form-data">

        <table id="example2" class="table table-bordered table-striped display nowrap"  style="width:100%">
        <thead>
                <tr>
                    <th class="no-sort"><i class="fa fa-list"></i></th>
                    <th data-visible="true">PO Number</th>
                    <th>Plant</th>
                    <th data-breakpoints="xs">Vendor</th>
                    <th>Vendor Name</th>
                    <th>Doc. Date</th>
                    <th>PGr</th>
                    <th data-breakpoints="xs">Sent Date</th>
                    <th data-breakpoints="all"><i class="fa fa-envelope"></i></th>
                    <th data-breakpoints="all"><i class="fa fa-file"></i></th>
                    <th data-breakpoints="all"><i class="fa fa-download"></i></th>
                    <th data-breakpoints="all"><i class="fa fa-clock-o"></i></th>
                    <!--
                    <th data-breakpoints="all"><i class="fa fa-file"></i></th>
                    -->
                    <th data-breakpoints="all">File Ver.</th>

                </tr>
            </thead>
            <tbody class="table-data">

            <?php

                //$data['id_vendor'] = '211445';
                if($role == 'vendor') {
                    $query_exec = get_po_by_vendor($data);
                } else {
                    $query_exec = get_po_all_vendor();
                }

                $po_exist = array();

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

                    //$filenm = getfileponame($row['po_num']); //.".pdf"
                    $filenm = $row['file_nm'];

                    $diff = dateDifference($row['doc_date'] , date("Y-m-d"),'%m' );

                    //check file
                    if ($filenm != "-") {
                        //activate
                        $btnlink = 'A';
                        $stat = '';
                        $file_exist = "<small><i class='fa fa-check-circle' style='color: green;'></i></small>";

                        //$filepdf = $filenm.".pdf";
                        $filepdf = $filenm;

                        //3 months

                        if($diff >= 3){
                            $stat = 'disabled';
                        } else {
                            $stat = '';
                        }


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
                    //if($filenm != '') {

                    $dateformat = strtotime($row['doc_date']);
                    $doc_date = date("d.m.Y", $dateformat);

                    $dateformat_sent = strtotime($row['sent']);
                    $mail_sent = date("d.m.Y H:i", $dateformat_sent);

            ?>

                        <tr>
                            <td><input type="checkbox" name="selectpo[]" value="<?php echo $filepdf; ?>" <?php echo $stat; ?> >
                            </td>
                            <td><?php echo $row['po_num']; ?></td>
                            <td><?php echo $row['plant']; ?></td>
                            <td><?php echo $row['id_vendor']; ?></td>
                            <td><?php echo $row['nm_vendor']; ?></td>
                            <td><?php echo $doc_date; ?></td>
                            <td><?php echo $row['pgr']; ?></td>
                            <!--
                        <td><a href='get-po.php?po=<?php echo $row['po_num']; ?>' target='_blank' ><h4><span class='badge bg-green'>Click Here <i class='fa fa-download'></i></span></h4></a></td>
                        -->
                            <td><?php echo $mail_sent; ?></td>
                            <td><?php echo $mail_stat; ?></td>
                            <td><?php echo $file_exist; ?></td>
                            <td><?php echo $dwld_stat; ?></td>
                            <td><?php echo $active; ?></td>

                            <td><?php echo $filepdf; ?></td>


                            <!-- Link download expired 3 bulan terhitung dari doc date -->
                            <!--
                            <td>
                            -->
                                <?php

                                if ($btnlink == 'A') {

                                    ?>
                                    <!--
                                    <form role=form name="myForm" id="myForm" onSubmit="" action=""
                                          method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="po" value="<?php echo $row['po_num']; ?>">
                                        <input type="submit" name="dwlpo" class="btn btn-flat btn-success left"
                                               value="Download">

                                    </form>
                                    -->

                                    <?php

                                }
                                ?>
                            <!--
                            </td>
                            -->

                        </tr>

            <?php
                    if($filenm != '') {
                        array_push($po_exist,  $row['po_num']);
                    }
                }

            ?>

            </tbody>

        </table>

        <?php

            //$count_data = mysql_num_rows($query_exec);
            $count_data = count($po_exist);

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

    if(isset($_POST['dwlpo'])){

        $data['po_num'] = $_POST['po'];
        //download status update
        update_po_download_mail($data);

        if(update_po_download_mail($data)) {

?>
            <script>
                var po = "<?php echo $_POST['po'];?>";
                window.location = 'get-po.php?x=' + po;
            </script>
<?php
        }
    }

?>


<?php

    /*
    if(isset($_POST['checked-po'])){

        $count_select = count($_POST['selectpo']);
        $checked_po = $_POST['selectpo'];

        $files = array();

        for($i=0; $i < $count_select; $i++){


            echo '
                <script>
                    alert("'.$checked_po[$i].'")
                </script>
            ';


            array_push($files, $checked_po[$i]);
        }
        */
    ?>

        <!--
        <script>
            var polist = "<?php $files; ?>";
            window.location = 'zip_po_all.php?z=' + polist;
        </script>
        -->

<?php
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
            
            /*
            "columnDefs": [{
                "orderable": false,
                "targets": "no-sort"
            }],
            */

            "paginate"     : true,
            "autowidth"    : false
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
