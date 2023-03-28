@extends('layouts.main')
@section('title',"Master Vendor ")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Master Vendor</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
				<li class="breadcrumb-item active"><a href="{{route('delivery.schedule.mf')}}">Master Vendor</a></li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<div class="table-responsive mt-3">
								<table  class="table table-bordered table-stripped table-sm" id="master-vendor">
									<thead>
										<th><i class="fa fa-list"></i></th>
										<th>ID Vendor</th>
										<th>Purch Org</th>
										<th>Vendor Name</th>
										<th>Email</th>
										<th>Alias</th>
										<th>Street</th>
										<th>District</th>
										<th>Post Code</th>
										<th>City</th>
										<th>Country</th>
										<th>Region</th>
										<th>Phone 1</th>
										<th>Vat Reg</th>
										<th>Order Curr</th>
										<th>Pay Term</th>
										<th>Sales Person</th>
										<th>Phone 2</th>
										<th>Status</th>
										<th>Action</th>
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
	<script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/datatables.min.js"></script>
    <script>
      $('#master-vendor').DataTable({  dom: 'Bfrtip',
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