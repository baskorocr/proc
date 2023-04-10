@extends('layouts.main')
@section('title',"Create User")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Create Vendor User</h1>
		<nav>
			<ol class="breadcrumb">
				
				<li class="breadcrumb-item active">Create  Vendor User </li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="{{route('api.regis-user.create.user.vendor.act')}}" method="post" enctype="multipart/form-data">
								@csrf
							
								<div class="box-body">
									
									
									<div class="form-group">
										<label>Select Vendor 	</label>
										<select name="id_vendor" id="id_vendor" class="form-control select">
											@foreach($vendor as $v)
												<option  value="{{$v->id_vendor}}">{{$v->nm_vendor}}</option>
											@endforeach
										</select>
									</div>

								
									<div class="form-group">
										<label>Name User </label>
										<input type="text" class="form-control" id="nm_user" name="nm_user" placeholder="ex. Hidrian Oma Suharman" value="" placeholder="Name User" required>
									</div>
									
									
									<div class="form-group">
										<label>Username For Login</label>
										<input type="text" placeholder="Username For Login" class="form-control" id="username" name="username" value="" required>
									</div>
									<div class="form-group">
										<label>Password</label>
										<input type="password" class="form-control" placeholder="Password" id="password" name="password" value="" required>
									</div>
									<div class="form-group">
										<label>Confirm Password</label>
										<input type="password" class="form-control"  placeholder="Confirm Password" id="password_confirmation" name="password_confirmation" value="" required>
									</div>
									<div class="form-group">
										<label>Access Group</label>
										<select name="access_group_name" class="form-control select">
											@foreach($accessgrp as $grp)
												<option  value="{{$grp->id_access_group}}">{{$grp->access_group_name}}</option>
											@endforeach
										</select>
										{{-- <input type="text" class="form-control" id="access_group_name" name="access_group_name" value="<?php echo $user->access_group_name; ?>" > --}}
									</div>
									
									<div class="form-group">
										<label>Status User</label>
										<select name="status_user" class="form-control select">
											
												<option value="A">Aktif</option>
												<option value="N">Non-Aktif</option>
											
										</select>
									</div>
									</div><!-- /.box-body -->
									<div class="box-footer"><hr>
										<button type="submit" id="edit-projmaster" name="edit-projmaster" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Create</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</section>
		</main>
		@endsection
		@section('javascript')
			<script type="text/javascript">
				$('.select').select2();
			</script>
		@endsection