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
						Download Special Order
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
						<table  class="table table-bordered table-stripped table-sm" id="download-manifest">
							<thead>
								<th><i class="fa fa-list"></i></th>
								<th>Manifest</th>
								<th>Delivery Date</th>
								<th>PO Number</th>
								<th>Vendor</th>
								<th>Vendor Name</th>
								<th>Email</th>
								<th><i class="fa fa-envelope"></i></th>
								<th><i class="fa fa-file"></i></th>
								<th><i class="fa fa-download"></i></th>
								<th><i class="fa fa-clock-o"></i></th>
								<th>File Name</th>
							
							</thead>
							<tbody>
								
							</tbody>
						</table>

						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<a href="" class="btn btn-success btn-block"><i class="fa fa-download"></i> Download Checked</a>
										
									</div>
									<div class="col-md-6">
									</div>
								</div>
							</div>
						</div>

                </div>
            </div>
        </section>
@endsection
@section('javascript')
	<script>
		 $('#download-manifest').DataTable({
                                "order": [[ 1, "asc" ]],
                                processing: true,
                                serverSide: true,
                                autoWidth:false,
                                "language": {
                "processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
              },
                                ajax: "{{ route('api.schedule.delivery.spc.datatables')}}",
                                columns: [
                                	{
                                        data: 'download_check',
                                        name: 'download_check'
                                    },{
                                        data: 'manifest',
                                        name: 'manifest'
                                    },
                                    {
                                        data: 'delivery_date',
                                        name: 'delivery_date'
                                    },{
                                        data: 'po_num',
                                        name: 'po_num'
                                    },{
                                        data: 'id_vendor',
                                        name: 'id_vendor'
                                    },
                                    {
                                        data: 'vendor_name',
                                        name: 'vendor_name'
                                    },
                                    {
                                        data: 'vendor_email',
                                        name: 'vendor_email'
                                    },
                                    {
                                        data: 'mail_stat',
                                        name: 'mail_stat'
                                    },
                                    {
                                        data: 'downloaded',
                                        name: 'downloaded'
                                    },
                                    {
                                        data: 'file_stat',
                                        name: 'file_stat'
                                    },
                                    {
                                        data: 'active',
                                        name: 'active'
                                    },
                                     {
                                        data: 'file_nm',
                                        name: 'file_nm'
                                    },
                                ]
                            });
                   
	</script>
@endsection