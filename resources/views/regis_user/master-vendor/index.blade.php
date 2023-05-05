@extends('layouts.main')
@section('title',"Master Vendor ")
@section('content')
<style>
	table.dataTable thead tr th {
    word-wrap: break-word;
    word-break: break-all;
}
</style>
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Master Vendor</h1>
		<nav>
			<ol class="breadcrumb">
				{{-- <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li> --}}
				<li class="breadcrumb-item active">Master Vendor</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<div class="filter mt-2 " align="right">
						
								<a class="btn btn-outline-secondary" href="#" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="bi bi-list"></i></a>
								<ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
									{{-- <li class="dropdown-header text-start"><h6>Filter</h6></li> --}}
									<li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#create-vendor" href="#"><i class="fas fa-plus-square"></i>Create Vendor</a></li>	<li><a class="dropdown-item" href="{{route('regis-user.upload.vendor')}}"><i class="fas fa-upload"></i>Upload Vendor</a></li>
								</ul>
								
							</div>
							<div class="mt-3">
								<table  class="table table-bordered table-striped table-sm" id="master-vendor">
									<thead>
										<th style="max-width: 26px"><i class="fa fa-list"></i></th>
										<th style="min-width: 100px">ID Vendor</th>
										<th style="min-width: 100px">Purch Org</th>
										<th style="min-width: 250px">Vendor Name</th>
										<th style="min-width: 160px">Email</th>
										<th style="min-width: 86px">Alias</th>
										<th style="min-width: 300px">Street</th>
										<th style="min-width: 100px">District</th>
										<th style="min-width: 100px">Post Code</th>
										<th style="min-width: 100px">City</th>
										<th style="min-width: 100px">Country</th>
										<th style="min-width: 100px">Region</th>
										<th style="min-width: 180px">Phone 1</th>
										<th style="min-width: 180px">Vat Reg</th>
										<th style="min-width: 180px">Order Curr</th>
										<th style="min-width: 100px">Pay Term</th>
										<th style="min-width: 150px">Sales Person</th>
										<th style="min-width: 150px">Phone 2</th>
										<th style="min-width: 100px">Status</th>
										<th style="min-width: 170px">Action</th>
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
	@include('regis_user.master-vendor.modals')
	@endsection

	@section('javascript')
	<script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/datatables.min.js"></script>
    <script>
    	$.fn.dataTable.ext.errMode = 'none';
      $('#master-vendor').DataTable({ autoWidth:false, dom: 'Bfrtip', scrollX: true,
      	buttons: [
              'excel'
            ],
        "order": [[ 1, "DESC" ]],
        processing: true,
        serverSide: true,
        autoWidth:false,
        "language": {
        "processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
        },
        ajax: "{{ route('datatables.regis-user.master.vendor')}}",
        columns: [
          {
			data: 'DT_RowIndex', name: 'DT_RowIndex'
          },
          {
            data: 'id_vendor', name: 'id_vendor'
          },
          {
            data: 'purch_org', name: 'purch_org'
          },
          {
            data: 'nm_vendor', name: 'nm_vendor'
          },
		  {
            data: 'vend_email', name: 'vend_email'
          },
		  {
			data: 'allias', name: 'allias'
		  },
          {
			data: 'street', name: 'street'
          },
		  {
			data: 'district', name: 'district'
		  }, 
		  {
			data: 'postal_code', name: 'postal_code'
		  },
		  {
			data: 'city', name: 'city'
		  }, 
		  {
			data: 'country', name: 'country'
		  }, 
		  {
			data: 'region', name: 'region'
		  }, 
		  {
			data: 'phone_1', name: 'phone_1'
		  }, 
		  {
			data: 'vat_reg', name: 'vat_reg'
		  }, 
		  {
			data: 'order_curr', name: 'order_curr'
		  }, 
		  {
			data: 'pay_term', name: 'pay_term'
		  }, 
		  {
			data: 'sales_person', name: 'sales_person'
		  }, 
		  {
			data: 'phone_2', name: 'phone_2'
		  }, 
		  {
			data: 'status_vendor', name: 'status_vendor'
		  }, 
		  {
			data: 'action', name: 'action'
		  }, 
		  
        ]
      });


	  function deleteProject(url,id)
		{
			Swal.fire({
				  title: '',
				  html: 'All reference data will be deleted. Are you sure want to delete this data <b>['+id+']</b>?',
				  // showDenyButton: true,
				  showCancelButton: true,
				  confirmButtonText: 'Confirm',
				  denyButtonText: `Cancel`,
				}).then((result) => {
				  /* Read more about isConfirmed, isDenied below */
				  if (result.isConfirmed) {
				    window.location = url;
				  }
				})
		}
    
    </script>
	@endsection