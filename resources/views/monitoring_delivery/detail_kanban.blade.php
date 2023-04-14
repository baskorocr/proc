@extends('layouts.main')
@section('title',"Detail Kanban ".$manifest)
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Detail Kanban <br> <small class="text-muted">{{$manifest}}</small></h1>
        <nav>
            <ol class="breadcrumb">
                {{-- <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li> --}}
                {{-- <li class="breadcrumb-item"><a href="{{route('monitoring.delivery')}}">Monitoring Delivery</a></li> --}}
                <li class="breadcrumb-item active">Detail Kanban</li>
            </ol>
        </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive mt-3">
                                <table  class="table table-bordered table-striped table-sm" id="detail-kanban">
                                    <thead>
                                        <th>Kanban</th>
                                        <th>Arrival Date & Time</th>
                                        <th>Material</th>
                                        <th>Material Descr.</th>
                                        <th>UoM</th>
                                        <th>Qty</th>
                                        <th>Scan Stat</th>
                                        <th>GR Stat</th>
                                        <th>Kanban Stat</th>
                                        
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        @endsection
        @section('javascript')
        <script>
        $('#detail-kanban').DataTable({
        "order": [[ 1, "DESC" ]],
        processing: true,
        serverSide: true,
        autoWidth:false,
        "language": {
        "processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
        },
        ajax: "{{ route('api.monitoring.delivery.detail.kanban.datatables',['manifest' => $manifest])}}",
        columns: [
        {
        data: 'kanban',
        name: 'kanban'
        },{
        data: 'arrival_date_time',
        name: 'arrival_date_time'
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
        data: 'scan_stat',
        name: 'scan_stat'
        },
        {
        data: 'receive_stat',
        name: 'receive_stat'
        },
        {
        data: 'kanban_stat',
        name: 'kanban_stat'
        },
        ]
        });
        
        </script>
        @endsection