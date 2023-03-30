@extends('layouts.main')
@section('title',"Upload Vendor Master Data")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>
Upload Vendor Master Data
</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Master Vendor</a></li>
				<li class="breadcrumb-item active">Upload Vendor Master Data</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<form action="{{ url('regis-user/upload-vendor') }}" method="post" enctype='multipart/form-data'>
				@csrf

                <div class="col-lg-3">
                    
                    <div class="row mb-3">
                        <label for="inputNumber" class="col-sm-24 col-form-label">Upload Data Vendor</label>
                        <div class="col-sm-20">
                            <input class="form-control" required style="width:250px" type="file" name="file" id="formFile">
                            <p class="help-block">vendordata.xls</p>
                        </div>
                    </div>

                    <div class="input-group col-sm-3" style="margin-top: 10px; margin-bottom: 5px">
                        <button type="submit" name="submit-find" class="btn btn-primary">
                            <i class="fa fa-upload"></i> Upload
                        </button>
                    </div>
                </div>

</form>

				
			</div>
		</section>
	</main>
	@endsection
	@section('javascript')
	<script>
	
	</script>
	@endsection