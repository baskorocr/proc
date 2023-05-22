@extends('layouts.main')
@section('title',"Monitoring Delivery")
@section('content')
<link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    div.table-responsive > div.dataTables_wrapper > div.row
{
    overflow:auto !important;
}
div.dataTables_wrapper div.dt-row{
    min-height:100px;
}
</style>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Monitoring Delivery</h1>
        <nav>
            <ol class="breadcrumb">
                {{-- <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li> --}}
                <li class="breadcrumb-item">Monitoring Delivery</li>
            </ol>
        </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <form action="" method="get">
                    <div class="card">
                        <div class="card-header">
                            Search Option
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="">
                                        <label>Manifest Date</label>
                                        
                                        <div class="" style="width: 400px;">
                                            <!-- <i class="fa fa-calendar"></i> -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    from
                                                    <input type="text" name="start" id="date_from" placeholder="YYYY/MM/DD" class="datepicker form-control" value = "{{Request::get('start')}}"/>
                                                </div>
                                                <div class="col-md-6"> to
                                                    <input type="text" name="end" id="date_to" placeholder="YYYY/MM/DD" class="datepicker form-control" value = "{{Request::get('end')}}"/></div>
                                                </div>
                                                
                                                <div class="col-12">
                                                    <label>Manifest Number</label>
                                                    <textarea class="form-control" rows="3" name="manifest" id="po_textarea"  placeholder="SO{{date('y')}}00xxx">{{Request::get('manifest')}}</textarea>
                                                    <a href="javascript:void(0);" onclick="$('#po_textarea').val('');">Clear</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="input-group col-sm-3" style="margin-top: 10px; margin-bottom: 5px">
                                                <button type="submit" name="submit-find" value="1" class="btn btn-primary btn-block" style="min-width: 100%;">
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
                                                            <option value="" >Choose Vendor</option>
                                                            @foreach($list_vendor as $vendor)
                                                            <option value="{{ $vendor->id_vendor }}">{{ $vendor->id_vendor }} - {{ $vendor->nm_vendor }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-2">
                                                        <button id="add_vendor" type="button" class="btn btn-primary btn-sm" onclick="addVendor()" style="margin-left:-22px;min-width: 100%;" ><i class="fas fa-plus"></i></button>
                                                    </div>
                                                </div>
                                                <textarea class="form-control" rows="3" name="vendor_list" id="vendor_list"  placeholder="1000xxx">{{Request::get('vendor_list')}}</textarea>
                                                <a href="javascript:void(0);" onclick="$('#vendor_list').val('');">Clear</a>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive mt-3">
                                @if((!empty(Request::get('start')) && !empty(Request::get('end'))) || !empty(Request::get('vendor_select')) || !empty(Request::get('manifest')) || Request::get('submit-find'))
                                <table  class="table table-bordered table-striped table-sm" id="monitoring-delivery">
                                    <thead>
                                        <th>Manifest</th>
                                        <th>Delivery Date</th>
                                        <th>PO Number</th>
                                        <th>Vendor Name</th>
                                        <th>Total Kanban</th>
                                        <th>Scan Stat</th>
                                        <th>GR Stat</th>
                                        <th>MF Stat</th>
                                        <th><i class="fa fa-list"></i></th>
                                        
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                                @else
                                  <table  class="table table-bordered table-striped table-sm" id="monitoring-delivery-dummy">
                                    <thead>
                                        <th>Manifest</th>
                                        <th>Delivery Date</th>
                                        <th>PO Number</th>
                                        <th>Vendor Name</th>
                                        <th>Total Kanban</th>
                                        <th>Scan Stat</th>
                                        <th>GR Stat</th>
                                        <th>MF Stat</th>
                                        <th><i class="fa fa-list"></i></th>
                                        
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    @endsection
  
    @section('javascript')
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>

    <script>
        $('.select2').select2();
$(document).ready(function(){
            $('#select_vendor').val('{{Request::get('vendor_select')}}').trigger('change');
    })
    
  function addVendor()
     {
      const textarea = document.getElementById('vendor_list');
      if(document.getElementById('select_vendor').value != "")
      {
          textarea.value += document.getElementById('select_vendor').value+'\n'
      }
    
     }
         $('#date_from').datepicker({
            uiLibrary: 'bootstrap5',
             format: 'yyyy-mm-dd'
        });
 $('#date_to').datepicker({
            uiLibrary: 'bootstrap5',
            format: 'yyyy-mm-dd'
        });
      @if((empty(Request::get('start')) && empty(Request::get('end'))) || empty(Request::get('vendor_select')) || empty(Request::get('manifest')) || empty(Request::get('submit-find')))
$('#monitoring-delivery-dummy').DataTable();
@endif
    $('#monitoring-delivery').DataTable({
    "order": [[ 1, "DESC" ]],
    processing: true,
    serverSide: true,
    autoWidth:false,
    "language": {
    "processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
    },
    ajax: "{!! route('api.monitoring.delivery.datatables',['dt_start' => Request::get('start'),'dt_end' => Request::get('end'),'manifest' => Request::get('manifest'),'vendor_list' => Request::get('vendor_list'),'vendor_select' => Request::get('vendor_select')])!!}",
    columns: [
    {
    data: 'manifest',
    name: 'manifest'
    },{
    data: 'delivery_date',
    name: 'delivery_date'
    },
    {
    data: 'po_num',
    name: 'po_num'
    },{
    data: 'nm_vendor',
    name: 'nm_vendor'
    },{
    data: 'kanban_stat',
    name: 'kanban_stat'
    },
    {
    data: 'scan_stat',
    name: 'scan_stat'
    },
    {
    data: 'receive_stat',
    name: 'receive_stat'
    },
    {
    data: 'active_stat',
    name: 'active_stat'
    },
    {
    data: 'button',
    name: 'button'
    },
    ]
    });
    
    </script>
    @endsection