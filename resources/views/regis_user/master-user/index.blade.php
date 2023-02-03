@extends('layouts.main')
@section('title',"Master User ")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Master User</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
				<li class="breadcrumb-item active"><a href="{{route('delivery.schedule.mf')}}">Master User</a></li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<div class="table-responsive mt-3">
								<table  class="table table-bordered table-stripped table-sm" id="master-user">
									<thead>
										<th><i class="fa fa-list"></i></th>
										<th>ID User</th>
										<th>Nama User</th>
										<th>Tipe User</th>
										<th>Login Username</th>
										<th>Role</th>
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
      $('#master-user').DataTable({
        "order": [[ 1, "DESC" ]],
        processing: true,
        serverSide: true,
        autoWidth:false,
        "language": {
        "processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
        },
        ajax: "{{ route('datatables.regis-user.master.user')}}",
        columns: [
          {
			data: 'DT_RowIndex', name: 'DT_RowIndex'
          },
          {
            data: 'id_user', name: 'id_user'
          },
          {
            data: 'nm_user', name: 'nm_user'
          },
          {
            data: 'id_tipe_user', name: 'id_tipe_user'
          },
          {
            data: 'username', name: 'username'
          },
		  {
			data: 'role', name: 'role'
		  },
          {
			data: 'status_user', name: 'status_user'
          },
		  {
			data: 'action', name: 'action'
		  } 
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