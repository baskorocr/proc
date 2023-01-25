@extends('layouts.main')
@section('title',"Download Special Order ")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Download Special Order</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
				<li class="breadcrumb-item active"><a href="{{route('delivery.schedule.spc')}}">Download  Spc Order</a></li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<div class="table-responsive mt-3">
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
							</div>
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col-md-6 col-xs-12">
									<div class="row">
										<div class="col-md-6 col-xs-12">
											 <button type="submit" name="checked-po" class="btn btn-block btn-success"><i
				                                        class="fas fa-download"></i> Download Checked
				                            </button>
										</div>
									</div>
								</div>
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
		$('#download-manifest').DataTable({
	"order": [[ 1, "DESC" ]],
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