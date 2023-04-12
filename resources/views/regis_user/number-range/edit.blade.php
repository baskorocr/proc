@extends('layouts.main')
@section('title',"Edit Number Range")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Number Range</h1>
		<nav>
			<ol class="breadcrumb">
				{{-- <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li> --}}
				<li class="breadcrumb-item active">Edit Number Range</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="{{route('regis-user.number-range.update.number')}}" method="post" enctype="multipart/form-data">
								@csrf
								<input type="hidden" name="id" value ="<?php echo $number->id; ?>">
								<div class="box-body">
									<div class="form-group">
										<label>Document Type</label>
										 <select class="form-control selectpicker" name="doc_type" data-live-search="true" focused required>
					                        <option value="iso" {{$number->doc_type == 'iso' ? "selected":null}}>iso</option>
					                    </select>
									</div>
									<div class="form-group">
										<label>Document Year </label>
										<input type="text" class="form-control" id="doc_year" name="doc_year" value="<?php echo $number->doc_year ?>" placeholder="ex. {{date('Y')}}" required>
									</div>
									
									<div class="form-group">
										<label>Low Number</label>
										<input type="text" class="form-control" placeholder="ex. 00000" id="num_low" name="num_low" value="<?php echo $number->num_low; ?>" required>
									</div>
									<div class="form-group">
										<label>High Number</label>
										<input type="text" class="form-control" id="num_high" placeholder="ex. 99999" name="num_high" value="<?php echo $number->num_high; ?>">
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