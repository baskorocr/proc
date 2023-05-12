@extends('layouts.main')
@section('title',"Change Password")
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Change Password</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Change Password</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-12">

         <div class="alert alert-info">
          <i class="fas fa-info-circle"></i> Alert! If you need to change your password, please do so below. You will need to enter your current password in order to change it. 
         </div>

        </div>

        <div class="col-12">

          <form role="form" name="passch" id="passch"  action="{{route('change.pwd.act')}}" method="post" enctype="multipart/form-data">
        
        <div class="box-body">                            
            @csrf


            
            <div class="form-group">
                <label>Login Username</label>
                <input type="text" class="form-control" id="nm_user" name="username" value="{{auth()->user()->username}}" required="" disabled=""> 
            </div>

            <div class="form-group">
            <label>Current Password</label>
                <div class="form-group input-group input-group-sm">
                    <input type="password" class="form-control" id="curr-pass" name="curr_pass" data-toggle="password" placeholder="Current password" required="" focused="">

                    <span class="input-group-btn">
                        <button type="button" id="show" class="btn btn-primary" data-toggle="tooltip" title="" onclick="showPass()" data-original-title="show"><i class="fas fa-eye" style="color: #fff;"></i>
                        </button>
                    </span>
                </div>    
            </div>                                                                    
                
            <div class="form-group">
                <label>New Password</label>
                <input type="password" class="form-control" title ="Minimum 5 Character" id="new-pass" min="8" name="password" placeholder="New password" required=""> 
            </div>

            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" class="form-control" id="conf-pass" min="8" name="password_confirmed" placeholder="Confirm password" data-toggle="password" required=""> 
            </div> 

            <div class="form-group">
                <span id="message"></span>
            </div>                                                                 
    
      </div><!-- /.box-body -->

          <div class="box-footer mt-2">
              <button type="submit" id="edit-pass" name="edit-pass" class="btn btn-primary"><i class="fa fa-lock"></i>&nbsp; Change</button>
          </div>
    </form>

        </div>
      </div>
    </section>

  </main><!-- End #main -->
@endsection
@section('javascript')
<script>
  function showPass() {
  var x = document.getElementById("curr-pass");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
} 
</script>
@endsection