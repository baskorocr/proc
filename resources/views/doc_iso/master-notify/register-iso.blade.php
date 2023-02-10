@extends('layouts.main')
@section('title',"Form Input Page")
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Register ISO Document</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
          <li class="breadcrumb-item active">Register ISO</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">General Form Register ISO</h5>

              <!-- General Form Elements -->
         
              <div class="card">
            <div class="card-body">
              <h5 class="card-title">Multi Columns Form</h5>

              <!-- Multi Columns Form -->
              <form class="row g-3" action="{{ route('doc-iso.register-iso.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                  <label  style="font-size:15px" for="inputText" class="col-sm-2 col-form-label">Vendor</label>
                  <div class="col-sm-10">
                    <select name="id_vendor" class="form-select" aria-label="Default select example">
                      <option selected disabled>Open this select menu</option>
                      @foreach($vendor as $item)
                      <option value="{{ $item->id_vendor }}">{{ $item->nm_vendor }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="row mb-3">
                  <label  style="font-size:15px" for="inputText" class="col-sm-2 col-form-label">Material Supply</label>
                  <div class="col-sm-10">
                    <input name="mat_supply" type="text" class="form-control">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-12 ms-3 form-check">
                    <input name="simply" class="form-check-input" type="checkbox" id="gridCheck2" checked="">
                    <label class="form-check-label" for="gridCheck2"> Simplikasi </label>
                  </div>
                </div>
                
                <div class="row mb-3">
                  <label  style="font-size:15px" for="inputText" class="col-sm-2 col-form-label">Certified</label>
                  <div class="col-sm-10">
                    <input name="cert_name" type="text" class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                  <label  style="font-size:15px" for="inputText" class="col-sm-2 col-form-label">ISO Type</label>
                  <div class="col-sm-10">
                    <input name="iso_type_name" type="text" class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                  <label  style="font-size:15px" for="inputText" class="col-sm-2 col-form-label">ISO Certified Number</label>
                  <div class="col-sm-10">
                    <input name="cert_num" type="text" class="form-control">
                  </div>
                </div>
        
                <div class="row mb-3">
                  <label  style="font-size:15px" for="inputDate" class="col-sm-2 col-form-label">ISO Certified Date</label>
                  <div class="col-sm-10">
                    <input name="cert_date" type="date" class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                  <label    style="font-size:15px" for="inputDate" class="col-sm-2 col-form-label">ISO Expired Date</label>
                  <div class="col-sm-10">
                    <input name="exp_date" type="date" class="form-control">
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
                      <td style="font-size:12px">{{ $item->notif_id }}</td>
                      <td style="font-size:12px">{{ $item->notif_seq }}</td>
                      <td style="font-size:12px">{{ $item->notif_before }}</td>
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
                    <input name="file" class="form-control" type="file" id="formFile">
                  </div>
                </div>
                <div class="text-left">
                  <button type="submit" class="btn btn-primary">Submit</button>
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

       
              </form>

            </div>
          </div>

        </div>
      </div>
    </section>


  </main><!-- End #main -->
@endsection
