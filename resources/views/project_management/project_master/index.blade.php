@extends('layouts.main')
@section('title',"Project Master ")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Project Master</h1>
		<nav>
			<ol class="breadcrumb">
				{{-- <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li> --}}
				<li class="breadcrumb-item active">Project Master</li>
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
									<li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#create-project" href="#"><i class="fas fa-plus-square"></i>Create Project</a></li>
									<li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#assignDetailModal" href="#"><i class="fas fa-arrow-down"></i>Assign Project Details</a></li>
									<li><a class="dropdown-item" href="{{route('project.management.assign.master')}}"><i class="fa fa-table"></i>Project Assignment Data</a></li>
								</ul>
							</div>

							<div class="table-responsive mt-3">
								<table  class="table table-bordered table-striped table-sm" id="tb-proj-master">
									<thead>
										<th>#</th>
										<th>Project Number</th>
										<th>Project Name</th>
										<th>Last Change Date</th>
										<th>Last Changed by</th>
										<th>Product Ass.</th>
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
	@include('project_management.project_master.modals')
	@endsection
	@section('javascript')
	<script>
		
		$(document).ready(function(){
 	$('.option-select2').select2({
 		  dropdownParent: $('.modal')
 	});
		window.table = $('#tb-proj-master').DataTable({
			columnDefs: [
	{
	searchable: false,
	orderable: false,
	targets: 0,
	}],
			"order": [[ 1, "DESC" ]],
			processing: true,
			serverSide: true,
			autoWidth:false,
			"language": {
			"processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
			},
			ajax: "{{ route('datatables.project.management.master')}}",
			columns: [
						{
						data: 'DT_RowIndex',
						name: 'DT_RowIndex'
						},
						{
						data: 'proj_num',
						name: 'proj_num'
						},
						{
						data: 'nm_project',
						name: 'nm_project'
						},{
						data: 'modify_date',
						name: 'modify_date'
						},
						{
						data: 'last_change_by',
						name: 'last_change_by'
						},
						{
						data: 'prod_assc',
						name: 'prod_assc'
						},
						{
						data: 'action',
						name: 'action'
						},
			]
			});
		window.table.on('order.dt search.dt', function () {
		let i = 1;
		
		window.table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
		this.data(i++);
		});
		}).draw();
		})
		$('#create-project-form').submit(function(e){
			e.preventDefault();
			axios.post('{{route('api.project.management.create.project')}}', {
			    id_project:$('#id_project').val(),
			    proj_num: $('#proj_num').val(),
			    nm_project:$('#nm_project').val(),
			    _token:$("input[name=_token]").val(),
			  })
			  .then(function (response) {
			  	if(response.data.type == "success")
			  	{
			  		Swal.fire(
					  '',
					  response.data.message,
					  'success'
					)
					$('#id_project').val('')
					$('#proj_num').val('')
					$('#nm_project').val('')
					$('#create-project').modal('hide')
					$(".option-select2").select2("val", "");
					window.table.ajax.reload();
			  	} else if(response.data.type == "error")
			  	{
			  		Swal.fire(
					  '',
					  response.data.message,
					  'error'
					)
			  	}
			    
			  })
			  .catch(function (error) {
			    console.log(error);
			  });
		})

		$('#assign-project-form').submit(function(e){
			e.preventDefault();
			axios.post('{{route('api.project.management.assign.project')}}', {
			    id_project:$('#id_project_assign').val(),
			    id_product: $('#id_product_assign').val(),
			    _token:$("input[name=_token]").val(),
			  })
			  .then(function (response) {
			  	if(response.data.type == "success")
			  	{
			  		Swal.fire(
					  '',
					  response.data.message,
					  'success'
					)
					
					$(".option-select2").select2("val", "");
				    $('#assignDetailModal').modal('hide')
					window.table.ajax.reload();
			  	} else if(response.data.type == "error")
			  	{
			  		Swal.fire(
					  '',
					  response.data.message,
					  'error'
					)
			  	}
			    
			  })
			  .catch(function (error) {
			    console.log(error);
			  });
		})

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