@extends('layouts.main')
@section('title',"List PO")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>List PO</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
				<li class="breadcrumb-item active">List PO</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">

                <div class="col-lg-3">
                    <label>Document Date</label>
                    <div class="">
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
                        <div class="" style="width: 200px;">
                            <!-- <i class="fa fa-calendar"></i> -->
                            from
                            <input type="date" name="date_from" id="date_from" class="form-control" value = "<?php if (isset($_POST['submit-find'])) {echo $date_from;} ?>"/> to 
                            <input type="date" name="date_to" id="date_to" class="form-control" value = "<?php if (isset($_POST['submit-find'])) {echo $date_to;} ?>"/>
                        </div>
                        <!-- <div class="" style="width: 105px;">
                            to
                        </div>
                        <input type="date" name="date_to" class="form-control" value = "<?php echo $date_to; ?>"/> -->
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-5 col-form-label">Vendor</label>
                        <div class="col-sm-10">
                            <select class="form-select" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                    <br>

                    <label>Purchase Order</label>
                    <textarea class="form-control" rows="3" name="po_sel" id="po_textarea"  placeholder="5111000xxx"><?php if (isset($_POST['submit-find'])) { echo $list_po; } ?></textarea>
                    <!-- <p class='text-right' ><a href="#" onclick="javascript:eraseText();">Clear</a></p> -->

                    <div class="input-group col-sm-3" style="margin-top: 10px; margin-bottom: 5px">
                        <button type="submit" name="submit-find" class="btn btn-primary" onclick="search()">
                            <i class="fa fa-search"></i> Search
                        </button>
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

				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							
							<div class="filter mt-2 " align="right">
								<a class="btn btn-outline-secondary" href="#" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="bi bi-list"></i></a>
								<ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
									{{-- <li class="dropdown-header text-start"><h6>Filter</h6></li> --}}
									<li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#create-project" href="#"><i class="fas fa-plus-square"></i>Create Project</a></li>
									<li><a class="dropdown-item" href="#"><i class="fas fa-arrow-down"></i>Assign Project Details</a></li>
									<li><a class="dropdown-item" href="#"><i class="fa fa-table"></i>Project Assignment Data</a></li>
								</ul>
								
							</div>

							<div class="table-responsive mt-3">
								<table  class="table table-bordered table-stripped table-sm" id="tb-list-po">
									<thead>
										<th>#</th>
										<th>PO Number</th>
                                        <th>Rev No</th>
                                        <th>Plant</th>
                                        <th>Vendor</th>
                                        <th>Vendor Name</th>
                                        <th>Vendor Mail</th>
                                        <th>Doc Date</th>
                                        <th>Pgr</th>
                                        <th>Curr</th>
                                        <th>Filename</th>
									</thead>
									<tbody>
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
	@endsection
	@section('javascript')
	<script>
		
	// 	$(document).ready(function(){

	// 	window.table = $('#tb-list-po').DataTable({
	// 		columnDefs: [
	// {
	// searchable: false,
	// orderable: false,
	// targets: 0,
	// }],

		// 	"order": [[ 1, "DESC" ]],
		// 	processing: true,
		// 	serverSide: true,
		// 	autoWidth:false,
		// 	"language": {
		// 	"processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
		// 	},
		// 	ajax: "{{ route('datatables.purchasing.process.listpo')}}",
		// 	columns: [
        //         {
		// 				data: 'DT_RowIndex',
		// 				name: 'DT_RowIndex'
		// 				},
		// 				{
		// 				data: 'po_num',
		// 				name: 'po_num'
		// 				},
		// 	]
		// 	});
		// window.table.on('order.dt search.dt', function () {
		// let i = 1;
		
		// window.table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
		// this.data(i++);
		// });
		// }).draw();
		// })

        var table = $('#tb-list-po').DataTable({
        "order": [[ 1, "DESC" ]],
        processing: true,
        serverSide: true,
        autoWidth:false,
        "language": {
        "processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
        },
        ajax: {
            data: (item) => {
                item.po_num = $('#po_textarea').val();
                item.date_from = $('#date_from').val();
                item.date_to = $('#date_to').val();
            },
            url: "{{ route('datatables.purchasing.process.listpo')}}"
        },
        columns: [
          {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
          },
          {
            data: 'po_num',
            name: 'po_num'
          },
          {
            data: 'revno',
            name: 'revno'
          },
          {
            data: 'plant',
            name: 'plant'
          },
          {
            data: 'id_vendor',
            name: 'id_vendor'
          },
          {
            data: 'nm_vendor',
            name: 'nm_vendor'
          },
          {
            data: 'vend_email',
            name: 'vend_email'
          },
          {
            data: 'doc_date',
            name: 'doc_date'
          },
          {
            data: 'pgr',
            name: 'pgr'
          },
          {
            data: 'curr',
            name: 'curr'
          },
          {
            data: 'file_nm',
            name: 'file_nm'
          },
        ]
      });

      function search() {
        table.draw(); 
      }
	
	</script>
	@endsectionq
