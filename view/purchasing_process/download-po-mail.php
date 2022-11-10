<?php

require "lib/excel_reader.php";
include "purch-proc-query.php";
include "function.php";

include "project_mgt/project-mgt-query.php";
?>

<body>
<div class="box-header with-border">
   <h3 class="box-title">Download PO for Vendor</h3>
</div>

<hr style="margin-top: 1px;">


<?php
    $id_user = $_SESSION['id_user'];

    $query = get_vendor_user($id_user);
    $row = mysqli_fetch_assoc($query);
    //$id_vendor  = $row['id_vendor'];
    $data['id_vendor'] = isset($row['id_vendor']) ? $row['id_vendor'] : '';

    $role = $_SESSION['role'];
?>

<!-- Selection section -->
<div class="box box-solid box-primary">
    <div class="box-header colps">
        <h4 class="box-title" style="font-size:15px">Search Option</h4>
        <div class="box-tools pull-right">
            <button class="btn btn-primary btn-sm" ><i class="fa fa-minus"></i></button>
        </div>
    </div>

    <div class="box-body">
        <form role=form name="myForm" onSubmit="return myLoader()" action="" method="post" enctype="multipart/form-data">
            
            <div class = "row">
                <div class="col-lg-3">
                    <label>Document Date</label>
                    <div class="input-group">
                        <div class="input-group-addon input-sm">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <?php 
                            $date_from = "";
                            $date_to = "";
                            $list_po;
                            $list_vendor;
                            if (isset($_POST['submit-find']) ||
                                isset($_POST['submit-check']) ||
                                isset($_POST['submit-uncheck']) ||
                                isset($_POST['checked-po'])
                            ) 
                            {
                                $date_from      = trim($_POST['date_from']);
                                $date_to        = trim($_POST['date_to']);
                                $list_po        = rtrim($_POST['po_sel']);
                                $list_vendor    = rtrim($_POST['vend_sel']);
                            }
                        ?>
                        <input type="text" name="date_from" class="form-control datepicker input-sm"
                            value = "<?php echo $date_from; ?>" />
                        
                        <div class="input-group-addon">
                            to
                        </div>
                        <input type="text"  name="date_to" class="form-control datepicker input-sm" 
                            value = "<?php echo $date_to; ?>"/>
                    </div>
                    
                    <br>
                    <label>Purchase Order</label>
                    <textarea class="form-control" id="po_textarea" rows="3" name="po_sel" placeholder="5111000xxx"><?php 
                    if (isset($_POST['submit-find']) ||
                        isset($_POST['submit-check']) ||
                        isset($_POST['submit-uncheck']) ||
                        isset($_POST['checked-po'])
                        )  
                    { echo $list_po; } 
                    ?></textarea>
                    <p class='text-right' ><a href="#" onclick="javascript:eraseText();">Clear</a></p>

                </div>
                
        <?php
            if ( $data['id_vendor'] == '')
            {
        ?>

                <div class="col-lg-4">
                    <label>Choose Vendor</label>
                        <div class="input-group">
                            <select class="form-control selectpicker" name="id_vendor" id="select_vend" data-live-search="true">
                                <option></option>
                                <?php

                                        $query_exec = get_all_active_vendor_data();
                                        $v_selected = "";
                                        while ($row = mysqli_fetch_assoc($query_exec)) {
                                            $id_vendor = $row['id_vendor'];
                                            $nm_vendor = $row['nm_vendor'];
                                            $alias = $row['allias'];

                                            if ( (isset($_POST['submit-find'])) || 
                                                 (isset($_POST['submit-check'])) || 
                                                 (isset($_POST['submit-uncheck'])) )
                                            {
                                                if($id_vendor == $_POST['id_vendor']){
                                                    $v_selected = "selected";
                                                } else {
                                                    $v_selected = "";
                                                }
                                            }

                                            echo "<option value='$id_vendor' $v_selected>".$id_vendor." - ".$nm_vendor." (".$alias.")</option>";

                                        }

                                ?>
                            </select>
                            <span class="input-group-btn">
                                <button class="btn btn-primary btn-flat" title="add to Vendor selection" type="button" 
                                        onclick="javascript:add_vendor_to_selection();">
                                <i class="fa fa-plus-square"></i>
                                </button>
                            </span>
                        </div>
                        
                        <div class="row col-lg-5">
                            <textarea class="form-control" rows="3" name="vend_sel" id="vend_textarea"  placeholder="100xxx "><?php 
                            if (isset($_POST['submit-find']) ||
                                isset($_POST['submit-check']) ||
                                isset($_POST['submit-uncheck']) ||
                                isset($_POST['checked-po'])
                                )  
                            { echo $list_vendor; } 
                            ?></textarea>
                            <p class='text-right' ><a href="#" onclick="javascript:eraseTextVend();">Clear</a></p>
                        </div>
                </div>
        <?php
        } else {

        ?>
                    
            <input type="hidden" name="vend_sel" value = "<?php echo $data['id_vendor']; ?>" />
            <input type="hidden" name="id_vendor" value = "<?php echo $data['id_vendor']; ?>" />
        <?php
        }
        ?>

            </div>
            <br>

            <div class="input-group col-sm-3">
                <button type="submit" name="submit-find" class="btn btn-block btn-primary btn-sm" onclick="uploadDoc()">
                    <i class="fa fa-search"> Search</i>
                </button>
            </div>

    </div>
