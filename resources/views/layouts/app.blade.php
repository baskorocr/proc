<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon3.png') }}" />
    <link rel="SHORTCUT ICON" href="{{ asset('img/favicon.ico') }}" />
    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/ico" />

    <!--title>{{ config('app.name', 'eProc Dharma Polimetal') }}</title-->
    <title>eProc Dharma Polimetal</title>

    <!-- Scripts -->
    <!--script src="{{ asset('js/app.js') }}" defer></script-->

    <!-- Fonts -->
    <!--link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"-->

    <!-- Styles -->
    <!--link href="{{ asset('css/app.css') }}" rel="stylesheet"-->
    
    <link rel="icon" type="image/x-icon" href="/img/favicon3.png" />
    <!-- bootstrap 3.0.2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css" integrity="sha512-PIAUVU8u1vAd0Sz1sS1bFE5F1YjGqm/scQJ+VIUJL9kNa8jtAWFUDMu5vynXPDprRRBqHrE8KKEsjA7z22J1FA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" integrity="sha512-PIAUVU8u1vAd0Sz1sS1bFE5F1YjGqm/scQJ+VIUJL9kNa8jtAWFUDMu5vynXPDprRRBqHrE8KKEsjA7z22J1FA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.18/css/dataTables.bootstrap.min.css" integrity="sha512-0YVVtCCoMlojS9USh8nXXYNhCxaeqJqTPJtJhBvtzrashDrRU8N9VWOxaBA5gfDlXYIDhbB/IxoMGZeZivOjew==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
     <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <!-- Ionicons -->
    <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/ionicons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <!--
    <link href="/css/morris/morris.css" rel="stylesheet" type="text/css" />
    -->
    <!-- jvectormap -->
    <link href="{{asset('css/jvectormap/jquery-jvectormap-1.2.2.css')}}" rel="stylesheet" type="text/css" />
    <!-- fullCalendar -->
    <link href="{{asset('css/fullcalendar/fullcalendar.css')}}" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="{{asset('css/daterangepicker/daterangepicker-bs3.css')}}" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <!--
    <link href="/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
    -->
    <!-- Theme style -->
    <link href="{{asset('css/AdminLTE.css')}}" rel="stylesheet" type="text/css" />
    <!-- DATA TABLES -->
        
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css" integrity="sha512-BMbq2It2D3J17/C7aRklzOODG1IQ3+MHw3ifzBHMBwGO/0yUqYmsStgBjI0z5EYlaDEFnvYV7gNYdD3vFLRKsA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!--
    <link href="/css/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    -->

    

    <link rel="stylesheet" href="{{asset('select/dist/css/bootstrap-select.css')}}">
    
    <!--
    <link href="/css/footable/css/footable.bootstrap.min.css" rel="stylesheet" type="text/css" />
    -->

    <!-- sweet alert -->
    <link href="{{asset('css/sweet-alert.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('js/sweet-alert/sweetalert.min.js')}}" type="text/javascript"></script>

    <link rel="stylesheet" href="{{asset('footable/plugin/css/footable.bootstrap.min.css')}}">

    <!--
    <script src="{{asset('js/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
    -->
    <link rel="stylesheet" href="{{asset('css/datepicker/datepicker.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body  class="skin-black">
{{--
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->nm_user }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
--}}

@yield('content')


<!-- jQuery 2.0.2 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
-->


<!-- jQuery UI 1.10.3 -->
<script src="{{asset('js/jquery-ui-1.10.3.min.js')}}" type="text/javascript"></script>

<!-- Bootstrap -->
<script src="{{asset('js/bootstrap.min.js')}}" type="text/javascript"></script>

<!-- AdminLTE App -->
<script src="{{asset('js/AdminLTE/app.js')}}" type="text/javascript"></script>

