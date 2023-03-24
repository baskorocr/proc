@extends('layouts.main')
@section('title',"Edit Vendor")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Master Vendor</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
				<li class="breadcrumb-item active">Edit Master Vendor</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="{{route('regis-user.master-vendor.update.vendor')}}" method="post" enctype="multipart/form-data">
								@csrf
								<input type="hidden" name="id" value ="<?php echo $vendor->id; ?>">
								<div class="box-body">
									
									
									<div class="form-group">
										<label>ID Vendor</label>
										<input type="text" class="form-control" id="id_vendor" name="id_vendor" value="<?php echo $vendor->id_vendor; ?>" required>
									</div>
							
									<div class="form-group">
										<label>Nama Vendor</label>
										<input type="text" class="form-control" id="nm_vendor" name="nm_vendor" value="<?php echo $vendor->nm_vendor; ?>" required>
									</div>
									<div class="form-group">
										<label>Alias</label>
										<input type="text" class="form-control" id="allias" name="allias" value="<?php echo $vendor->allias; ?>" >
									</div>
									<div class="form-group">
										<label>Street </label>
										<input type="text" class="form-control" id="street" name="street" value="<?php echo $vendor->street; ?>" >
									</div>
										<div class="form-group">
										<label>Status Vendor</label>
										<select name="status_user" class="form-control select">
											
												<option @if($vendor->status_vendor == "A") selected="selected" @endif value="A">Aktif</option>
												<option @if($vendor->status_vendor == "N") selected="selected" @endif value="N">Non-Aktif</option>
											
										</select>
									</div>
									</div><!-- /.box-body -->
									<div class="box-footer"><hr>
										<button type="submit" id="edit-projmaster" name="edit-projmaster" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</section>
		</main>
		@endsection