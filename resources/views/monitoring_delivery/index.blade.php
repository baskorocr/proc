@extends('layouts.main')
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Monitoring Delivery</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                <li class="breadcrumb-item">Monitoring Delivery</li>
            </ol>
        </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive mt-3">
                                <table  class="table table-bordered table-stripped table-sm" id="monitoring-delivery">
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
    $('#monitoring-delivery').DataTable({
    "order": [[ 1, "asc" ]],
    processing: true,
    serverSide: true,
    autoWidth:false,
    "language": {
    "processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
    },
    ajax: "{{ route('api.monitoring.delivery.datatables')}}",
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