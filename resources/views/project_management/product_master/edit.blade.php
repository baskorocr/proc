@extends('layouts.main')
@section('title',"Edit Product")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Product Edit</h1>
		<nav>
			<ol class="breadcrumb">
				{{-- <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li> --}}
				<li class="breadcrumb-item active">Product Edit</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="{{route('project.management.master.update.product')}}" method="post" enctype="multipart/form-data">
								@csrf
								<div class="box-body">
									
									@if(auth()->user()->role == 'admin')
									<div class="form-group">
										<label>ID Product</label>
										<input type="text" class="form-control" value='{{$product->id_product}}' disabled="true">
									</div>
									@endif
									<input type="hidden" id="id" name="id_product" value ="<?php echo $product->id_product; ?>">
									<div class="form-group">
										<label>Product Number</label>
										<input type="text" class="form-control" name="prod_num" value="<?php echo $product->prod_num ?>" placeholder="product Number" required>
									</div>
									<div class="form-group">
										<label>Product Name</label>
										<input type="text" class="form-control" id="nm_product" name="nm_product" value="<?php echo $product->nm_product; ?>" required>
									</div>
									<!--
									<div class="form-group">
											<label>Status</label>
											<select class="form-control" id="status_project" name="status_project" >
													<option value="A">Active</option>
													<option value="N">Not-active</option>
											</select>
									</div>
									-->
									
									</div><!-- /.box-body -->
									<div class="box-footer"><hr>
										<button type="submit" id="edit-prodmaster" name="edit-prodMaster" class="btn btn-primary"><i class="fas fa-pencil"></i> Update</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</section>
		</main>
		@endsection