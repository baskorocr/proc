@extends('layouts.main')
@section('title',"Detail Material ".$manifest)
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
       <h1>Detail Material <br> <small class="text-muted">{{$manifest}}</small></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('monitoring.delivery')}}">Monitoring Delivery</a></li>
                <li class="breadcrumb-item active">Detail Material</li>
            </ol>
        </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive mt-3">
                                <table  class="table table-bordered table-stripped table-sm" id="detail-material">
                                    <thead>
                                        <th>Manifest</th>
                                        <th>Delivery Date</th>
                                        <th>PO Number</th>
                                        <th>Vendor</th>
                                        <th>Itm</th>
                                        <th>Material</th>
                                        <th>Material Descr.</th>
                                        <th>UoM</th>
                                        <th>Qty</th>
                                        <th>Kanban</th>
                                        <th>GR Stat</th>
                                        
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
    <script>
    $('#detail-material').DataTable({
    "order": [[ 1, "asc" ]],
    processing: true,
    serverSide: true,
    autoWidth:false,
    "language": {
    "processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
    },
    ajax: "{{ route('api.monitoring.delivery.detail.datatables',['manifest' => $manifest])}}",
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
    data: 'item',
    name: 'item'
    },
    {
    data: 'material',
    name: 'material'
    },
    {
    data: 'material_desc',
    name: 'material_desc'
    },
    {
    data: 'uom',
    name: 'uom'
    },
    {
    data: 'qty',
    name: 'qty'
    },
    {
    data: 'kanban_stat',
    name: 'kanban_stat'
    },
    {
    data: 'receive_stat',
    name: 'receive_stat'
    },
    ]
    });
    
    </script>
    @endsection