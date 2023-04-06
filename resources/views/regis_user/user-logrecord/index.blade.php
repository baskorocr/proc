@extends('layouts.main')
@section('title',"User Log Record ")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>User Log Record</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
				<li class="breadcrumb-item active"><a href="{{route('delivery.schedule.mf')}}">User Log Record</a></li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">

						

							<div class="table-responsive mt-3">
								<table  class="table table-bordered table-stripped table-sm" id="user-logrecord">
									<thead>
										<th><i class="fa fa-list"></i></th>
										<th>Username</th>
										<th>IP Address</th>
										<th>Activity</th>
										<th>Last Activity</th>
										<th>Attempt</th>
										<th>User Type</th>
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
    <script>
    	$.fn.dataTable.ext.errMode = 'none';
      $('#user-logrecord').DataTable({
        "order": [[ 1, "DESC" ]],
        processing: true,
        serverSide: true,
        autoWidth:false,
        "language": {
        "processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
        },
        ajax: "{{ route('datatables.regis-user.user.logrecord')}}",
        columns: [
          {
			data: 'DT_RowIndex', name: 'DT_RowIndex'
          },
          {
            data: 'id_user', name: 'id_user'
          },
          {
            data: 'ip_address', name: 'ip_address'
          },
		  {
            data: 'activity', name: 'activity'
          },
		  {
            data: 'datetime_log', name: 'datetime_log'
          },
          {
			data: 'attempt', name: 'attempt'
          },  
		  {
			data: 'user_type', name: 'user_type'
          },  
		  {
			data: 'status', name: 'status'
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