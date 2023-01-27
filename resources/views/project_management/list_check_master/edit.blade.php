@extends('layouts.main')
@section('title',"Edit Part")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Edit List Check Doc</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
				<li class="breadcrumb-item active">Edit List Check Doc</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="{{route('project.management.master.listcheck.modify.doc.update')}}" method="post" enctype="multipart/form-data">
								@csrf
								<div class="box-body">
									
									
									<div class="form-group">
										<label>Document Name</label>
										<input type="text" class="form-control" value='{{$checklist->docParts->nm_doc_part}}' disabled="true">
									</div>
									
									<input type="hidden" id="id" name="id_check" value ="<?php echo $checklist->id_check; ?>">
									<div class="form-group">
										<label>Check Parameter Name</label>
										<input type="text" class="form-control" name="check_params" value="<?php echo $checklist->check_params ?>" placeholder="product Number" required>
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
										<button type="submit" id="edit-prodmaster" name="edit-prodMaster" class="btn btn-primary"><i class="fas fa-edit"></i> Update</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</section>
		</main>
		@endsection