</div>

                <?php 
                $check = "";
                    if (isset($_POST['submit-check'])) 
                    {
                ?>
                    <button type="submit" name="submit-uncheck" class="btn btn-flat btn-sm" >
                        <i class="fa fa-check-square"> Deselect-All</i>
                    </button>
                <?php
                    $check = "X";
                    }
                ?>

                <?php 
                    if (isset($_POST['submit-uncheck']) OR $check == "") 
                    {
                ?>
                    <button type="submit" name="submit-check" class="btn btn-flat btn-sm">
                        <i class="fa fa-square-o"> Select-All</i>
                    </button>
                <?php
                    }
                ?>

        </form>

<!-- Selection section -->
<div class="box-body">

    <?php
        /*
        $id_user = $_SESSION['id_user'];

        $query = get_vendor_user($id_user);
        $row = mysqli_fetch_assoc($query);
        //$id_vendor  = $row['id_vendor'];
        $data['id_vendor'] = $row['id_vendor'];

        $role = $_SESSION['role'];
        */
    ?>
    <!--
    <form role=form name="myForm" onSubmit="" action="" method="post" enctype="multipart/form-data">
    -->
        <table id="example2" class="table table-bordered table-striped display nowrap"  style="width:100%">
        <thead>
                <tr>
                    <th class="no-sort"><i class="fa fa-list"></i></th>
                    <th data-visible="true">PO Number</th>
                    <th>Rev No</th>
                    <th>Plant</th>
                    <th data-breakpoints="xs">Vendor</th>
                    <th>Vendor Name</th>
                    <th>Doc. Date</th>
                    <th>PGr</th>
					<th data-breakpoints="xs" title="without Tax">PO Amount</th>
                    <th data-breakpoints="xs" title="with Tax">Total Amount</th>
                    <th data-breakpoints="xs">Curr</th>
                    <th data-breakpoints="xs">Sent Date</th>
                    <th data-placement="left" title="Email Status">
                        <i class="fa fa-envelope"></i>
                    </th>
                    <th data-placement="left" title="File Status">
                        <i class="fa fa-file"></i>
                    </th>
                    <th data-placement="left" title="Download Status">
                        <i class="fa fa-download"></i>
                    </th>
                    <th data-placement="left" title="Active Status (3 Months)">
                        <i class="fa fa-clock-o"></i>
                    </th>
                    <!--
                    <th data-breakpoints="all"><i class="fa fa-file"></i></th>
                    -->
                    <th data-breakpoints="all">File Ver.</th>

                </tr>
            </thead>
            <tbody class="table-data">
                <!-- fill by AJAX -->
            </tbody>

        </table>

        <?php

            //$count_data = mysql_num_rows($query_exec);//
            //$count_data = count($po_exist);

            //if ($count_data >= 1) {
                ?>

                <div class="">
                        <!-- post array -->

                        <div class="box-footer">
                            <button type="input" onclick="myFunction()" name="checked-po" class="btn btn-flat btn-success"><i
                                        class="fa fa-download"></i> Download Checked
                            </button>
                        </div>

                </div> 

        <?php
            //}
        ?>
    <!--
    </form>
    -->

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

    if(isset($_POST['checked-po'])){

        /*
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
        <script>
            //var polist = "<?php $files; ?>";
            //window.location = 'zip_po_all.php?z=' + polist;
        </script>
<?php
    }
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
    
    if (isset($_POST['submit-find'])) {

        $date_from      = trim($_POST['date_from']);
        $date_to        = trim($_POST['date_to']);
        $list_po        = rtrim($_POST['po_sel']);
        $list_vendor    = rtrim($_POST['vend_sel']);
        $id_vendor      = $_POST['id_vendor'];

        if ( $date_from != "" || $date_to != "" )
        {
            if ($date_to == ""){
                $date_to = $date_from;
            } 
            else {}
        }

        if ($list_vendor == "" ) {
            $list_vendor = $id_vendor;
        }

        $polist = preg_replace('/\s+/', ',', $list_po);
        $vendlist = preg_replace('/\s+/', ',', $list_vendor);

        $po_ajax = 'date_from='.$date_from.'&date_to='.$date_to.'&po_list='.$polist.'&vend_list='.$vendlist;
    } else
    {
        $po_ajax = '';
    }
?>

<?php
    if (isset($_POST['submit-uncheck'])) 
    {
        $check = "";
        $check_ajax = "&check=";

        $date_from      = trim($_POST['date_from']);
        $date_to        = trim($_POST['date_to']);
        $list_po        = rtrim($_POST['po_sel']);
        $list_vendor    = rtrim($_POST['vend_sel']);
        $id_vendor      = $_POST['id_vendor'];

        if ( $date_from != "" || $date_to != "" )
        {
    
            if ($date_to == ""){
                $date_to = $date_from;
            } 
            else {}
        }

        if ($list_vendor == "" ) {
            $list_vendor = $id_vendor;
        }

        $polist = preg_replace('/\s+/', ',', $list_po);
        $vendlist = preg_replace('/\s+/', ',', $list_vendor);

        $po_ajax = 'date_from='.$date_from.'&date_to='.$date_to.'&po_list='.$polist.'&vend_list='.$vendlist.$check_ajax;
    }
  

    if (isset($_POST['submit-check'])) 
    {
        $check = "";
        $check_ajax = "&check=X";

        $date_from      = trim($_POST['date_from']);
        $date_to        = trim($_POST['date_to']);
        $list_po        = rtrim($_POST['po_sel']);
        $list_vendor    = rtrim($_POST['vend_sel']);
        $id_vendor      = $_POST['id_vendor'];

        if ( $date_from != "" || $date_to != "" )
        {
    
            if ($date_to == ""){
                $date_to = $date_from;
            } 
            else {}
        }

        if ($list_vendor == "" ) {
            $list_vendor = $id_vendor;
        }
        
        $polist = preg_replace('/\s+/', ',', $list_po);
        $vendlist = preg_replace('/\s+/', ',', $list_vendor);

        $po_ajax = 'date_from='.$date_from.'&date_to='.$date_to.'&po_list='.$polist.'&vend_list='.$vendlist.$check_ajax;
    }
    
?>

<?php
    
    if ( $data['id_vendor'] != '' ) {
        $query_ajax = "purchasing_process/data/data-download-po-mail.php?id_vendor=".$data['id_vendor']."&".$po_ajax;
    } else {
        $query_ajax = "purchasing_process/data/data-download-po-mail.php?".$po_ajax;
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
<script src="../js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>

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
            "columnDefs": [{
                "orderable": false,
                "className": 'select-checkbox',
                "targets": 0
            }],
            "select": {
                "style": 'os',
                "selector": 'td:first-child'
            },
            "order": [
                [1, 'asc']
            ],
            */
            "scrollX": true,
            "filter" : true,
            "lengthChange" : true,
            "sort"         : true,
            "paginate"     : true,
            "autowidth"    : false,
            'ajax': {
                "type"   : "POST",
                "url"    : <?php echo '"'.$query_ajax.'"'; ?>
            },
            'columns': [
                { "data": "list" },
                { "data": "po_num" },
                { "data": "revno" },
                { "data": "plant" },
                { "data": "id_vendor" },
                { "data": "nm_vendor" },
                { "data": "doc_date" },
                { "data": "purch_gr" },
				{ "data": "po_val" },
                { "data": "tot_val" },
                { "data": "curr" },
                { "data": "send_date" },
                { "data": "mail_stat" },
                { "data": "file_exist" },
                { "data": "download_stat" },
                { "data": "active" },
                { "data": "filepdf" }
            ]
			/*,"order": [[ 1, "desc" ]]*/
  
        } ).ajax.reload();   
    });

