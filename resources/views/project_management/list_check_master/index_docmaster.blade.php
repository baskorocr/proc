@extends('layouts.main')
@section('title',"Document Master ")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Document Master</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
				<li class="breadcrumb-item">Document Master</li>
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
									<li><a class="dropdown-item"  href="#" data-bs-toggle="modal" data-bs-target="#create-doc" ><i class="fas fa-plus-square"></i>Create Doc Master</a></li>
									<li><a class="dropdown-item" href="{{route('project.management.master.listcheck.modify.doc.assigns')}}"><i class="fas fa-arrow-down"></i>Assign Document Check List</a></li>
									<li><a class="dropdown-item" href="{{route('project.management.master.listcheck')}}"><i class="fa fa-table"></i>Doc List Check Data</a></li>
								</ul>
								
							</div>


							<div class="table-responsive mt-3">
								<table  class="table table-bordered table-stripped table-sm" id="tb-doc-master">
									<thead>
										<th >ID Document</th>
						                <th>Doc Name</th>
						                <th>Doc Type</th>
						                <th>Last Change Date</th>
						                <th>Last Changed by</th>
						                <!--
						                <th>Status</th>
						                -->
						                <th>Check Stat. </th>
						                <th>Required</th>
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
	@include('project_management.list_check_master.modals_doc_master')
	@endsection
	@section('javascript')
	<script>
		
		$(document).ready(function(){


 	$('.option-select2').select2({
 		  dropdownParent: $('.modal')
 	});

 	$('.option-select-doc').select2({
 		  dropdownParent: $('.modal'),
 		   escapeMarkup: function(markup) {
		    return markup;
		  }
 	});
		window.table = $('#tb-doc-master').DataTable({
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
			ajax: "{{ route('datatables.project.management.doc-master')}}",
			columns: [
						{
						data: 'id_doc_part',
						name: 'id_doc_part'
						},
						{
						data: 'nm_doc',
						name: 'nm_doc'
						},
						{
						data: 'doc_type',
						name: 'doc_type'
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
						data: 'check_stat',
						name: 'check_stat'
						},
						{
						data: 'required_stat',
						name: 'required_stat'
						},
						{
						data: 'action',
						name: 'action'
						},
			]
			});
	
		})
		// CRUD
		$('#create-doc-form').submit(function(e){
			e.preventDefault();
			axios.post('{{route('api.project.management.create.doc')}}', {
			    id_doc:$('#id_doc').val(),
			    nm_doc: $('#nm_doc').val(),
			    doc_type:$('#doc_type').val(),
			    doc_required:$('#doc_required').val(),
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
					$('#part_num').val('')
					$('#nm_part').val('')
					$('#create-doc').modal('hide')
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

		$('#assign-part-form').submit(function(e){
			e.preventDefault();
			axios.post('{{route('api.project.management.assign.part')}}', {
			    id_part:$('#id_part_assign').val(),
			    id_doc_assign: $('#id_doc_assign').val(),
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
					$(".option-select-doc").select2("val", "");
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