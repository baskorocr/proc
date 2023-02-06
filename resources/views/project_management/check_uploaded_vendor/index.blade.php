@extends('layouts.main')
@section('title',"Check Uploaded Document from Vendor")
@section('content')
<?php
	 $doc_arr        = array();
    $data_arr       = array();
    $checked_arr    = array();
    $completed_arr  = array();
 ?>
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Check Uploaded Document from Vendor</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
				<li class="breadcrumb-item active">Check Uploaded Document from Vendor</li>
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
								<div class="table-responsive">
						        <table id="tb-detail" class="table table-bordered table-striped">
						            <thead>
						                <th># </th>
						                <th>Id Project</th>
						                <th>Proj.</th>
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

		window.table = $('#tb-detail').DataTable();
				
		</script>
		@endsection