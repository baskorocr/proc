<?php
/**
 * Copyright (c) 2018. Don't copy or use the source code without author permission for comercial purpose(s)
 */

include "schedule-delivery-query.php";

if(isset($_POST['mfmat'])){
    $manifest = $_POST['mf'];
    //echo $manifest;
    //echo "<script>alert('$manifest');</script>";
} else {
    $manifest = null;
}

?>

<div class="box-header with-border">
   <h3 class="box-title">Monitoring Delivery Schedule - Detail Material</h3>
	
	<!--
    <div class="pull-right box-tools">
        <div class="btn-group">
            <a href="#" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
            <ul class="dropdown-menu pull-right" role="menu">

            </ul>
        </div>
    </div>
	-->

</div>
<hr style="margin-top: 1px;">

<div class="box-body">

    <table id="example2" class="table table-bordered table-striped display nowrap"  style="width:100%">
        <thead>
        <tr>
            <th>Manifest</th>
            <th>Delivery Date</th>
            <th>PO Number</th>
            <th data-breakpoints="xs">Vendor</th>
            <th>Itm</th>
            <th>Material</th>
            <th style="column-width:500px;">Material Descr.</th>
            <th data-breakpoints="xs">UoM</th>
            <th data-breakpoints="xs sm">Qty</th>
            <th data-breakpoints="xs sm">Kanban</th>
            <th data-breakpoints="xs sm">GR Stat</th>
            <!--
            <th data-breakpoints="xs sm">MF Stat</th>
            -->

        </tr>
        </thead>
        <tbody class="table-data">

        </tbody>

    </table>

</div>


<!-- ============ SCRIPT ================= -->
<!-- jQuery 2.0.2 -->
<script src="../ajax/ajax-jquery.min.js"></script>

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

<script>
    $(document).ready(function(){

        /*
        function load_unseen_notification(view = '')
        {
            $.ajax({
                url:"schedule_delivery/data/fetch-data-manifest-material.php",
                method:"POST",
                data:{view:view},
                dataType:"json",
                success:function(data)
                {
                    $('.table-data').html(data.table_data);
                }
            });
        }


        load_unseen_notification();
        setInterval(function(){
            load_unseen_notification();
        }, 5000);
        */

        setInterval(function(){
            //$("#example2").dataTable().ajax().load();
            $("#example2").DataTable().ajax.reload();
        }, 5000);


    });
</script>

<script type="text/javascript">
    $(function() {
        var mf = "<?php echo $manifest; ?>";

        $("#example2").dataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel'
            ],
            "scrollX": true,
            "filter" : true,
            "lengthChange" : false,
            "sort"         : true,
            "paginate"     : true,
            "autowidth"    : false,
            "ajax": "schedule_delivery/data/data-manifest-material.php?id=" + mf,
            "columns": [
                { "data": "manifest" },
                { "data": "delivery_date" },
                { "data": "po_num" },
                { "data": "nm_vendor" },
                { "data": "item" },
                { "data": "material" },
                { "data": "material_desc" },
                { "data": "uom" },
                { "data": "stat_qty" },
                { "data": "stat_kanban" },
                //{ "data": "scan_stat" },
                { "data": "receive_stat" },
                //{ "data": "active_stat" }
            ],
			"order": [[ 1, "desc" ]]
        } );
    });

</script>
