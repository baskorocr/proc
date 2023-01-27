@extends('layouts.main')
@section('title',"Modify Document Check List Parameters")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Modify Document Check List Parameters</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
				<li class="breadcrumb-item active">Modify Document Check List Parameters</li>
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
									
									<label>Choose Document</label>
									<select  style="width: 100%;"  class="form-control  option-select-doc" id="id_doc" name="id_doc" required>
										
										
										@foreach($doc as $d)
										<option @if($d->id_doc_part == Request::get('id_doc')) selected @endif value="{{$d->id_doc_part}}">{{$d->nm_doc_part}}
											( @if ($d->doc_required == "M")
											{{$d->doc_type }}-Mandatory
											@elseif ($d->doc_required == "Y")
											{{$d->doc_type }}-Required
											@elseif ($d->doc_required== "N")
											{{$d->doc_type }}-Not-required
										@endif )</option>
										@endforeach
									</select>
									</div><!-- /.box-body -->
									<div class="box-footer"><hr>
										<button type="submit"  class="btn btn-primary"><i class="fas fa-eye"></i> View</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					@if(!empty($doc_detail))
					<div class="col-12">
						<div class="card">
							<div class="card-header">
								<h5 class="card-title">{{$doc_detail->nm_doc_part}}</h5>
							</div>
							<div class="card-body">
								<table class="table table-bordered" id="tb-detail">
									<thead>
										<th>No</th>
										<th>Check Parameters </th>
										<th>Last Change Date</th>
										<th>Last Changed by</th>
										<th>Action</th>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-12">
						<form action="{{route('project.management.master.listcheck.modify.doc.add')}}" method="POST">
							@csrf
						<input type="hidden" name="id_doc_part" value="{{$doc_detail->id_doc_part}}">
						<div class="card">
							
							<div class="card-body">
								<div class="mt-3">
									<button type="button" add-form class="btn btn-outline-secondary btn-sm"><i class="fas fa-plus"></i> Add List Check</button>
								</div>
								
									<div class="mt-2 row" id="p-form-addlist">
										<div class="col-md-4">
											<div class="mt-2 row" style="display:none;" id="form-addlist">

											</div>
										
									</div>
									<div class="card-footer">
										<div class="mt-3">
											<button type="submit" id="modify-btn" disabled class="btn btn-primary btn-sm"><i class="fas fa-retweet"></i> Modify</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
						</div>
							@endif
					</section>
				</main>
		@endsection
		@section('javascript')
		<script>
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