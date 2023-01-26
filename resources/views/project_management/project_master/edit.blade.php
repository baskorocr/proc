@extends('layouts.main')
@section('title',"Edit Project")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Project Master</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
				<li class="breadcrumb-item active">Project Master</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="{{route('project.management.master.update.project')}}" method="post" enctype="multipart/form-data">
								@csrf
								<div class="box-body">
									
									@if(auth()->user()->role == 'admin')
									<div class="form-group">
										<label>ID Project</label>
										<input type="text" class="form-control" value='{{$project->id_project}}' disabled="true">
									</div>
									@endif
									<input type="hidden" id="id" name="id_project" value ="<?php echo $project->id_project; ?>">
									<div class="form-group">
										<label>Project Number</label>
										<input type="text" class="form-control" name="proj_num" value="<?php echo $project->proj_num ?>" placeholder="Project Number" required>
									</div>
									<div class="form-group">
										<label>Project Name</label>
										<input type="text" class="form-control" id="nm_project" name="nm_project" value="<?php echo $project->nm_project; ?>" required>
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