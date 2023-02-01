@extends('layouts.main')
@section('title',"Assign Vendor")
@section('content')
<?php
	$doc_arr        = array();
$data_arr       = array();
$checked_arr    = array();
$completed_arr  = array();
?>
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Assign Vendor</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
				<li class="breadcrumb-item active">Assign Vendor</li>
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
					@if(!empty($prodforProject))
					<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="" method="get" enctype="multipart/form-data">
								
								<div class="box-body mt-3">
									
									<input type="hidden" name="id_project" value="{{Request::get('id_project')}}">
									<label>Choose Product</label>
									<select  style="width: 100%;"  class="form-control  option-select-doc" id="prod_part" name="prod_part" required>
										
										@foreach($prodforProject as $p)
										

										<option value="{{$p->id_product}}">{{$p->product->nm_product}}</option>
										
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
					@if(!empty($prod))
					<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="" method="get" enctype="multipart/form-data">
								
								<div class="box-body mt-3">
									
									<input type="hidden" name="id_project" value="{{Request::get('id_project')}}">
									<label>Choose Vendor</label>
									<select  style="width: 100%;"  class="form-control  option-select-doc" id="prod_part" name="prod_part" required>
										
										@foreach($vendor as $v)
										

										<option value="{{$v->id_vendor}}">{{@$v->user->vendor_nm}} ({{@$v->allias}})</option>
										
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