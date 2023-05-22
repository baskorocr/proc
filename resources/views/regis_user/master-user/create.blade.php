@extends('layouts.main')
@section('title',"Edit User")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Master User</h1>
		<nav>
			<ol class="breadcrumb">
				
				<li class="breadcrumb-item active">Create  User</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="{{route('api.regis-user.create.user.act')}}" method="post" enctype="multipart/form-data">
								@csrf
							
								<div class="box-body">
									
									
								{{-- 	<div class="form-group">
										<label>ID User</label>
										<input type="text" class="form-control" id="id_user" name="id_user" placeholder="ex. Hidrian Oma Suharman" value="" required>
									</div> --}}
								
									<div class="form-group">
										<label>Name User </label>
										<input type="text" class="form-control" id="nm_user" name="nm_user" placeholder="ex. Hidrian Oma Suharman" value="" placeholder="Name User" required>
									</div>
									
									<div class="form-group">
										<label>Tipe User</label>
										<select name="access_group_name" class="form-control select">
											@foreach($type as $t)
												<option  value="{{$t->id_tipe_user}}">{{$t->nm_tipe_user}}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group">
										<label>Username For Login</label>
										<input type="text" class="form-control"  placeholder="Username For Login" id="username" name="username" value="" required>
									</div>
									<div class="form-group">
										<label>Password</label>
										<input type="password" class="form-control" id="password" placeholder="Password" name="password" value="" required>
									</div>
									<div class="form-group">
										<label>Confirm Password</label>
										<input type="password" class="form-control" id="password_confirmation" placeholder="Confirm Password" name="password_confirmation" value="" required>
									</div>
									{{-- <div class="form-group">
										<label>Access Group</label>
										<select name="access_group_name" class="form-control select">
											@foreach($accessgrp as $grp)
												<option  value="{{$grp->id_access_group}}">{{$grp->access_group_name}}</option>
											@endforeach
										</select> --}}
										{{-- <input type="text" class="form-control" id="access_group_name" name="access_group_name" value="<?php echo $user->access_group_name; ?>" > --}}
									{{-- </div> --}}
									<div class="form-group">
										<label>Access Group</label>
										<select name="role" class="form-control select">
											@foreach($roles as $r)
												<option value="{{$r->_id}}">{{$r->name}}</option>
											@endforeach
										</select>
										{{-- <input type="text" class="form-control" id="access_group_name" name="access_group_name" value="<?php echo $user->access_group_name; ?>" > --}}
									</div>
									<input type="hidden" value="A" name="status_user">
									 <div class="form-group">
										<label>Status User</label>
										<select name="status_user" class="form-control select">
											
												<option value="A">Aktif</option>
												<option value="N">Non-Aktif</option>
											
										</select>
									</div> 
									</div><!-- /.box-body -->
									<div class="box-footer"> 
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