@extends('layouts.main')
@section('title',"Edit User")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Master User</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
				<li class="breadcrumb-item active">Edit Master User</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="{{route('regis-user.master-user.update.user')}}" method="post" enctype="multipart/form-data">
								@csrf
								<input type="hidden" name="id" value ="<?php echo $user->id; ?>">
								<div class="box-body">
									
									
									<div class="form-group">
										<label>ID User</label>
										<input type="text" class="form-control" id="id_user" name="id_user" value="<?php echo $user->id_user; ?>" required>
									</div>
								
									<div class="form-group">
										<label>Name User </label>
										<input type="text" class="form-control" id="nm_user" name="nm_user" value="<?php echo $user->nm_user ?>" placeholder="Name User" required>
									</div>
									
									<div class="form-group">
										<label>Tipe User</label>
										<input type="text" class="form-control" id="id_tipe_user" name="id_tipe_user" value="<?php echo $user->id_tipe_user; ?>" required>
									</div>
									<div class="form-group">
										<label>Username For Login</label>
										<input type="text" class="form-control" id="username" name="username" value="<?php echo $user->username; ?>" required>
									</div>
									<div class="form-group">
										<label>Access Group</label>
										<input type="text" class="form-control" id="access_group_name" name="access_group_name" value="<?php echo $user->access_group_name; ?>" >
									</div>
									<div class="form-group">
										<label>Status User</label>
										<input type="text" class="form-control" id="status_user" name="status_user" value="<?php echo $user->status_user; ?>">
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