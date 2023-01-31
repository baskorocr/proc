@extends('layouts.main')
@section('title',"Download List PO")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Download List PO</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Purchasing Process</a></li>
				<li class="breadcrumb-item active">Download List PO</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
      
    <div class="row">
          <div class="col-lg-6">
            <div class="">
              <label>Document Date</label>
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
              </div>
          </div>
          <div class="col-lg-6">
            <div>
              <label class="col-sm-5 col-form-label">Vendor</label>
                  <div class="col-sm-10">
                      <select class="form-select select2" id="select_vendor" aria-label="Default select example">
                      <option selected>Choose Vendor</option>
                      @foreach($list_vendor as $vendor)
                      <option value="{{ $vendor->id_vendor }}">{{ $vendor->id_vendor }} - {{ $vendor->nm_vendor }}</option>
                      @endforeach
                      </select>
                  </div>
              </div>
          </div>
        </div>

        <div class="col-lg-5">              
          <label>Purchase Order</label>
          <textarea class="form-control" rows="3" name="po_sel" id="po_textarea"  placeholder="5111000xxx"><?php if (isset($_POST['submit-find'])) { echo $list_po; } ?></textarea>
          <!-- <p class='text-right' ><a href="#" onclick="javascript:eraseText();">Clear</a></p> -->

          <div class="input-group col-sm-3" style="margin-top: 10px; margin-bottom: 5px">
              <button type="submit" name="submit-find" class="btn btn-primary" onclick="search()">
                  <i class="fa fa-search"></i> Search
              </button>
              <button type="download" name="download-find" class="btn btn-primary" style="margin-left: 5px" onclick="download()">
                  <i class="fa fa-download"> Download</i>
              </button>
          </div>
        </div>


			<div class="row">
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
								<table  class="table table-bordered table-stripped table-sm" id="tb-download-list-po">
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

        var table = $('#tb-download-list-po').DataTable({
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
                item.id_vendor = $('#select_vendor').val().toString();
            },
            url:"{{ route('datatables.purchasing.process.download.listpo')}}",
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

      $('.select2').select2();
	
	</script>
	@endsection