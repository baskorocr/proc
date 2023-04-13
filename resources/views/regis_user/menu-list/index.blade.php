@extends('layouts.main')
@section('title',"Menu List ")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Menu List</h1>
		<nav>
			<ol class="breadcrumb">
				{{-- <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li> --}}
				<li class="breadcrumb-item active">Menu List</li>
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
									<li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#create-menu-list" href="#"><i class="fas fa-plus-square"></i>Create Menu List</a></li>
								</ul>
							</div>

							<div class="table-responsive mt-3">
								<table  class="table table-bordered nowrap table-striped " id="menu-list">
									<thead>
										<th style="width: 10px;"><i class="fa fa-list"></i></th>
										<th style="width: 600px;">Menu Name</th>
										<th style="width: 600px;">Menu Object</th>
										<th style="width: 600px;">Object Path</th>
										<th style="width: 600px;">Last Changed by</th>
										<th style="width: 600px;">Last Changed Date</th>
										<th style="width: 600px;">Status</th>
										<th style="width: 600px;">Assigned</th>
										<th style="width: 600px;">Action</th>
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
	@include('regis_user.menu-list.modals')
	@endsection
	@section('javascript')
    <script>
      $('#menu-list').DataTable({
        "order": [[ 1, "DESC" ]],
        processing: true,
        serverSide: true,
        autoWidth:false,
        "language": {
        "processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
        },
        ajax: "{{ route('datatables.regis-user.menu.list')}}",
        columns: [
          {
			data: 'DT_RowIndex', name: 'DT_RowIndex'
          },
          {
            data: 'menu_name', name: 'menu_name'
          },
          {
            data: 'menu_object', name: 'menu_object'
          },
          {
            data: 'object_path', name: 'object_path'
          },
          {
            data: 'last_changed_by', name: 'last_changed_by'
          },
          {
            data: 'last_changed', name: 'last_changed'
          },
          {
            data: 'status', name: 'status'
          },
		  {
			data: 'assigned', name: 'assigned'
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