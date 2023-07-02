@extends('layouts.main')
@section('title',"Master User ")
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" integrity="sha512-xrbX64SIXOxo5cMQEDUQ3UyKsCreOEq1Im90z3B7KPoxLJ2ol/tCT0aBhuIzASfmBVdODioUdUPbt5EDEXmD9g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Master User</h1>
		<nav>
			<ol class="breadcrumb">
				{{-- <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li> --}}
				<li class="breadcrumb-item active">Master User</li>
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
									<li><a class="dropdown-item"   data-bs-toggle="modal" data-bs-target="#create-user" href="#"><i class="fas fa-plus-square"></i> Create User</a></li>
									<li><a class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#create-user-vendor" href="#"><i class="fas fa-plus-square"></i> Create Vendor User</a></li>
									<li><a class="dropdown-item"  href="{{route('api.regis-user.upload.user')}}"><i class="fas fa-upload"></i> Upload Email Vendor</a></li>
								</ul>
							</div>
							<div class="table-responsive mt-3">
							
								<table  class="table table-bordered table-striped table-sm" id="master-user">
									<thead>
										<th># <i style="margin-left:10px" class="ml-3 fa fa-list"></i></th>
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
	@include('regis_user.master-user.modals')
	@endsection

	@section('javascript')

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
  <script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/datatables.min.js"></script>

    <script>
    	$(document).ready(function() {
    	
    	// $('#select-access').select2({    dropdownParent: $('.modal')});
    	$('#tipe_user').select2({    dropdownParent: $('#create-user'),width:"100%"});
    	$('#accs_user').select2({    dropdownParent: $('#create-user'),width:"100%"});
    	$('#accs_vendor').select2({    dropdownParent: $('#create-user-vendor'),width:"100%"});
    	$('#id_vendor').select2({    dropdownParent: $('#create-user-vendor'),width:"100%"});
    });
    	
      $('#master-user').DataTable({  dom: 'Bfrtip',
            buttons: [
            				'copy',
								    {
								      // extend: 'excelHtml5',
								      text: 'Excel',
								       action: function ( e, dt, node, config ) {
						                window.location = "{{route('regis-user.export')}}";
						            }
														       
								          
								    },
 											
								  ],
            "columns": [
					   { "searchable": false },
					   { "searchable": true },
					   { "searchable": false},
					   { "searchable": true },
					   { "searchable": false },
					   { "searchable": false },
					   { "searchable": false }
					  ],
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
$('#master-user').on('draw.dt',   function () {

    		$('.dt-buttons .btn-group .flex-wrap').append('	<a href="{{route('regis-user.export')}}" class="btn btn-secondary buttons-excel buttons-html5">Excel</a>')
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