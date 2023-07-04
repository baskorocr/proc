@extends('layouts.main')
@section('title',"Register New ISO Doc")
@section('content')
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" integrity="sha512-xrbX64SIXOxo5cMQEDUQ3UyKsCreOEq1Im90z3B7KPoxLJ2ol/tCT0aBhuIzASfmBVdODioUdUPbt5EDEXmD9g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Register ISO Document</h1>
      <nav>
        <ol class="breadcrumb">
          {{-- <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li> --}}
          <li class="breadcrumb-item active">Register ISO</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-3">Form Register ISO</h5>

              <!-- General Form Elements -->
         
              {{-- <h5 class="card-title">Multi Columns Form</h5> --}}

              <!-- Multi Columns Form -->
              <form id="regiso" class="row g-3" action="{{ route('doc-iso.register-iso.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                  <label  style="font-size:15px" for="inputText" class="col-sm-2 col-form-label">Vendor</label>
                  <div class="col-sm-10">
                     
                    @if(auth()->user()->is_vendor)
                      <b>{{ auth()->user()->foreign_id }} - {{ auth()->user()->vendor->nm_vendor }}</b>
                      <input type="hidden" name="id_vendor" value="{{ auth()->user()->foreign_id }}">
                    @else
                    <select name="id_vendor" id="id_vendor" required class="form-select" aria-label="Default select example">
                      <option selected disabled>Select Vendor</option>
                      @foreach($vendor as $item)
                      <option value="{{ $item->id_vendor }}">{{ $item->nm_vendor }}</option>
                      @endforeach
                    </select>
                    @endif
                  </div>
                </div>

                <div class="row mb-3">
                  <label  style="font-size:15px" for="inputText" class="col-sm-2 col-form-label">Material Supply</label>
                  <div class="col-sm-10">
                    <input name="mat_supply" type="text"  class="form-control upper" required>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-12 ms-3 form-check">
                    <input name="simply" class="form-check-input" type="checkbox" id="gridCheck2" required checked="">
                    <label class="form-check-label" for="gridCheck2"> Simplikasi </label>
                  </div>
                </div>
                
                <div class="row mb-3">
                  <label  style="font-size:15px"  for="inputText" class="col-sm-2 col-form-label">Certified</label>
                  <div class="col-sm-10">
                    <input name="cert_name"  required type="text" class="form-control upper">
                  </div>
                </div>
                <div class="row mb-3">
                  <label  style="font-size:15px" for="inputText" class="col-sm-2 col-form-label">ISO Type</label>
                  <div class="col-sm-10">
                    <input name="iso_type_name"   required type="text" class="form-control upper">
                  </div>
                </div>
                <div class="row mb-3">
                  <label  style="font-size:15px" for="inputText"  class="col-sm-2 col-form-label">ISO Certified Number</label>
                  <div class="col-sm-10">
                    <input name="cert_num" required type="text" class="form-control upper">
                  </div>
                </div>
        
                <div class="row mb-3">
                  <label  style="font-size:15px" for="inputDate" class="col-sm-2 col-form-label">ISO Certified Date</label>
                  <div class="col-sm-10">
                    <input name="cert_date" id="cert_date" placeholder="DD-MM-YYYY" required type="text" class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                  <label    style="font-size:15px" for="inputDate" class="col-sm-2 col-form-label">ISO Expired Date</label>
                  <div class="col-sm-10">
                    <input name="exp_date" id="exp_date" placeholder="DD-MM-YYYY" required type="text" class="form-control">
                  </div>
                </div>
                <table  class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th style="font-size:12px" >Notif ID</th>
                      <th style="font-size:12px">Notify Sequence</th>
                      <th style="font-size:12px">Notify Before</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($notify as $item)
                   <tr>
                       <?php 
                       if ($item->uom == "M"){
                                        $measure = "Months";
                                    } elseif($item->uom == "D"){
                                        $measure = "Days";
                                    } elseif($item->uom  == "Y"){
                                        $measure = "Year";
                                    }
                            ?>
                      <td style="font-size:12px">{{ $item->notif_id }}</td>
                      <td style="font-size:12px">{{ $item->notif_seq }}</td>
                      <td style="font-size:12px">{{ $item->notif_before }} {{$measure}}</td>
                    </tr> 
                    @endforeach
                  </tbody>
                </table> 
                <div style="marginTop: 100%;" class="row mb-3">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Remarks</label>
                  <div class="col-sm-10">
                    <textarea name="remark" class="form-control" style="height: 100px"></textarea>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputNumber" class="col-sm-2 col-form-label">File Input</label>
                  <div class="col-sm-10">
                    <input name="file" required accept="application/pdf" class="form-control" type="file" id="formFile">
                    <small>upload ISO pdf file</small>
                  </div>
                </div>
                <div class="text-left">
                  <button type="submit" id="submit-iso" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form><!-- End Multi Columns Form -->

            </div>
          </div>

        </div>

              </form>

            </div>
          </div>

        </div>

       
      

        

        </div>
      </div>
    </section>


  </main><!-- End #main -->
@endsection
@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>

    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
<script>
  $(".upper").on( "keyup", function( event ) {
        $(this).val(function(i,val) {
           return val.toUpperCase();
        });
    });
 
  $('#regiso').submit(function(e){
    let timerInterval
    Swal.fire({
      title: 'Transaction Progress',
      html: 'Please wait...',
      timer: 300000,
      // timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading()
        const b = Swal.getHtmlContainer().querySelector('b')
        timerInterval = setInterval(() => {
          b.textContent = Swal.getTimerLeft()
        }, 100)
      },
      willClose: () => {
        clearInterval(timerInterval)
      }
    }).then((result) => {
      $('#regiso').trigger('submit')
    })
  })

    $(document).ready(function() {
      $('#id_vendor').select2();
    });

 $('#cert_date').datepicker({
            uiLibrary: 'bootstrap5',
             format: 'dd-mm-yyyy'
        });
 $('#exp_date').datepicker({
            uiLibrary: 'bootstrap5',
            format: 'dd-mm-yyyy'
        });
</script>
@endsection
