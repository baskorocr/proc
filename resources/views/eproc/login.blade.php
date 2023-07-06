@extends('eproc.layouts.applogin')

@section('content')

	<div class="limiter">
		<div class="container-login100">
		
			<div class="wrap-login100">
				<!-- <form class="login100-form validate-form" id="formSubmit" onSubmit="return myLoader()" enctype="multipart/form-data"> -->
				<form class="login100-form validate-form" id="formSubmit" enctype="multipart/form-data" data-action="{{ url('api/login') }}">

    
                @csrf
					<div class="login-logo" style="margin-top: -8%;" >
						<br>
						<center><img src="{{asset('assets/login/images/logo1.png')}}" style="font-family: Montserrat-Bold; width: 80px; margin-top: 10%;"></center>
					</div>
                    <br>
                    <center><b style="color: #000; font-size: 20px;">{{env('APP_NAME')}}</b></center>
                    <br>
					<div class="callout callout-danger alert-dismissable div_notif" style="display:none">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <medium id="label_notif"></medium>
                    </div>
					<label >USERNAME</label>
					 <div class="form-group has-feedback">
						<input type="text" id="username" placeholder="Username" class="form-control"  name="username" required/>
                    </div>
					  
                    <label >PASSWORD</label>
                    <div class="form-group has-feedback">
						<input type="password" id="password" name="password" class="form-control" placeholder="Password" required/>
                    </div>
				
					 <div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit"  id="login">
							Login
						</button>
					</div>
					
					
				</form>

               

                <div class="login100-more animated fade-in" style="background-image: url('../assets/login/images/bg-01.jpg');">
                </div>

                <div class="login100-more w3-animate-opacity" style="background-image: url('../assets/login/images/bg-04.jpg');">
                </div>

                <div class="login100-more animated fade-in" style="background-image: url('../assets/login/images/bg-06.jpg');">
                </div>

                <div class="login100-more w3-animate-opacity" style="background-image: url('../assets/login/images/bg-05.jpg');">
                </div>
				
			</div> <!-- wrap -->
			
		</div> <!-- container -->
		
	</div> <!-- limiter -->


@endsection
<script src="{{ asset('assets/template/js/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('source_js/auth/login.js') }}"></script>
