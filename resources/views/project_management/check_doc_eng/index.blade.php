@extends('layouts.main')
@section('title',"Upload Document Project")
@section('content')
<?php
	$doc_arr        = array();
$data_arr       = array();
$checked_arr    = array();
$completed_arr  = array();
?>
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Check Uploaded Document Project</h1>
		<nav>
			<ol class="breadcrumb">
				{{-- <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li> --}}
				<li class="breadcrumb-item active">Check Uploaded Document Project</li>
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
										<option value="{{$p->id_project}}">{{$p->nm_project}}</option>"
										@endforeach
									</select>
									</div><!-- /.box-body -->
									<div class="box-footer"><hr>
										<button type="submit"  class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					@if(!empty(Request::get('id_project')))
					<div class="col-md-12">
						<div class="card">
							<div class="card-body">
								<div class="mt-3">
									
								</div>
								<div class="tb-responsive mt-3">
									
									<table id="tb-proj" class="table table-bordered table-striped">
										<thead>
											<th>No. </th>
											<th>Proj. Num</th>
											<th>Proj. Name</th>
											<th>Prod.</th>
											<th>Part</th>
											<th>Doc. </th>
											<th>Ver.</th>
											<th>Upl. Date</th>
											<th>Uplder</th>
											<th>Upload stat (M)</th>
											<th>Check stat (C/N) </th>
										</thead>
										<tbody>
											<?php $i=1; ?>
											@foreach($project_uploaded as $p)
											<?php 
											if ($p->upload_path != ""){
					                            $status = "<span class='badge bg-success'>Uploaded ($p->doc_required)</span>";
					                         
					 						} else {
					                            $status = "<span class='badge bg-warning'> Waiting ($p->doc_required)...</span>";
					                        }
					                        $sum_check = PM::get_proj_doc_assign_data_status(Request::get('id_project'),$p->id_product,$p->id_part,$p->id_doc_part);
											$count_row3 = count(PM::get_proj_doc_assign_data(Request::get('id_project'),$p->id_product,$p->id_part,$p->id_doc_part)) ;

											if ($sum_check == $count_row3){
					                            $stat_check =  "<span class='badge bg-primary'>Completed ($sum_check/$count_row3)</span>";
					                        } else {
					                            $stat_check =  "<span class='badge bg-danger'>Uncomplete ($sum_check/$count_row3)</span>";
					                        }
                        					?>
											<tr>

												<td>{{$i}}</td>
												<td>{{@$p->project->proj_num}}</td>
												<td>{{@$p->project->nm_project}}</td>
												<td>{{@$p->product->nm_product}}</td>
												<td>{{@$p->part->nm_part}}</td>
												<td>{{@$p->docPart->nm_doc_part}}</td>
												<td>Ver 0{{@$p->version_n}}</td>
												<td>{{@date('d.m.Y',strtotime($p->upload_date))}}</td>
												<td>{{@$p->users->nm_user}}</td>
												<td>
							                        <a href="#" class="btn btn-flat" target="_blank" data-toggle='tooltip' title='click to preview' >
							                           <?php echo $status;?>
							                        </a>
							                    </td><td>
							                        {!!$stat_check!!}
							                    </td>
											</tr>
											<?php $i++; ?>
											@endforeach
										</tbody>
										
									</table>
								</div>
							</div>
						</div>
					</div>
					@endif
				</div>
			</section>
		</main>
		@endsection
		@section('javascript')
		<script>
			$('.option-select-doc').select2({
			});
			@if(!empty(Request::get('id_project')))
			
			$(document).ready(function(){
			window.table = $('#tb-proj').DataTable({
						});
			});
			
			@endif
		</script>
		@endsection