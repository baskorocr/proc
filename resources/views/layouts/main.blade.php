<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>eProc Dharma Polimetal | @yield('title')</title>
    <meta content="e-Procurement Dharma Polimetal" name="description">
    <meta content="eproc,Dharma Polimetal,eprocurement" name="keywords">
    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon3.png') }}" />
    <link rel="SHORTCUT ICON" href="{{ asset('img/favicon3.png') }}" />
    <link rel="icon" href="{{ asset('img/favicon3.png') }}" type="image/ico" />
    <!-- Google Fonts -->
    <link href="{{ URL::asset('assets/template/css/fontgoogle.css') }}" rel="stylesheet">
    
    <!-- Vendor CSS Files -->
    <style type="text/css">
    div.table-responsive > div.dataTables_wrapper > div.row
    {
    overflow:auto !important;
    }
    </style>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="dns-prefetch" href="//cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="//unpkg.com">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link href="{{ URL::asset('assets/template/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/template/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/template/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/template/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/template/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/template/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/template/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/template/vendor/simple-datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.1/sweetalert2.css" integrity="sha512-JzSVRb7c802/njMbV97pjo1wuJAE/6v9CvthGTDxiaZij/TFpPQmQPTcdXyUVucsvLtJBT6YwRb5LhVxX3pQHQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Template Main CSS File -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ URL::asset('assets/template/css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
    .breadcrumb > li:first-of-type {
    content: none;
    }
    /* .breadcrumb > li:before {
    content: none;
    }*/
    </style>
    <style>
    table.dataTable > tbody > tr.selected > * {
    box-shadow: inset 0 0 0 9999px #848484    !important;
    color: white;
    }
    table.dataTable.table-striped > tbody > tr.odd.selected {
    box-shadow: inset 0 0 0 9999px #848484   !important;
    color: white;
    }
    </style>
  </head>
<body>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    
    <div class="d-flex align-items-center justify-content-between">
      <a href="/dashboard" class="logo d-flex align-items-center">
        <img src="{{ URL::asset('assets/template/img/logo1.png') }}" alt="">
        <span class="d-none d-lg-block">eProcurement</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
      </div><!-- End Logo -->
      {{--     <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="POST" action="#">
          <input type="text" name="query" placeholder="Search" title="Enter search keyword">
          <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
        </div><!-- End Search Bar --> --}}
        <nav class="header-nav ms-auto">
          <ul class="d-flex align-items-center">
            <li class="nav-item d-block d-lg-none">
              <a class="nav-link nav-icon search-bar-toggle " href="#">
                <i class="bi bi-search"></i>
              </a>
              </li><!-- End Search Icon-->
              <li class="nav-item dropdown pe-3">
                
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                  <img src="{{ URL::asset('assets/template/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
                  <span class="d-none d-md-block dropdown-toggle ps-2">{{Session::get('nm_user')}}</span>
                  </a><!-- End Profile Iamge Icon -->
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                      <h6>{{Session::get('nm_user')}}</h6>
                      <span>{{empty(auth()->user()->roles) ? "-":auth()->user()->roles->name}}</span><br>
                      <span>{{Request::ip()}}</span>
                    </li>
                    <li>
                      <hr class="dropdown-divider">
                    </li>
                    <li>
                      <a class="dropdown-item d-flex align-items-center" href="{{route('change.pwd.link')}}">
                        <i class="bi bi-key"></i>
                        <span>Change Password</span>
                      </a>
                    </li>
                    <li>
                      <hr class="dropdown-divider">
                    </li>
                    <li>
                      <a class="dropdown-item d-flex align-items-center" href="{{ url('/logout') }}">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Sign Out</span>
                      </a>
                    </li>
                    </ul><!-- End Profile Dropdown Items -->
                    </li><!-- End Profile Nav -->
                  </ul>
                  </nav><!-- End Icons Navigation -->
                  </header><!-- End Header -->
                  <!-- ======= Sidebar ======= -->
                  @include('menu.side-menu')
                  @yield('content')
                  
                  <!-- ======= Footer ======= -->
                  <footer id="footer" class="footer">
                    {{--  <div class="copyright">
                      &copy; Development By <strong><span>Kelola Bisnis Indonesia</span></strong>.
                    </div> --}}
                    </footer><!-- End Footer -->
                    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
                    <!-- Vendor JS Files -->
                    <script src="{{ URL::asset('assets/template/vendor/apexcharts/apexcharts.min.js') }}"></script>
                    <script src="{{ URL::asset('assets/template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
                    <script src="{{ URL::asset('assets/template/vendor/chart.js/chart.umd.js') }}"></script>
                    <script src="{{ URL::asset('assets/template/vendor/echarts/echarts.min.js') }}"></script>
                    <script src="{{ URL::asset('assets/template/vendor/quill/quill.min.js') }}"></script>
                    <script src="{{ URL::asset('assets/template/vendor/simple-datatables/simple-datatables.js') }}"></script>
                    <script src="{{ URL::asset('assets/template/vendor/tinymce/tinymce.min.js') }}"></script>
                    <script src="{{ URL::asset('assets/template/vendor/php-email-form/validate.js') }}"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.1/sweetalert2.min.js" integrity="sha512-vCI1Ba/Ob39YYPiWruLs4uHSA3QzxgHBcJNfFMRMJr832nT/2FBrwmMGQMwlD6Z/rAIIwZFX8vJJWDj7odXMaw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                    <!-- Additional -->
                    <script src="{{ URL::asset('assets/template/js/jquery-3.5.1.js') }}"></script>
                    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
                    <script src="{{ URL::asset('assets/template/vendor/simple-datatables/jquery.dataTables.min.js') }}"></script>
                    <script src="{{ URL::asset('assets/template/vendor/simple-datatables/dataTables.bootstrap5.min.js') }}"></script>
                    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
                    <!-- Template Main JS File -->
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                    <script src="{{ URL::asset('assets/template/js/main.js') }}"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script>
  $(document).ready(function () {
    $('.datatables').DataTable();

    //SideBar
    var url = window.location;           
    $('.nav-item a').each(function () { 
      var a= this;
         if (a.href == url) {
            if ( $(a).hasClass('nav-link')) {
                    $(this).removeClass('collapsed'); 
                }else{
                  var object = $(a).parents('.nav-item');
                  $(object).find('a').removeClass('collapsed');
                  $(object).find('ul').addClass('show');
                  $(a).addClass('active');
                }
         }
    });
  });

  //SideBar
  $(".nav-item a").on('click', function (e) {
    $('.nav-link').each(function () {   
      $(this).addClass('collapsed');
    });
    $(this).removeClass('collapsed');
    
    if ($('.nav-link ul').hasClass('collapsed')) {
        $('.nav-link ul').each(function () {   
          $(this).removeClass("show");
        });
          $(this).addClass('show');
      }

  });
  
