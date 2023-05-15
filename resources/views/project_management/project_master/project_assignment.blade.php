@extends('layouts.main')
@section('title',"Project Assigment ")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Project Assigment</h1>
		<nav>
			<ol class="breadcrumb">
				{{-- <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li> --}}
				<li class="breadcrumb-item">Project Master</li>
				<li class="breadcrumb-item active">Project Assigment</li>
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
									<li><a class="dropdown-item" href="{{route('project.management.master')}}"><i class="fas fa-file"></i>Project Master</a></li>
								</ul>
								
							</div>












							<div class="table-responsive mt-3">
								<table  class="table table-bordered table-striped table-sm" id="tb-proj-assign">
									<thead>
										<th>#</th>
										<th>ID Project</th>
										<th>Project Name</th>
										<th>Product Name</th>
										<th>Part Name</th>
										<th>Last Change Date</th>
										<th>Last Changed by</th>
										<th>Status</th>
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
		
		$(document).ready(function(){
 	$('.option-select2').select2({
 		  dropdownParent: $('.modal')
 	});
		window.table = $('#tb-proj-assign').DataTable({
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
			ajax: "{{ route('datatables.project.management.assign.master')}}",
			columns: [
						{
						data: 'DT_RowIndex',
						name: 'DT_RowIndex'
						},
						{
						data: 'id_project',
						name: 'id_project'
						},
						{
						data: 'nm_project',
						name: 'nm_project'
						},
						{
						data: 'nm_product',
						name: 'nm_product'
						},
						{
						data: 'nm_part',
						name: 'nm_part'
						},
						{
						data: 'last_change_date',
						name: 'last_change_date'
						},
						{
						data: 'last_change_by',
						name: 'last_change_by'
						},
						{
						data: 'status',
						name: 'status'
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

		
	</script>
	@endsection