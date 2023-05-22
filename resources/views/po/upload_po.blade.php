@extends('layouts.main')
@section('title',"Upload Approved PO")
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Upload Approved PO</h1>
      <nav>
        <ol class="breadcrumb">
          {{-- <li class="breadcrumb-item"><a href="index.html">Purchasing Process</a></li> --}}
          <li class="breadcrumb-item active">Upload Approved PO</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Upload Data PO</h5>
              <form id="formSubmit" enctype="multipart/form-data" data-action="{{ url('po/upload') }}">
                <div class="row mb-3">
                  <label for="inputNumber" class="col-sm-2 col-form-label">File Upload</label>
                  <div class="col-sm-10">
                    <input class="form-control" type="file" id="import_file" name="import_file" accept=".xlsx, .xls">
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
<script src="{{ asset('assets/template/js/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('source_js/po/upload_po.js') }}"></script>

