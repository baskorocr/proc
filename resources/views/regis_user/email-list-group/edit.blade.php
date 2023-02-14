@extends('layouts.main')
@section('title',"Edit Project")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Email List Group</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
				<li class="breadcrumb-item active">Edit List Email Group</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="{{route('regis-user.email-list-group.update.listemail')}}" method="post" enctype="multipart/form-data">
								@csrf
								<input type="hidden" name="id" value ="<?php echo $listemail->id; ?>">
								<div class="box-body">
									<div class="form-group">
										<label>Email</label>
										<input type="text" class="form-control" id="mail" name="mail" value="<?php echo $listemail->mail; ?>" required>
									</div>
									<div class="form-group">
										<label>Departement</label>
										<input type="text" class="form-control" id="dept_code" name="dept_code" value="<?php echo $listemail->dept_code ?>" placeholder="Departement" required>
									</div>
									<div class="form-group">
										<label>Name </label>
										<input type="text" class="form-control" id="name" name="name" value="<?php echo $listemail->name ?>" placeholder="" required>
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