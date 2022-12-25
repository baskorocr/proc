<?php

    require "lib/excel_reader.php";
    include "purch-proc-query.php";
    include "project_mgt/project-mgt-query.php";
    include "function.php";
?>

<div class="box-header with-border">
   <h3 class="box-title">PO Approved List Master</h3>
   
       <div class="pull-right box-tools">
        <div class="btn-group">
            <a href="#" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
            <ul class="dropdown-menu pull-right" role="menu">

                <li><a href="home.php?mnu=batchpo" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                        <i class="fa fa-envelope"></i>Send Mail</a>
                </li>

            </ul>
        </div>
    </div>
	
</div>

<hr style="margin-top: 1px;">

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
                            if (isset($_POST['submit-find'])) {
                                $date_from      = trim($_POST['date_from']);
                                $date_to        = trim($_POST['date_to']);
                                $list_po        = rtrim($_POST['po_sel']);
                                $list_vendor    = rtrim($_POST['vend_sel']);
                            }
                        ?>
                        <input type="text" name="date_from" class="form-control datepicker input-sm" 
                            value = "<?php echo $date_from; ?>"/>
                        <div class="input-group-addon">
                            to
                        </div>
                        <input type="text"  name="date_to" class="form-control datepicker input-sm" 
                                value = "<?php echo $date_to; ?>"/>
                    </div>
                    <br>

                    <label>Purchase Order</label>
                    <textarea class="form-control" rows="3" name="po_sel" id="po_textarea"  placeholder="5111000xxx"><?php if (isset($_POST['submit-find'])) { echo $list_po; } ?></textarea>
                    <p class='text-right' ><a href="#" onclick="javascript:eraseText();">Clear</a></p>
                </div>

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

                                            if (isset($_POST['submit-find'])){
                                                if($id_vendor == $_POST['id_vendor']){
                                                    $v_selected = "selected";
                                                } else {
                                                    $v_selected = "";
                                                }
                                            }

                                            echo "<option value='$id_vendor' $v_selected >".$id_vendor." - ".$nm_vendor." (".$alias.")</option>";

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
                            <textarea class="form-control" rows="3" name="vend_sel" id="vend_textarea"  placeholder="100xxx "><?php if (isset($_POST['submit-find'])) { echo $list_vendor; } ?></textarea>
                            <p class='text-right' ><a href="#" onclick="javascript:eraseTextVend();">Clear</a></p>
                        </div>
                </div>
            </div>
            <br>
            
            <div class="input-group col-sm-3">
                <button type="submit" name="submit-find" class="btn btn-block btn-primary btn-sm" onclick="uploadDoc()">
                    <i class="fa fa-search"> Search</i>
                </button>
            </div>
        </form>                           
    </div>
</div>

  <?php
    
    if (isset($_POST['submit-find'])) {

        $date_from      = $_POST['date_from'];
        $date_to        = $_POST['date_to'];
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

        $query_ajax = 'purchasing_process/data/data-po-list-master.php?date_from='.$date_from.'&date_to='.$date_to.
                      '&po_list='.$polist.'&vend_list='.$vendlist;

    } else
    {
        $query_ajax = 'purchasing_process/data/data-po-list-master.php';
    }
  ?>

<!-- Selection section -->
<div class="box-body">

    <table id="example2" class="table table-bordered table-striped table-hover display nowrap"  style="width:100%">
    <thead>
            <tr>
                <th data-visible="true">PO Number</th>
                <th>Rev No</th>
                <th>Plant</th>
                <th data-breakpoints="xs">Vendor</th>
                <th data-breakpoints="xs">Vendor Name</th>
                <th data-breakpoints="xs">Vendor Mail</th>
                <th data-breakpoints="xs">Doc Date</th>
                <th data-breakpoints="xs">PGr</th>
				<th data-breakpoints="xs" title="without Tax">PO Amount</th>
                <th data-breakpoints="xs" title="with Tax">Total Amount</th>
                <th data-breakpoints="xs">Curr</th>
                <th data-placement="left" title="Release Status">
                    <i class="fa fa-check"></i>
                </th>
                <th data-placement="left" title="Email Status">
                    <i class="fa fa-envelope"></i>
                </th>
                <th data-placement="left" title="File Status">
                    <i class="fa fa-file"></i>
                </th>
                <th data-placement="left" title="Download Status">
                    <i class="fa fa-download"></i>
                </th>
                <th data-breakpoints="xs">Upload Date</th>
                <th data-breakpoints="xs">Upload Group</th>
                <th data-breakpoints="all">Filename</th>

            </tr>
        </thead>
        <tbody class="table-data"></tbody>
    </table>
</div>

<!-- ============ SCRIPT ================= -->
<!-- jQuery 2.0.2 -->
<script src="../jquery-2/jquery.min.js"></script>

<!-- Bootstrap -->
<script src="../js/bootstrap.min.js" type="text/javascript"></script>

<!-- AdminLTE App -->
<script src="../js/AdminLTE/app.js" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->

<script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="../js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>

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
            "lengthChange" : true,
            "sort"         : true,
            "paginate"     : true,
            "autowidth"    : false,
            'ajax': {
                "type"   : "POST",
                "url"    : <?php echo '"'.$query_ajax.'"'; ?> 
            },
            'columns': [
                { "data": "po_num" },
                { "data": "revno" },
                { "data": "plant" },
                { "data": "id_vendor" },
                { "data": "nm_vendor" },
                { "data": "mail" },
                { "data": "doc_date" },
                { "data": "purch_group" },
				{ "data": "po_val" },
                { "data": "tot_val" },
                { "data": "curr" },
                { "data": "rel_stat" },
                { "data": "mail_stat" },
                { "data": "file_exist" },
                { "data": "download_stat" },
                { "data": "upload_date" },
                { "data": "upload_group" },
                { "data": "filepdf" }
            ],
			"order": [[ 5, "desc" ]]
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
	
	/*
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });
	*/

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
