@extends('layouts.main')
@section('title',"List PO")
@section('content')

    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<main id="main" class="main">
  <div class="pagetitle">
    <h1>List PO</h1>
    <nav>
      <ol class="breadcrumb">
        {{-- <li class="breadcrumb-item"><a href="{{route('home')}}">Purchasing Process</a></li> --}}
        <li class="breadcrumb-item active">List PO</li>
      </ol>
    </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="card">
        <div class="card-header">
          Search Option
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-6">
              <div class="">
                <label>Document Date</label>
                <?php
                $date_from = "";
                $date_to = "";
                $list_po;
                $list_vendor;
                if (isset($_POST['submit-find'])) {
                $date_from      = trim($_POST['date_from']);
                $date_to        = trim($_POST['date_to']);
                $list_po        = rtrim($_POST['po_sel']);
                $list_vendor    = rtrim($_POST['vend_sel']);
                }
                ?>
                <div class="" style="width: 400px;">
                  <!-- <i class="fa fa-calendar"></i> -->
                  <div class="row">
                    <div class="col-md-6">
                      from
                      <input type="text" name="date_from" id="date_from" placeholder="YYYY/MM/DD" class="datepicker form-control" value = "<?php if (isset($_POST['submit-find'])) {echo $date_from;} ?>"/>
                    </div>
                    <div class="col-md-6"> to
                      <input type="text" name="date_to" id="date_to" placeholder="YYYY/MM/DD" class="datepicker form-control" value = "<?php if (isset($_POST['submit-find'])) {echo $date_to;} ?>"/></div>
                    </div>
                    
                    <div class="col-12">
                      <label>Purchase Order</label>
                      <textarea class="form-control" rows="3" name="po_sel" id="po_textarea"  placeholder="5111000xxx"><?php if (isset($_POST['submit-find'])) { echo $list_po; } ?></textarea>
                       <a href="javascript:void(0);" onclick="$('#po_textarea').val('');">Clear</a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-5">
                  <div class="input-group col-sm-3" style="margin-top: 10px; margin-bottom: 5px">
                    <button type="submit" name="submit-find" class="btn btn-primary btn-block" style="min-width: 100%;" onclick="search()">
                    <i class="fa fa-search"></i> Search
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-lg-5">
                <div>
                  <label class="col-sm-5 col-form-label">Vendor</label>
                  <div class="col-sm-10">
                    <div class="row">
                      <div class="col-10">
                        <select name="vendor_select" class="form-select select2" id="select_vendor" aria-label="Default select example">
                          <option selected>Choose Vendor</option>
                          @foreach($list_vendor as $vendor)
                          <option value="{{ $vendor->id_vendor }}">{{ $vendor->id_vendor }} - {{ $vendor->nm_vendor }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-2">
                        <button id="add_vendor" class="btn btn-primary btn-sm" onclick="addVendor()" style="margin-left:-22px;min-width: 100%;" ><i class="fas fa-plus"></i></button>
                      </div>
                    </div>
                    <textarea class="form-control" rows="3" name="vendor_list" id="vendor_list"  placeholder="1000xxx"></textarea>
                    <a href="javascript:void(0);" onclick="$('#vendor_list').val('');">Clear</a>
                  </div>
                </div>
                <br>
              </div>
            </div>
          </div>
        </div>
        
        
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive mt-3">
                  <table  class="table table-bordered nowrap table-striped table-sm" id="tb-list-po">
                    <thead>
                <th style="min-width: 106px" data-visible="true">PO Number</th>
                <th style="min-width: 65px">Rev No</th>
                <th style="min-width: 60px">Plant</th>
                <th style="min-width:  60px">Vendor</th>
                <th style="min-width: 250px">Vendor Name</th>
                <th style="min-width: 220">Vendor Mail</th>
                <th style="min-width: 106px">Doc Date</th>
                <th style="min-width:  30px">PGr</th>
                <th style="min-width: 106px" title="without Tax">PO Amount</th>
                <th style="min-width: 106px" title="with Tax">Total Amount</th>
                <th style="min-width: 30px">Curr</th>
                <th style="min-width: 26px">
                    <i class="fa fa-check"></i>



                </th>
                <th style="min-width: 26px">
                    <i class="fa fa-envelope"></i>
                </th>
                <th style="min-width: 26px" >
                    <i class="fa fa-file"></i>
                </th>
                <th style="min-width: 26px">
                    <i class="fa fa-download"></i>
                </th>
                <th style="min-width: 106px">Upload Date</th>
                <th style="min-width: 106px">Upload Group</th>
                <th style="min-width: 106px" data-breakpoints="all">Filename</th>
                     {{--  <th>PO Number</th>
                      <th>Rev No</th>
                      <th>Plant</th>
                      <th>Vendor</th>
                      <th>Vendor Name</th>
                      <th>Vendor Mail</th>
                      <th>Doc Date</th>
                      <th>Pgr</th>
                      <th>Curr</th>
                      <th>Filename</th> --}}
                    </thead>
                    <tbody>
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
    @endsection
    @section('javascript')
     {{-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> --}}
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <script>
     function addVendor()
     {
      const textarea = document.getElementById('vendor_list');

      textarea.value += document.getElementById('select_vendor').value+'\n'
     }

 $('#date_from').datepicker({
            uiLibrary: 'bootstrap5',
             format: 'yyyy-mm-dd'
        });
 $('#date_to').datepicker({
            uiLibrary: 'bootstrap5',
            format: 'yyyy-mm-dd'
        });
  
    //  $(document).ready(function(){
    //  window.table = $('#tb-list-po').DataTable({
    //    columnDefs: [
    // {
    // searchable: false,
    // orderable: false,
    // targets: 0,
    // }],
    //  "order": [[ 1, "DESC" ]],
    //  processing: true,
    //  serverSide: true,
    //  autoWidth:false,
    //  "language": {
    //  "processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
    //  },
    //  ajax: "{{ route('datatables.purchasing.process.listpo')}}",
    //  columns: [
    //         {
    //        data: 'DT_RowIndex',
    //        name: 'DT_RowIndex'
    //        },
    //        {
    //        data: 'po_num',
    //        name: 'po_num'
    //        },
    //  ]
    //  });
    // window.table.on('order.dt search.dt', function () {
    // let i = 1;
    
    // window.table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
    // this.data(i++);
    // });
    // }).draw();
    // })
    var table = $('#tb-list-po').DataTable({autoWidth:false,
    "order": [[ 1, "DESC" ]],
    processing: true,
    serverSide: true,
    autoWidth:false,
    "language": {
    "processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
    },
    ajax: {
       type: 'POST',
    data: (item) => {
    item._token = '{{ csrf_token() }}';
    item.po_num = $('#po_textarea').val();
    item.date_from = $('#date_from').val();
    item.date_to = $('#date_to').val();
    item.id_vendor = $('#select_vendor').val().toString();
    item.vendor_list = $('#vendor_list').val();
     item.vendor_select = $('#select_vendor').val();
    },
    url: "{{ route('datatables.purchasing.process.listpo')}}"
    },
    columns: [
    // {
    //   data: 'DT_RowIndex',
    //   name: 'DT_RowIndex'
    // },
    {
    data: 'po_num',
    name: 'po_num'
    },
    {
    data: 'revno',
    name: 'revno'
    },
    {
    data: 'plant',
    name: 'plant'
    },
    {
    data: 'id_vendor',
    name: 'id_vendor'
    },
    {
    data: 'nm_vendor',
    name: 'nm_vendor'
    },
    {
    data: 'vend_email',
    name: 'vend_email'
    },
    {
    data: 'doc_date',
    name: 'doc_date'
    },
    {
    data: 'pgr',
    name: 'pgr'
    },
    {
    data: 'po_amount',
    name: 'po_amount'
    },
    {
    data: 'total_amount',
    name: 'total_amount'
    },
    {
    data: 'curr',
    name: 'curr'
    },
    {
    data: 'rel_stat',
    name: 'rel_stat'
    },
    {
    data: 'mail_stat',
    name: 'mail_stat'
    },
    {
    data: 'file_exist',
    name: 'file_exist'
    },
    {
    data: 'download_stat',
    name: 'download_stat'
    },
    {
    data: 'upload_date',
    name: 'upload_date'
    },
    {
    data: 'upload_group',
    name: 'upload_group'
    },
    {
    data: 'file_nm',
    name: 'file_nm'
    },
    ]
    });
    function search() {
    table.draw();
    }
    $('.select2').select2();
   
    </script>
    @endsection