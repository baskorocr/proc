@extends('layouts.main')
@section('title',"Monitoring Delivery")
@section('content')
<link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
/*    div.table-responsive > div.dataTables_wrapper > div.row
{
    overflow:auto !important;
}*/
div.dataTables_wrapper div.dt-row{
    min-height:100px;
}
.pagination{ float: right; margin-top: 10px; } 
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
                                        <label>Delivery Date</label>
                                     
                                        <div class="" style="width: 400px;">
                                            <!-- <i class="fa fa-calendar"></i> -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    from
                                                    <input type="text" name="dt_start" id="date_from" placeholder="YYYY/MM/DD" class="datepicker form-control" value = "{{empty(Request::get('dt_start'))?"":Request::get('dt_start')}}"/>
                                                </div>
                                                <div class="col-md-6"> to
                                                    <input type="text" name="dt_end" id="date_to" placeholder="YYYY/MM/DD" class="datepicker form-control" value = "{{empty(Request::get('dt_end'))?"":Request::get('dt_end')}}"/></div>
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
                                        @if(auth()->user()->is_vendor)
                                        <div>
                                            <label class="col-sm-5 col-form-label">Vendor</label>
                                            <div class="col-sm-10">
                                                <div class="row">
                                                    <div class="col-12">
                                                       
                                                        <select name="vendor" disabled class="form-select select2" id="select_vendor_usr" aria-label="Default select example">
                                                            
                                                            <option selected value="{{ auth()->user()->foreign_id }}">
                                                                {{ auth()->user()->foreign_id }} - {{ auth()->user()->vendor->nm_vendor }}
                                                            </option>
                                               
                                                        </select>
                                                      
                                                    </div>
                                                   
                                                </div>
                                                <textarea class="form-control" disabled rows="3" name="vend" id="vend"  placeholder="1000xxx">{{ auth()->user()->foreign_id }}</textarea>
                                                {{-- <a href="javascript:void(0);" onclick="$('#vendor_list').val('');">Clear</a> --}}
                                            </div>
                                        </div>
                                        @else
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
                                        @endif
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
                               {{--  <table  class="table table-bordered table-striped table-sm" id="monitoring-delivery">
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
                                </table> --}}

                                 <table  class="table table-bordered table-striped table-sm" id="monitoring-delivery-new" >
                                    <thead>
                                        <th>Manifest </th>
                                        <th>Delivery Date </th>
                                        <th>PO Number </th>
                                        <th>Vendor Name </th>
                                        <th>Total Kanban </th>
                                        <th>Scan Stat </th>
                                        <th>GR Stat </th>
                                        <th>MF Stat </th>
                                        <th><i class="fa fa-list"></i></th>
                                        
                                    </thead>
                                    <tbody>
                                     @foreach($datas as $data)   
                                     <?php 
                                      $md = $data->manifestDetails()->first();
                                        if($data->stat == "P")
                                        {
                                            if ($data->manifestDetails->sum('qty_pack') == $data->manifestDetails->sum('qty_in')) {
                                            $scan_stat = "<small><span class=\"badge bg-success\">Done</span></small>";
                                            } else {
                                            $scan_stat = "<small><span class=\"badge bg-primary\">On Progress</span></small>";
                                            }
                                        } elseif($data->stat == "H")
                                        {

                                             $scan_stat = "<small><span class=\"badge bg-danger\">Outstanding</span></small>";

                                        }elseif ($data->stat  == "D"){
                                            $scan_stat = "<small><span class=\"badge bg-success\">Done</span></small>";
                                        } else {
                                            $scan_stat = "<small><span class=\"badge bg-warning text-dark\">Waiting</span></small>";
                                        }


                                        $kanban_in = ManifestDetail::where('manifest', $data->manifest)->whereNotNull('issued_date')->groupBy('manifest')->count('issued_date');
                                        $tot_kanban = $data->manifestDetails->count('kanban');
                                        if ($tot_kanban == $kanban_in) {
                                            $receive_stat = "<small><span class=\"badge bg-success\">" . $kanban_in . "/" . $tot_kanban . "</span></small>";
                                        } else {
                                            $receive_stat = "<small><span class=\"badge bg-warning text-dark\">" . $kanban_in . "/" . $tot_kanban . "</span></small>";
                                        }


                                        $kanban_received = ManifestDetail::where('manifest', $data->manifest)->whereNotNull('scan_date')->groupBy('manifest')->count('scan_date');
                                        $tot_kanban = $data->manifestDetails->count('kanban');

                                        if ( $tot_kanban == $kanban_received) {
                                            $kanban_in = "<small><span class=\"badge bg-success\">" . $kanban_received . "/" . $tot_kanban . "</span></small>";
                                        } else {
                                            $kanban_in = "<small><span class=\"badge bg-warning text-dark\">" . $kanban_received . "/" . $tot_kanban . "</span></small>";
                                        }


                                        if ($data->active == 'O') {
                                            $active_stat = "<small><span class=\"badge bg-warning text-dark\">Open</span></small>";
                                        } else {
                                            $active_stat = "<small><span class=\"badge bg-success\">Closed</span></small>";
                                        }


                                    ?>
                                    <tr>
                                    <td>{{$data->manifest}}</td>
                                    <td>{{$data->delivery_date}}</td>
                                    <td>{{$data->po_num}}</td>
                                    <td>{{@$data->vendors->nm_vendor}}</td>
                                    <td>{!!$kanban_in!!}</td>
                                    <td>{!!$scan_stat!!}</td>
                                    <td>{!!$receive_stat!!}</td>
                                    <td>{!!$active_stat!!}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="{{@route('monitoring.delivery.detail.material',['manifest' => @$data->manifest])}}" title="Detail Material {{@$data->manifest}}" class="btn btn-success" target="_blank"><i class="fas fa-sitemap"></i></a>
                                                
                                             <a href="{{@route('monitoring.delivery.detail.kanban',['manifest' =>@$data->manifest])}}" title="Detail Kanban {{@$data->manifest}}" class="btn btn-primary" target="_blank"><i class="fas fa-file"></i></a>
                                        </div>
                                    </td>
                                    </tr>
                                     @endforeach
                                    </tbody>
                                </table>
                                <div class="row justify-content-end"> 
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6 float-end">{{$datas->appends(Request::input())->links()}}</div>

                                </div>

                                @else
                                  <table  class="table table-bordered table-striped table-sm" id="monitoring-delivery-dummy">
                                    <thead>
                                        <th>Manifest </th>
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
$('#monitoring-delivery-new').DataTable({"bPaginate": false,  "bInfo" : false,   "searching": false, "order": [[ 1, "DESC" ]],});


   {{-- $('#monitoring-delivery').DataTable({
    "order": [[ 1, "DESC" ]],
    processing: true,
    serverSide: true,
    autoWidth:false,
    "language": {
    "processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
    },
    ajax: "{!! route('api.monitoring.delivery.datatables',['dt_start' => Request::get('start'),'dt_end' => Request::get('end'),'manifest' => Request::get('manifest'),'vendor_list' => Request::get('vendor_list'),'vendor_select' => Request::get('vendor_select')])!!}",
    "deferRender": true,
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
    });--}}
    
    </script>
    @endsection