@extends('layouts.main')
@section('title',"Download Manifest Order ")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Download Manifest Order</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
				<li class="breadcrumb-item active"><a href="{{route('delivery.schedule.mf')}}">Download Schedule Manifest</a></li>
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
										<th><i class="bi bi-envelope"></i></th>
										<th><i class="bi bi-file-earmark"></i></th>
										<th><i class="bi bi-download"></i></th>
										<th><i class="bi bi-clock"></i></th>
										<th>File Name</th>
										
									</thead>
									<tbody>
										
									</tbody>
								</table>
							</div>
						</div>
						<div class="card-footer">
							<form action="{{route('delivery.schedule.mf.download')}}" method="POST">
								@csrf
							<div class="row">
								<div class="col-md-6 col-xs-12">
									<div class="row">
										<div class="col-md-6 col-xs-12">
											<div id="download-list">
											</div>
											 <button type="submit" name="checked-po" class="btn btn-block btn-success"><i
				                                        class="fas fa-download"></i> Download Checked
				                            </button>
										</div>
									</div>
								</div>
							</div>
						</form>
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
	@endsection
	@section('javascript')
	<script>
Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};
		var data = [];
		function selectedDwn(id)
		{
			var val = $(id).val();
			var dtval = $(id).data('filenm');
			if(!$(id).is(':checked'))
			{
				data.remove(val);
				$('#fl'+val).remove();
			} else{
				data.push(val);
				$('#download-list').append('<input type="hidden" id="fl'+val+'" name="download_doc[]" value="'+dtval+'" />');
			}
			console.log(data);

		}
		$('#download-manifest').on('draw.dt',   function () {
			// console.log($('#63460809220e0000eb00d4b8').is('checked'))
			// if($('#63460809220e0000eb00d4b8').is(':checked'))
			// {
			// 	alert('SS')
			// } 

			var all = $(".checked").map(function() {
			    if(data.includes(this.value))
			    {
			    	$("#"+this.value).prop('checked', true);
			    }
			}).get();

			console.log(all.join());
		}
			 ).DataTable({
	"order": [[ 1, "DESC" ]],
	processing: true,
	serverSide: true,
	autoWidth:false,
	"language": {
	"processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
	},
	ajax: "{{ route('api.schedule.delivery.datatables')}}",
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