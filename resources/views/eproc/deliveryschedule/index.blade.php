@extends('eproc.layouts.app')
@section('content')
<?php include resource_path('views')."/eproc/menu/top-menu.php";?>
@include('eproc/menu/side-menu');
 <aside class="right-side">

        <!-- Main content -->
        <section class="content">

            <div class="box">
                <div class="box-body">
                	<h3>
						Download Manifest Order
						</h3>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<a href="{{route('delivery.schedule.mf.create')}}" class="btn btn-primary btn-block">Create Manifest Order</a>
									</div>
									<div class="col-md-6">
									</div>
								</div>
							</div>
						</div>
						<hr>
						<table  class="table table-bordered table-stripped" id="download-manifest">
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
								<th><i class="fa fa-download"></i></th><th><i class="fa fa-clock-o"></i></th>
								<th>File Name</th>
							
							</thead>
							<tbody>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
                </div>
            </div>
        </section>
@endsection