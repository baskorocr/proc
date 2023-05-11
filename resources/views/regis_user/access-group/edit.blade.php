@extends('layouts.main')
@section('title',"Edit Project")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Access Group</h1>
		<nav>
			<ol class="breadcrumb">
				{{-- <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li> --}}
				<li class="breadcrumb-item active">Edit Access Group</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="{{route('regis-user.access-group.update.access')}}" method="post" enctype="multipart/form-data">
								@csrf
								<input type="hidden" name="id" value ="<?php echo $access->id; ?>">
								<div class="box-body">
									<div class="form-group">
										<label>Access Group Name</label>
										<input type="text" class="form-control" id="access_group_name" name="access_group_name" value="<?php echo $access->access_group_name; ?>" required>
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