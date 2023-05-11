@extends('layouts.main')
@section('title',"Access Group ")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Access Group</h1>
		<nav>
			<ol class="breadcrumb">
				{{-- <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li> --}}
				<li class="breadcrumb-item active">Access Group</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<div class="table-responsive mt-3">
								<table  class="table table-bordered table-striped table-sm" id="access-group">
									<thead>
										<th><i class="fa fa-list"></i></th>
										<th>Access Group Name</th>
										<th>Last Changed by</th>
										<th>Last Changed Date</th>
										<th>Status</th>
										<th>Assigned</th>
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
    <script>
      $('#access-group').DataTable({
        "order": [[ 1, "DESC" ]],
        processing: true,
        serverSide: true,
        autoWidth:false,
        "language": {
        "processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
        },
        ajax: "{{ route('datatables.regis-user.access.group')}}",
        columns: [
          {
			data: 'DT_RowIndex', name: 'DT_RowIndex'
          },
          {
            data: 'access_group_name', name: 'access_group_name'
          },
          {
            data: 'last_changed_by', name: 'last_changed_by'
          },
          {
            data: 'last_changed', name: 'last_changed'
          },
		  {
			data: 'status', name: 'status'
		  },{
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