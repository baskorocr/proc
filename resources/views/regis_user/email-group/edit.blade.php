@extends('layouts.main')
@section('title',"Edit Project")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Email Group</h1>
		<nav>
			<ol class="breadcrumb">
				
				<li class="breadcrumb-item active">Edit Email Group</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="{{route('regis-user.email-group.update.email')}}" method="post" enctype="multipart/form-data">
								@csrf
								<input type="hidden" name="id" value ="<?php echo $email->id; ?>">
								<div class="box-body">
									<div class="form-group">
										<label>Departement Code</label>
										<input type="text" class="form-control" id="dept_code" name="dept_code" value="<?php echo $email->dept_code; ?>" required>
									</div>
									<div class="form-group">
										<label>Abbreviation (SAP PO Creator) </label>
										<input type="text" class="form-control" id="abrev" name="abrev" value="<?php echo $email->abrev ?>" placeholder="Abreviation" required>
									</div>
									<div class="form-group">
										<label>Departement Description </label>
										<input type="text" class="form-control" id="dept_desc" name="dept_desc" value="<?php echo $email->dept_desc ?>" placeholder="Departement Description" required>
									</div>
									{{-- <div class="form-group">
										<label>Status Active</label>
										<select name="active" class="form-control">
											<option {{$email->active=="A"?"selected":null}} value="A">Active</option>
											<option  {{$email->active=="N"?"selected":null}} value="N">Non-Active</option>
										</select>
									</div> --}}
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