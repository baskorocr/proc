@extends('layouts.main')
@section('title',"Upload Required Document")
@section('content')
<?php
	 $doc_arr        = array();
    $data_arr       = array();
    $checked_arr    = array();
    $completed_arr  = array();
 ?>
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Upload Required Document</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
				<li class="breadcrumb-item active">Upload Required Document</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="" method="get" enctype="multipart/form-data">
								
								<div class="box-body mt-3">
									
									<label>Choose Project</label>
									<select  style="width: 100%;"  class="form-control  option-select-doc" id="id_project" name="id_project" required>
										
										@foreach($project as $p)
										<option value="{{$p->id_project}}">{{$p->project->nm_project}}</option>"
										@endforeach
									</select>
									</div><!-- /.box-body -->
									<div class="box-footer">
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
					@if(!empty($docpart))
					<form id="upload" action="{{route('project.management.upload.doc.actUpload')}}" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="id_project" value="{{Request::get('id_project')}}">
						<input type="hidden" name="id_product" value="{{$id_product}}">
						<input type="hidden" name="id_part" value="{{$id_part}}">
						@csrf
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
								            <th>Status </th>
								            {{-- <th>Required Type</th> --}}
								            <th>Version</th>
								            <th>Upload n-Times</th>
								  			{{-- <th>Permission</th> --}}
									</thead>
									<tbody>
										@foreach($docpart as $dp)

										  <?php

                    $doc_arr      = array();
                    $completed_arr  = array();
                    $query_exec_b = PM::get_vendor_prod_part_doc_data(Request::get('id_project'), $id_product, $id_part, $dp->doc_type, auth()->user()->vendor->id_vendor);
                    foreach ($query_exec_b as $row_b) {

                        $id_doc_part    = $row_b['id_doc_part'];
                        $nm_doc_part    = $row_b['nm_doc_part'];
                        $upload_path    = $row_b['upload_path'];
                        $doc_upl_nm     = $row_b['file_nm'];

                        $ver            = $row_b['version_n'];
                        $upload_n       = $row_b['upload_n'];

                        $nama_data = $row_b['file_nm'];
                        $temp = explode(".", $nama_data);
                        $filename = $temp[0];
                        $pathname = auth()->user()->vendor->id_vendor."/".$filename;

                        $data = $row_b['id_project'].",".$row_b['id_product'].",".$row_b['id_part'].",".$row_b['id_doc_part'].",".auth()->user()->vendor->id_vendor;

                        if ($upload_path == ""){
                            $stat_check = "<span class='badge bg-red'>No upload</span>";
                            $dis_btn = "";
                            $doc_name = $nm_doc_part.".pdf";

                            $doc_version = "<center>-</center>";
                            $doc_upload = "<center>-</center>";
                            $act    ="disabled";
                        } else {

                            $query_exec3 = PM::get_proj_doc_assign_data_vendor(Request::get('id_project'), $id_product, $id_part, $id_doc_part, auth()->user()->vendor->id_vendor);
                            $row3 = $query_exec3;

                            $query_exec4 = PM::get_proj_doc_assign_data_status_vendor(Request::get('id_project'), $id_product, $id_part, $id_doc_part, auth()->user()->vendor->id_vendor);
                            $row4 =$query_exec4;

                            $query_exec5 = PM::get_proj_doc_assign_data_status_vendor2(Request::get('id_project'), $id_product, $id_part, $id_doc_part, auth()->user()->vendor->id_vendor);
                            $row5 = $query_exec5;

                            $count_row3 = count($query_exec3);
                            $sum_check_a = $row4;
                            $sum_check_b = $row5;

                            $sum_tobe_checked   = $count_row3 + $count_row3;
                            $sum_checked        = $sum_check_a + $sum_check_b;

                            if ($sum_tobe_checked  == $sum_checked){
                                $stat_check =  "<span class='badge bg-primary'>Completed ($sum_checked/$sum_tobe_checked)</span>";
                                array_push($completed_arr, 'completed');
                                $dis_btn = "style=\"display: none;\" ";
                                $doc_name = "<span class='badge bg-success'>Completed Check</span>"; //$doc_upl_nm
                            } else {
                                $stat_check =  "<a href='home.php?mnu=checkvendview&id_data=".$data."'><span class='badge bg-orange btn-flat'>Uncomplete ($sum_checked/$sum_tobe_checked)</span></a>";
                                $dis_btn = "";
                                $doc_name = $nm_doc_part.".pdf";
                            }

                            $doc_version = "<span class='badge bg-success'>Ver 0".$ver."</span>";
                            $doc_upload  = "<center>$upload_n</center>";
                            $act    ="";
                        }
                    }

                ?>
											<tr>
												<td>{{$dp->nm_doc_part}}</td>
												<td>
													<input type="hidden" name="id_doc_part[]" disabled id="up_{{$dp->id_doc_part}}" value="{{$dp->id_doc_part}}">
													<input type='file' id='file' name='doc[]' id onchange="$('#up_{{$dp->id_doc_part}}').prop('disabled',false);" class="form-control" accept='.pdf' > 

                    							<p class='text-secondary' id ="information">{{$dp->nm_doc_part}}.pdf</p></td>
												<td>{!!$stat_check!!}</td>
												{{-- <td>{!!$doc_required!!}</td> --}}
												<td>{!!$doc_version!!}</td>
												<td>{!!$doc_upload!!}</td>
												{{-- <td>{!!$ptext!!}</td> --}}
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
						<div class="card-footer">
							<button class="ml-4 btn btn-primary" type="submit"><i class="fas fa-upload"></i> Upload</button>
						</div>
					</div>
					</div>
				</form>
				
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