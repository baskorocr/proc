@extends('layouts.main')
@section('title',"Edit Project")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Menu List</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
				<li class="breadcrumb-item active">Edit Menu List</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="{{route('regis-user.menu-list.update.list')}}" method="post" enctype="multipart/form-data">
								@csrf
								<input type="hidden" name="id" value ="<?php echo $list->id; ?>">
								<div class="box-body">
									
									<!-- @if(auth()->user()->role == 'admin') -->
									<!-- <div class="form-group">
										<label>Menu List</label>
										<input type="text" class="form-control" value='{{$list->menu_name}}'>
									</div> -->
									<!-- @endif -->
									<div class="form-group">
										<label>Menu Name</label>
										<input type="text" class="form-control" id="menu_name" name="menu_name" value="<?php echo $list->menu_name; ?>" required>
									</div>
									<!-- <input type="hidden" id="menu_name" name="menu_name" value ="<?php echo $list->menu_name; ?>"> -->
									<div class="form-group">
										<label>Menu Object </label>
										<input type="text" class="form-control" id="menu_object" name="menu_object" value="<?php echo $list->menu_object ?>" placeholder="Menu Object" required>
									</div>
									
									<div class="form-group">
										<label>Object Path</label>
										<input type="text" class="form-control" id="object_path" name="object_path" value="<?php echo $list->object_path; ?>" required>
									</div>
									<div class="form-group">
										<label>Status User</label>
										<input type="text" class="form-control" id="status_user" name="status_user" value="<?php echo $list->status_user; ?>">
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