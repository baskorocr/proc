@extends('layouts.main')
@section('title',"Upload Document Project")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Upload Document Project</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
				<li class="breadcrumb-item active">Upload Document Project</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="filter mt-2 mb-2 " align="right">
								<a class="btn btn-outline-secondary" href="#" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="bi bi-list"></i></a>
								<ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
									{{-- <li class="dropdown-header text-start"><h6>Filter</h6></li> --}}
									
									<li><a class="dropdown-item" href="{{route('project.management.master.listcheck')}}"><i class="fa fa-table"></i>Doc List Check Data</a></li>
								</ul>
								
							</div>
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="" method="get" enctype="multipart/form-data">
								
								<div class="box-body mt-3">
									
									<label>Choose Project</label>
									<select  style="width: 100%;"  class="form-control  option-select-doc" id="id_project" name="id_project" required>
										
										@foreach($project as $p)
										<option value="{{$p->id_project}}">{{$p->nm_project}}</option>"
										@endforeach
									</select>
									</div><!-- /.box-body -->
									<div class="box-footer"><hr>
										<button type="submit"  class="btn btn-primary"><i class="fas fa-eye"></i> View</button>
									</div>
								</form>
							</div>
						</div>
					@if(!empty($prodforProject))
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="" method="get" enctype="multipart/form-data">
								
								<div class="box-body mt-3">
									
									<input type="hidden" name="id_project" value="{{Request::get('id_project')}}">
									<label>Choose Product - Part</label>
									<select  style="width: 100%;"  class="form-control  option-select-doc" id="prod_part" name="prod_part" required>
										
										@foreach($prodforProject as $p)
										

										<option value="{{$p->id_product}}_{{$p->part->id_part}}">{{$p->product->nm_product}} - {{$p->part->nm_part}}</option>
										
										@endforeach
									</select>
									</div><!-- /.box-body -->
									<div class="box-footer">
										<button type="submit"  class="btn btn-outline-secondary"><i class="fas fa-search"></i> Search</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					@endif
					@if(!empty($prodforProject))
					<div class="col-12">
						<div class="card">
							<div class="card-header">
								<h5 class="card-title"></h5>
							</div>
							<div class="card-body">
										 <div class="table-responsive">
								<table class="table table-bordered" id="tb-detail-doc">
									<thead>
								        
								            <th>Document name</th>
								            <th>Upload File</th>
								            <th> Status </th>
								            <th>Required Type</th>
								            <th>Version</th>
								            <th>Upload n-Times</th>
								  			<th>Permission</th>
									</thead>
									<tbody>
										@foreach($docpart as $dp)
											<tr>
												<td>{{$dp->nm_doc_part}}</td>
												<td><input type='file' id='file' name='doc[]' class="form-control" accept='.pdf' > 
                    							<p class='text-secondary' id ="information">{{$dp->nm_doc_part}}.pdf</p></td>
												<td>SUCCESS</td>
												<td>{{$dp->doc_required}}</td>
												<td>v1.0</td>
												<td>2</td>
												<td>xxx</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				
							@endif
					</section>
				</main>
		@endsection
		@section('javascript')
		<script>
			$('.option-select-doc').select2({
		 	});
			@if(!empty($doc_detail))
			$(document).ready(function(){

		window.table = $('#tb-detail').DataTable({
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
					ajax: "{{ route('datatables.project.management.checklist-modify')}}?id_doc_part={{$doc_detail->id_doc_part}}",
					columns: [
								{
								data: 'DT_RowIndex',
								name: 'DT_RowIndex'
								},
								{
								data: 'check_params',
								name: 'check_params'
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
			var fieldID = 0
			$('[add-form]').click(function(){
				// alert('ASD');
				fieldID += 1;
				$('#form-addlist').show();
				$('#modify-btn').prop('disabled',false)
				var html = '<div style="display: none;" class="mt-3 col-md-12" id="27'+fieldID+'"><label><b>Addition Check Parameter No. '+fieldID+'</b></label><input id="30'+fieldID+'" class="form-control additional-param" type="text" required name="check_params[]"><button type="button" onclick="removeField(27'+fieldID+',30'+fieldID+')" class="mt-2 btn btn-sm btn-danger"><i class="fas fa-minus"></i> Remove</button></div>';
			      $('#form-addlist').append(html);
			      $('#27'+fieldID).slideDown();
			})

			function removeField(id,v)
			{
				if($('#'+v).val().length > 0)
				{
					Swal.fire({
							  html: 'Do you want to delete this?',
							  showDenyButton: true,
							  // showCancelButton: true,
							  confirmButtonText: 'Confirm',
							  denyButtonText: `Cancel`,
							}).then((result) => {
							  /* Read more about isConfirmed, isDenied below */
							  if (result.isConfirmed) {
							  	$('#'+id).slideUp("normal", function() { 
					
							   		$(this).remove();
							   	} );
							  } 
							})
					}	
					 else{
						$('#'+id).slideUp("normal", function() { 
					
							   		$(this).remove();
							   	} );
					}
								
				
					
			}
			@endif
		</script>
		@endsection