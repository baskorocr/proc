@extends('layouts.applogin')


@section('content')

	<div class="limiter">
		<div class="container-login100">
		
			<div class="wrap-login100">
				<form class="login100-form validate-form" role=form name="Form1" id="Form1" onSubmit="return myLoader()" action="{{ route('login') }}" method="post">
				
				@csrf
				
					<div class="login-logo" style="margin-top: -8%;" >
						<br>
						<center><img src="../assets/login/images/logo1.png" style="width: 80px; margin-top: 10%;"></center>
					</div>
                    <br>
                    <center><b style="color: #000; font-size: 20px;">eProcurement</b></center>
                    <br>
					
					<label >USERNAME</label>
					 <div class="form-group has-feedback">
						<input type="text" id="username" placeholder="Username" class="form-control @error('username') invalid @enderror"  name="username" required/>
						<!--
						<span class="glyphicon glyphicon-user form-control-feedback"></span>
						-->
						@error('username')
							<span class="invalid-feedback">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					  </div>
					  
					  <label >PASSWORD</label>
					  <div class="form-group has-feedback">
						<input type="password" id="password" name="password" class="form-control @error('password') invalid @enderror" placeholder="Password" required/>
						<!--
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
						-->
						@error('password')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					  </div>
				
					 <div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit" id="login" name='login'>
							Login
						</button>
					</div>
					
					
				</form>

                <!--
				<div class="login100-more" style="background-image: url('../assets/login/images/bg-01.jpg');">
				</div>
				-->

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