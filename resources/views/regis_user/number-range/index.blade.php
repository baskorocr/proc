@extends('layouts.main')
@section('title',"Number Range ")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Number Range</h1>
		<nav>
			<ol class="breadcrumb">
				{{-- <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li> --}}
				<li class="breadcrumb-item active"><a href="{{route('delivery.schedule.mf')}}">Number Range</a></li>
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
									<li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#create-number-range" href="#"><i class="fas fa-plus-square"></i>Create Number Range</a></li>
								</ul>
							</div>

							<div class="table-responsive mt-3">
								<table  class="table table-bordered table-striped table-sm" id="number-range">
									<thead>
										<th><i class="fa fa-list"></i></th>
										<th>Doc Type</th>
										<th>Doc Year</th>
										<th>Number Low</th>
										<th>Number High</th>
										<th>Current Number</th>
										<th>Last Changed By</th>
										<th>Last Changed</th>
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
	@include('regis_user.number-range.modals')
	@endsection
	@section('javascript')
    <script>
      $('#number-range').DataTable({
        "order": [[ 1, "DESC" ]],
        processing: true,
        serverSide: true,
        autoWidth:false,
        "language": {
        "processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
        },
        ajax: "{{ route('datatables.regis-user.number.range')}}",
        columns: [
          {
			data: 'DT_RowIndex', name: 'DT_RowIndex'
          },
          {
            data: 'doc_type', name: 'doc_type'
          },
          {
            data: 'doc_year', name: 'doc_year'
          },
          {
            data: 'num_low', name: 'num_low'
          },
          {
            data: 'num_high', name: 'num_high'
          },
          {
            data: 'current_num', name: 'current_num'
          },
				  {
						data: 'last_changed_by', name: 'last_changed_by'
				  },
		  {
			data: 'last_changed', name: 'last_changed'
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