@extends('layouts.main')
@section('title',"Edit User")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Update User</h1>
		<nav>
			<ol class="breadcrumb">
				
				<li class="breadcrumb-item active">Update  User</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="{{$user->is_vendor ? route("regis-user.master-user.update.uservendor"):route('regis-user.master-user.update.user')}}" method="post" enctype="multipart/form-data">
								@csrf
								<input type="hidden" name="id" value ="<?php echo $user->id; ?>">
								<div class="box-body">
									
									
									<div class="form-group">
										<label>ID User</label>
										<input type="text" class="form-control" disabled id="id_user" name="id_user" value="<?php echo $user->id_user; ?>" required>
									</div>
									@if($user->is_vendor)	
									<div class="form-group">
										<label>Select Vendor 	</label>
										{{-- <select name="id_vendor" id="vid" class="form-control select">
											@foreach($vendor as $v)
												<option  value="{{$v->id_vendor}}" >{{$v->nm_vendor}}</option>
											@endforeach
										</select> --}}
										 <br>
										 <input type="text" class="form-control" disabled id="vendor_nm" name="vendor_nm" value="{{$user->vendor->nm_vendor}}">
										 <input type="hidden"name="id_vendor" value="{{$user->foreign_id}}">
									</div>
									@endif
									<div class="form-group">
										<label>Name User </label>
										<input type="text" class="form-control" id="nm_user" name="nm_user" value="<?php echo $user->nm_user ?>" placeholder="ex.  Hidrian Oma Suharman" required>
									</div>
									@if(!$user->is_vendor)
									<div class="form-group">
										<label>Tipe User</label>
										<select name="id_tipe_user" class="form-control select">
											@foreach($type as $t)
												<option  value="{{$t->id_tipe_user}}" @if($user->id_tipe_user == $t->id_tipe_user) selected @endif>{{$t->nm_tipe_user}}</option>
											@endforeach
										</select>
									</div>
									@endif
									<div class="form-group">
										<label>Username For Login </label>
										<input @if($user->is_vendor) type="email" @else type="text" @endif class="form-control" id="username" placeholder="Username for login" name="username" value="<?php echo $user->username; ?>" required>
									</div>
									{{-- <div class="form-group">
										<label>Access Group</label>
										<select name="access_group_name" class="form-control select">
											@foreach($accessgrp as $grp)
												<option @if($grp->id_access_group == $user->id_access_group) selected="selected" @endif value="{{$grp->id_access_group}}">{{$grp->access_group_name}}</option>
											@endforeach
										</select> --}}
										{{-- <input type="text" class="form-control" id="access_group_name" name="access_group_name" value="<?php echo $user->access_group_name; ?>" > --}}
									{{-- </div> --}}

									
									<div class="form-group">
										<label>Access Group</label>
										<select name="role" id="role" class="form-control select">
											@foreach($roles as $r)
												<option @if($r->_id == $user->role_id) selected="selected" @endif value="{{$r->_id}}">{{$r->name}}</option>
											@endforeach
										</select>
										{{-- <input type="text" class="form-control" id="access_group_name" name="access_group_name" value="<?php echo $user->access_group_name; ?>" > --}}
									</div>
								
									<div class="form-group">
										<label>Status User</label>
										<select name="status_user" class="form-control select">
											
												<option @if($user->status_user == "A") selected="selected" @endif value="A">Aktif</option>
												<option @if($user->status_user == "N") selected="selected" @endif value="N">Non-Aktif</option>
											
										</select>
									</div>
									</div><!-- /.box-body -->
									<div class="box-footer"> 
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
		@section('javascript')
			<script type="text/javascript">
				$('.select').select2();
				$(document).ready(function(){
				@if($user->is_vendor)	
				$('#vid').val('{{$user->foreign_id}}');

				@endif
				$('#role').val('{{$user->role_id}}')
				})

			</script>
		@endsection