</script>

<script>
    $(".datepicker").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    function eraseText() {
        document.getElementById("po_textarea").value = "";
    }

    function eraseTextVend() {
        document.getElementById("vend_textarea").value = "";
    }
    
    function add_vendor_to_selection(){
        var select = document.getElementById('select_vend');
        var select_vendor = select.options[select.selectedIndex].value; //text
        var vendor = document.getElementById('vend_textarea').innerHTML;

        if (select_vendor == "")
        {
            vendor = select_vendor;
        } else {
            vendor = select_vendor + '\r\n' + vendor;
        }
        
        document.getElementById('vend_textarea').innerHTML = vendor;
    }

    document.addEventListener('contextmenu', function(e) {
       e.preventDefault();
    });

    $(".colps").click(function () {

        $header = $(this);
        //getting the next element
        $content = $header.next();
        //open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
        $content.slideToggle(500, function () {
            //execute this after slideToggle is done
            //change text of header based on visibility of content div
            /*
            $header.text(function () {
                //change text based on condition
                return $content.is(":visible") ? "Collapse" : "Expand";
            });
            */
        });

    });
    
</script>

<script>
    function myFunction() {
    
        const pochecked = [];
        var oTable = $('#example2').dataTable();
        var rowcollection =  oTable.$(".call-checkbox:checked", {"page": "all"});
        rowcollection.each(function(index,elem){
            var checkbox_value = $(elem).val();
            //Do something with 'checkbox_value'
            //alert(checkbox_value);
            pochecked.push(checkbox_value);
        });

        var polist = pochecked.toString();

        if (polist == "")
        {
            swal({
                    title: 'Error',
                    text: 'No PO selected!',
                    type: 'error',
                    allowOutsideClick: false
                })
            
        } else{
            var link = "zip_po_all.php?listpo=" + polist;
            window.location = link;
        }
        
        //console.log(link);

    }
</script>
