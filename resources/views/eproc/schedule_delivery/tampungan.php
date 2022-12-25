<?php

include "schedule-delivery-query.php";

?>

    <div class="box-header with-border">
        <h3 class="box-title">Monitoring Delivery Schedule</h3>

        <div class="pull-right box-tools">
            <div class="btn-group">
                <a href="#" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
                <ul class="dropdown-menu pull-right" role="menu">

                    <!--
                    <li><a href="#import-data" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                            <i class="fa fa-upload"></i>Create/Update from Excel</a>
                    </li>
                    -->
                    <!---

                        auto refresh idea

                        get status manifest header
                        if manifest header status is P (which is on progress)
                            refresh element every 3 seconds
                        elseif manifest header status is D (which is done)
                            stop refresh
                        else
                            do nothing
                        endif

                    -->

                </ul>
            </div>
        </div>

    </div>
    <hr style="margin-top: 1px;">

    <div class="box-body">

        <table id="example2" class="table table-bordered table-striped display nowrap"  style="width:100%">
            <thead>
            <tr>
                <th>Manifest</th>
                <th>Delivery Date</th>
                <th>PO Number</th>
                <th data-breakpoints="xs">Vendor Name</th>
                <th data-breakpoints="xs sm">Tot Kbn</th>
                <th data-breakpoints="xs sm">IN Kbn</th>
                <th data-breakpoints="xs sm"><i class="fa fa-barcode"></i></th>
                <th data-breakpoints="xs sm"><i class="fa fa-inbox"></i></th>
                <th data-breakpoints="xs sm"><i class="fa fa-check"></i></th>
                <th data-breakpoints="xs sm"><i class="fa fa-list-ul"></i></th>
            </tr>
            </thead>
            <tbody class="table-data">
            <?php
            $query_exec = get_all_manifest_group_2();

            while ($row = mysqli_fetch_assoc($query_exec)) {

                if ($row['stat'] == "P"){
                    if ($row['qty_tot'] == $row['tot_qty_in']){
                        $scan_stat = "<small><h4><span class='badge bg-green'>Done</span></h4></small>";
                    } else{
                        $scan_stat = "<small><h4><span class='badge bg-yellow'>On Progress</span></h4></small>";
                    }
                } else {
                    $scan_stat = "<small><h4><span class='badge bg-orange'>Waiting</span></h4></small>";
                }

                if($row['active'] != 'A'){
                    $active_stat = "<small><h4><span class='badge bg-green'>Open</span></h4></small>";
                } else {
                    $active_stat = "<small><h4><span class='badge bg-red'>Closed</span></h4></small>";
                }


                $dateformat = strtotime($row['delivery_date']);
                $dlv_date = date("d.m.Y", $dateformat);
                ?>

                <tr>
                    <td><?php echo $row['manifest']; ?></td>
                    <td><?php echo $dlv_date; ?></td>
                    <td><?php echo $row['po_num']; ?></td>
                    <td><?php echo $row['nm_vendor']; ?></td>
                    <td><?php echo $row['tot_kanban']; ?></td>
                    <td><?php echo $row['in_kanban']; ?></td>
                    <td><?php echo $scan_stat;?></td>
                    <td><small><h4><span class='badge bg-orange'>Waiting</span></h4></small></td>
                    <td><?php echo $active_stat;?></td>
                    <td align="center">
                        <a href="home.php?<?php echo token(); ?>mnu=mfmtr<?php echo token2(); ?>" data-toggle='' title='material' target="_blank">
                            <button class='btn-success'><i class='fa fa-sitemap'></i></button>
                        </a>

                        <a href="home.php?<?php echo token(); ?>mnu=mfkbn<?php echo token2(); ?>" data-toggle='' title='kanban' target="_blank">
                            <button class='btn-primary'><i class='fa fa-files-o'></i></button>
                        </a>
                    </td>
                </tr>

                <?php
            }
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
    <!--
    <script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    -->

    <script src="../css/footable/js/footable.min.js" type="text/javascript"></script>

    <!-- AdminLTE App -->
    <script src="../js/AdminLTE/app.js" type="text/javascript"></script>

    <!-- page script -->
    <!--
    <script type="text/javascript">
        $(function() {
            $("#example1").dataTable();
            $('#example2').dataTable({
                "bPaginate": true,
                "bLengthChange": true,
                "bFilter": false,
                "bSort": true,
                "bInfo": true,
                "bAutoWidth": false,
                "bProcessing": true,
                "scroller":       true
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

    <script type="text/javascript">
        $(function() {
            $("#example2").dataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel'
                ],
                "scrollX": true,
                "filter" : true,
                "lengthChange" : false,
                "sort"         : false,
                "paginate"     : true,
                "autowidth"    : false
            } );
        });

    </script>
<?php
/**
 * Copyright (c) 2018. Don't copy or use the source code without author permission for comercial purpose(s)
 */

/**
 * Created by PhpStorm.
 * User: USER
 * Date: 13/08/2018
 * Time: 9:58
 */