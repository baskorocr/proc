@extends('eproc.layouts.app')
@section('content')
<?php include resource_path('views')."/eproc/menu/top-menu.php";?>
@include('eproc/menu/side-menu')
 <aside class="right-side">

        <!-- Main content -->
        <section class="content">

            <div class="box">
                <div class="box-body">
                	<h3>
						Monitoring Delivery
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
        </section>
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