//SideBar
  $(".nav-content a").on('click', function (e) {
    $('.nav-content a').each(function () {   
      $(this).removeClass('active');
    });
    $(this).addClass('active');

  });

  </script>

 
  </script>
  @if(!empty( session('message_success')))
<script type="text/javascript">
      $(function() {
        const Toast = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: false,
      timer: 3000
    });
     Toast.fire({
            icon: 'success',
            title: " {{session('message_success')}}"
          })
    });
    </script>
@endif
 @if(!empty( session('message_fail')))
<script type="text/javascript">
      $(function() {
        const Toast = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: false,
      timer: 3000
    });
     Toast.fire({
            icon: 'error',
            title: " {{session('message_fail')}}"
          })
    });
    </script>
@endif
@if(!empty( session('message_warning')))
<script type="text/javascript">
      $(function() {
        const Toast = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: false,
      timer: 3000
    });
     Toast.fire({
            icon: 'warning',
            title: " {{session('message_warning')}}"
          })
    });
    </script>
@endif
<script>
   var idleTime = 0;
    $(document).ready(function () {
        // Jika iddle tambah 1 tiap menit
        var idleInterval = setInterval(timerIncrement, 60000); // 1 minute

        // Ubah jadi nol jika ada pergerakan
        $(this).mousemove(function (e) {
            idleTime = 0;
            // console.log("CANCEL")
        });
        $(this).keypress(function (e) {
            idleTime = 0;
            // console.log(idleTime)
        });
    });

    function timerIncrement() {
        idleTime = idleTime + 1;
        if (idleTime >= {{env('MAX_IDLE_TIME',30)}}) { // 30 minutes
          idle_check();
        }
    }


  function idle_check()
  {
       axios.post('{{route('idle_set')}}', {
          _token: '{{csrf_token()}}',
          redirect_lockscreen: '{{url()->full()}}'
        })
        .then(function (response) {
          console.log(response);
          location.reload();
        })
        .catch(function (error) {
          // console.log(error);
        }); 
  }
  
</script>
  @yield('javascript')
</body>

@if(Session::has('message_success'))
<script type="text/javascript">
      $(function() {
        const Toast = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: false,
      timer: 3000
    });
     Toast.fire({
            icon: 'success',
            title: " {{Session::get('message_success')}}"
          })
    });
    </script>
@endif
@if(Session::has('message_fail'))
<script type="text/javascript">
      $(function() {
        const Toast = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: false,
      timer: 3000
    });
     Toast.fire({
            icon: 'error',
            title: " {{Session::get('message_fail')}}"
          })
    });
    </script>
@endif
</html>