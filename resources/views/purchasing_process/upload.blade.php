@extends('layouts.main')
@section('title',"Upload PO")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Upload Approved PO</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Purchasing Process</a></li>
				<li class="breadcrumb-item active">Upload Approved PO</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">

                <div class="col-lg-3">
                    
                    <div class="row mb-3">
                        <label for="inputNumber" class="col-sm-24 col-form-label">File Upload</label>
                        <div class="col-sm-20">
                            <input class="form-control" style="width:250px" type="file" id="formFile">
                        </div>
                    </div>

                    <div class="input-group col-sm-3" style="margin-top: 10px; margin-bottom: 5px">
                        <button type="submit" name="submit-find" class="btn btn-primary" onclick="">
                            <i class="fa fa-upload"></i> Upload
                        </button>
                    </div>
                </div>

				
			</div>
		</section>
	</main>
	@endsection
	@section('javascript')
	<script>
	
	</script>
	@endsection