<!-- Morris.js charts 
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
-->
<!--
<script src="{{asset('css/raphael/raphael-min.js')}}"></script>
<script src="{{asset('js/plugins/morris/morris.min.js')}}" type="text/javascript"></script>
-->
<!-- Sparkline -->
<script src="{{asset('js/plugins/sparkline/jquery.sparkline.min.js')}}" type="text/javascript"></script>
<!-- jvectormap -->
<script src="{{asset('js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}" type="text/javascript"></script>
<!-- fullCalendar -->
<script src="{{asset('js/plugins/fullcalendar/fullcalendar.min.js')}}" type="text/javascript"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('js/plugins/jqueryKnob/jquery.knob.js')}}" type="text/javascript"></script>
<!-- daterangepicker -->
<script src="{{asset('js/plugins/daterangepicker/daterangepicker.js')}}" type="text/javascript"></script>
<!-- Bootstrap WYSIHTML5 -->
<!--
<script src="/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}" type="text/javascript"></script>
-->
<!-- iCheck -->
<!--
<script src="/js/plugins/iCheck/icheck.min.js')}}" type="text/javascript"></script>
-->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--
<script src="/js/AdminLTE/dashboard.js" type="text/javascript"></script>
-->

<!-- Bootstrap -->

<script src="{{asset('js/bootstrap.min.js')}}" type="text/javascript"></script>


<!-- DATA TABLES SCRIPT -->

{{-- <script src="{{asset('js/plugins/datatables/dataTables.bootstrap.js')}}" type="text/javascript"></script>

<script src="{{asset('js/plugins/datatables/addon/dataTables.buttons.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/plugins/datatables/addon/buttons.flash.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/plugins/datatables/addon/jszip.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/plugins/datatables/addon/pdfmake.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/plugins/datatables/addon/vfs_fonts.js')}}" type="text/javascript"></script>
<script src="{{asset('js/plugins/datatables/addon/buttons.html5.min.js')}}" type="text/javascript"></script> --}}
{{-- <script src="{{asset('js/plugins/datatables/addon/buttons.print.min.js')}}" type="text/javascript"></script> --}}

<script src="{{asset('js/plugins/input-mask/jquery.inputmask.js')}}" type="text/javascript"></script>
<script src="{{asset('js/plugins/input-mask/jquery.inputmask.date.extensions.js')}}" type="text/javascript"></script>
<script src="{{asset('js/plugins/input-mask/jquery.inputmask.extensions.js')}}" type="text/javascript"></script>

<script src="{{asset('footable/plugin/js/footable.min.js')}}"></script>

<!--
<script src="{{asset('css/footable/js/footable.min.js')}}" type="text/javascript"></script>
-->


<script type="text/javascript">
    inactivityTimeout = false;
    resetTimeout();
    function onUserInactivity() {
        window.location.href = "lock/";
    }

    function resetTimeout() {
        clearTimeout(inactivityTimeout);
        inactivityTimeout = setTimeout(onUserInactivity, 1000 * 3600); //60 minutes
    }

    window.onmousemove = resetTimeout;
    window.onkeypress  = resetTimeout;
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Page script -->
<script type="text/javascript">
    $(function() {
        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("mm.dd.yyyy", {"placeholder": "mm.dd.yyyy"});
        //Money Euro
        $("[data-mask]").inputmask();

        //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
        //Date range as a button
        $('#daterange-btn').daterangepicker(
                {
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                        'Last 7 Days': [moment().subtract('days', 6), moment()],
                        'Last 30 Days': [moment().subtract('days', 29), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                    },
                    startDate: moment().subtract('days', 29),
                    endDate: moment()
                },
        function(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        );

        //datepicker

        //$('.datepicker').datepicker();

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal',
            radioClass: 'iradio_minimal'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
        });

        //Colorpicker
        $(".my-colorpicker1").colorpicker();
        //color picker with addon
        $(".my-colorpicker2").colorpicker();

        //Timepicker
        $(".timepicker").timepicker({
            showInputs: false
        });

        $('.select2').select2();
    });

        //Date Picker


</script>
    @yield('javascript')
</body>
</html>
