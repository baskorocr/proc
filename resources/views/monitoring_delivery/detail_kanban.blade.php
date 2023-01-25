@extends('layouts.app')
@section('content')
@include('eproc/menu/top-menu')
@include('eproc/menu/side-menu')
 <aside class="right-side">

        <!-- Main content -->
        <section class="content">

            <div class="box">
                <div class="box-body">
                	<h3>
						
                    Monitoring Delivery Schedule - Detail Kanban

						</h3>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										
									</div>
									<div class="col-md-6">
									</div>
								</div>
							</div>
						</div>
						<hr>
						<table  class="table table-bordered table-stripped table-sm" id="detail-kanban">
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
        </section>
@endsection
@section('javascript')
	<script>
		 $('#detail-kanban').DataTable({
                                "order": [[ 1, "asc" ]],
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