@extends('layouts.main')
@section('title',"PDA User Master ")
@section('content')
<style type="text/css">
	.dataTables_length{
		margin-top:1rem;
	}
</style>
<main id="main" class="main">
	<div class="pagetitle">
		<h1>PDA User Master</h1>
		<nav>
			<ol class="breadcrumb">
				{{-- <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li> --}}
				<li class="breadcrumb-item active">PDA User Master</li>
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
									<li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#create-master-pdauser" href="#"><i class="fas fa-plus-square"></i>Create PDA User</a></li>
								</ul>
							</div>

							<div class="table-responsive mt-3">
								<table  class="table table-bordered table-striped table-sm" id="master-pdauser">
									<thead>
										<th><i class="fa fa-list"></i></th>
										<th>ID User</th>
										<th>User Login</th>
										<th>Full Name</th>
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
		@include('regis_user.master-pdauser.modals')
	@endsection
	@section('javascript')
	<script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/datatables.min.js"></script>
    <script>
      $('#master-pdauser').DataTable({
        "order": [[ 1, "DESC" ]],
        dom: 'Blfrtip',
      	buttons: [
              'excel','copy'
            ],

				"lengthMenu": [ [10, 25, 50,100, -1], [10, 25, 50,100, "All"] ],
        processing: true,
        serverSide: true,
        autoWidth:false,
        "language": {
        "processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
        },
        ajax: "{{ route('datatables.regis-user.master.pdauser')}}",
        columns: [
          {
			data: 'DT_RowIndex', name: 'DT_RowIndex'
          },
          {
            data: 'id', name: 'id'
          },
          {
            data: 'username', name: 'username'
          },
		  {
            data: 'full_name', name: 'full_name'
          },
		  {
            data: 'user_stat', name: 'user_stat'
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