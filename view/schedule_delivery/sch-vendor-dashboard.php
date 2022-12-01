<?php

include "schedule-delivery-query.php";

        $id_user = $_SESSION['id_user'];

        $query = get_vendor_user($id_user);
        $row = mysqli_fetch_assoc($query);
        //$id_vendor  = $row['id_vendor'];
        $data['id_vendor'] = isset($row['id_vendor']) ? $row['id_vendor'] : '';

?>

<div class="box-header with-border">
   <h3 class="box-title">Monitoring Delivery Schedule</h3>

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
            <th data-breakpoints="xs">Vendor Name</th>
            <th data-breakpoints="xs sm">Total Kanban</th>
            <th data-breakpoints="xs sm">Scan Stat</th>
            <th data-breakpoints="xs sm">GR Stat</th>
            <th data-breakpoints="xs sm">MF Stat</th>
            <th data-breakpoints="xs sm"><i class="fa fa-list-ul"></i></th>
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
<!-- AdminLTE App -->
<script src="../js/AdminLTE/app.js" type="text/javascript"></script>

<!-- page script -->
<script>
    $(document).ready(function(){

        /*
        function refreshdata() {
            $('#kanban-stat').load(document.URL +  ' #kanban-stat');
            $('#scan-stat').load(document.URL +  ' #scan-stat');
            $('#receive-stat').load(document.URL +  ' #receive-stat');
            $('#open-stat').load(document.URL +  ' #open-stat');
        }



        function load_unseen_notification(view = '')
        {
            $.ajax({
                url:"../schedule_delivery/data/fetch-manifest-data.php",
                method:"POST",
                data:{view:view},
                dataType:"json",
                success:function(data)
                {
                    $('.dropdown-menu').html(data.notification);
                    $('.table-data').html(data.table_data);
                     if(data.unseen_notification > 0)
                     {
                     $('.count').html(data.unseen_notification);
                     }

                }
            });
        }

        load_unseen_notification();


        setInterval(function(){
            load_unseen_notification();
        }, 5000);
        */

        setInterval(function(){
            $("#example2").DataTable().ajax.reload(null, false);
        }, 30000);

    });
</script>

<script type="text/javascript">
    var path;
    var role = "<?php echo $_SESSION['role'];?>";
    var idvendor = "<?php echo $data['id_vendor'];?>";
    if(role == 'vendor'){
        path = "schedule_delivery/data/data-manifest-all-vendor.php?idv=" + idvendor;
    }else{
        path = "schedule_delivery/data/data-manifest-all.php";
    }

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
            "ajax": path,
            "columns": [
                { "data": "manifest" },
                { "data": "delivery_date" },
                { "data": "po_num" },
                { "data": "nm_vendor" },
                { "data": "stat_kanban" },
                { "data": "scan_stat" },
                { "data": "receive_stat" },
                { "data": "active_stat" },
                { "data": "buttons" }
            ],
			"order": [[ 1, "desc" ]]
        } );
    });

</script>


