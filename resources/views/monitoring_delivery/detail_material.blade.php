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
						
                    Monitoring Delivery Schedule - Detail Material

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
        </section>
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