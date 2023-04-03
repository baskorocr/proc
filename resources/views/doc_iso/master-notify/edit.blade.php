@extends('layouts.main')
@section('title',"Edit Project")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Master Notify</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
				<li class="breadcrumb-item active">Edit Master Notify</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="{{route('doc-iso.master-notify.update.notify')}}" method="post" enctype="multipart/form-data">
								@csrf
								<input type="hidden" name="id" value ="<?php echo $notify->id; ?>">
								<div class="box-body">
									
									@if(auth()->user()->role == 'admin')
									<div class="form-group">
										<label>Notification Termin</label>
										<input type="text" class="form-control" value='{{$notify->notif_id}}' disabled="true">
									</div>
									@endif
									<input type="hidden" id="id" name="notif_id" value ="<?php echo $notify->notif_id; ?>">
									<div class="form-group">
										<label>Notif Before Expired Date </label>
										<input type="text" class="form-control" name="notif_before" value="<?php echo $notify->notif_before ?>" placeholder="Project Number" required>
									</div>
									<div class="form-group">
										<label>Measurement</label>
										<input type="text" class="form-control" id="uom" name="uom" value="<?php echo $notify->uom; ?>" required>
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