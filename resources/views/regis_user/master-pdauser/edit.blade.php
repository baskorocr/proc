@extends('layouts.main')
@section('title',"Edit PDA User Master")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>PDA User Master</h1>
		<nav>
			<ol class="breadcrumb">
				{{-- <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li> --}}
				<li class="breadcrumb-item active">Edit PDA User Master</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="{{route('regis-user.master-pdauser.update.pdauser')}}" method="post" enctype="multipart/form-data">
								@csrf
								<input type="hidden" name="_id" value ="<?php echo $pdauser->_id; ?>">
								<div class="box-body">
									<div class="form-group">
										<label>ID / NPK</label>
										<input type="text" class="form-control" id="id" placeholder="111157283" name="id" value="<?php echo $pdauser->id; ?>" disabled>
									</div>
									<div class="form-group">
										<label>Full Name </label>
										<input type="text" class="form-control" id="full_name" placeholder="ex. Hidrian Oma Suharman" name="full_name" value="<?php echo $pdauser->full_name ?>" placeholder=" Document Year" required>
									</div>
									
									<div class="form-group">
										<label>Username for PDA Access</label>
										<input type="text" class="form-control" id="username"  placeholder="User PDA Login" name="username" value="<?php echo $pdauser->username; ?>" required>
									</div>
									<div class="form-group">
										<label>Status User</label>
										<select name="user_stat" class="form-control">
											<option {{$pdauser->user_stat == "A" ? 'selected':null}} value="A">Active</option>
											<option {{$pdauser->user_stat == "N" ? 'selected':null}} value="N">Non-active</option>
										</select>
									</div>
									<div class="form-group">
										<label>PIN</label>
										<input type="password" maxlength="6" class="form-control" id="pin" placeholder="ex. {{rand(111111,999999)}}" name="pin" value="">
									</div>

									<div class="form-group">
										<label>Confirm PIN</label>
										<input type="password"  maxlength="6"  class="form-control" id="pin"  placeholder="Confirm PIN" name="pin_confirm" value="">
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