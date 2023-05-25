@extends('layouts.main')
@section('title',"Send Mail PO")
@section('content')
<style type="text/css">
  div.table-responsive > div.dataTables_wrapper > div.row
{
    overflow:auto !important;
}
</style>
 <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Send Mail PO</h1>
		<nav>
			<ol class="breadcrumb">
				{{-- <li class="breadcrumb-item"><a href="{{route('home')}}">Purchasing Process</a></li> --}}
				<li class="breadcrumb-item active">Send Mail PO</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
     

			<div class="row">
        <div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<div class="filter  " style=" margin-top: 10px;" align="right">
                <button send-mail class="btn btn-success btn-sm mb-2" select-all><i class="fas fa-envelope ml-2"></i> Send Mail</button>
                <br>
                <br>
              </div>
							<!-- <div class="filter mt-2 " align="right">
								<a class="btn btn-outline-secondary" href="#" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="bi bi-list"></i></a>
								<ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
									{{-- <li class="dropdown-header text-start"><h6>Filter</h6></li> --}}
									<li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#create-project" href="#"><i class="fas fa-plus-square"></i>Create Project</a></li>
									<li><a class="dropdown-item" href="#"><i class="fas fa-arrow-down"></i>Assign Project Details</a></li>
									<li><a class="dropdown-item" href="#"><i class="fa fa-table"></i>Project Assignment Data</a></li>
								</ul>
								
							</div> -->

              
							<div class="table-responsive mt-3">
								<table  class="table table-bordered table-striped nowrap table-sm" id="tb-list-po">
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
   <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
	<script>

      // $('#tb-list-po').DataTable().destroy();
       $.fn.dataTable.ext.errMode = 'none';
    var table = $('#tb-list-po').DataTable({autoWidth:false,
    "order": [[ 1, "DESC" ]],
    processing: true,
    serverSide: true,
    autoWidth:false,
    "language": {
    "processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
    },
    ajax: {
       type: 'POST',
        data: (item) => {
              item._token = '{{ csrf_token() }}';
     },
    url: "{{ route('datatables.purchasing.process.listposend')}}"
    },
    columns: [
    // {
    //   data: 'DT_RowIndex',
    //   name: 'DT_RowIndex'
    // },
    {
          data: 'po_num',
          name: 'po_num'
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
          data: 'doc_date',
          name: 'doc_date'
          },
         
          {
          data: 'vend_email',
          name: 'vend_email'
          },
          {
          data: 'rel_stat',
          name: 'rel_stat'
          },
          {
          data: 'file_exist',
          name: 'file_exist'
          },
          {
          data: 'upload_date',
          name: 'upload_date'
          },
          {
          data: 'upload_group',
          name: 'upload_group'
          },
          {
          data: 'file_nm',
          name: 'file_nm'
          },
    ]
    });
    
	</script>
	@endsection