@extends('layouts.main')
@section('title',"Download Manifest Order ")
@section('content')
<link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	div.table-responsive > div.dataTables_wrapper > div.row
{
    overflow:auto !important;
}

</style>
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Download Manifest Order</h1>
		<nav>
			<ol class="breadcrumb">
				{{-- <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li> --}}
				<li class="breadcrumb-item active">Download Schedule Manifest</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="get">
					<div class="card">
						<div class="card-header">
							Search Option
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-lg-6">
									<div class="">
										<label>Manifest Date</label>
										
										<div class="" style="width: 400px;">
											<!-- <i class="fa fa-calendar"></i> -->
											<div class="row">
												<div class="col-md-6">
													from
													<input type="text" name="start" id="date_from" placeholder="YYYY/MM/DD" class="datepicker form-control" value = "{{Request::get('start')}}"/>
												</div>
												<div class="col-md-6"> to
													<input type="text" name="end" id="date_to" placeholder="YYYY/MM/DD" class="datepicker form-control" value = "{{Request::get('end')}}"/></div>
												</div>
												
												<div class="col-12">
													<label>Manifest Number</label>
													<textarea class="form-control" rows="3" name="manifest" id="po_textarea"   placeholder="MF{{date('y')}}00xxx">{{Request::get('manifest')}}</textarea>
													<a href="javascript:void(0);" onclick="$('#po_textarea').val('');">Clear</a>
												</div>
											</div>
										</div>
										<div class="col-lg-5">
											<div class="input-group col-sm-3" style="margin-top: 10px; margin-bottom: 5px">
												<button type="submit" name="submit-find" value="1" class="btn btn-primary btn-block" style="min-width: 100%;">
												<i class="fa fa-search"></i> Search
												</button>
											</div>
										</div>
									</div>
									<div class="col-lg-5">
										<div>
											<label class="col-sm-5 col-form-label">Vendor</label>
											<div class="col-sm-10">
												<div class="row">
													<div class="col-10">
														<select name="vendor_select" class="form-select select2" id="select_vendor" aria-label="Default select example">
															<option value="" >Choose Vendor</option>
															@foreach($list_vendor as $vendor)
															<option value="{{ $vendor->id_vendor }}">{{ $vendor->id_vendor }} - {{ $vendor->nm_vendor }}</option>
															@endforeach
														</select>
													</div>
													<div class="col-2">
														<button id="add_vendor" type="button" class="btn btn-primary btn-sm" onclick="addVendor()" style="margin-left:-22px;min-width: 100%;" ><i class="fas fa-plus"></i></button>
													</div>
												</div>
												<textarea class="form-control" rows="3" name="vendor_list" id="vendor_list"  placeholder="1000xxx">{{Request::get('vendor_list')}}</textarea>
												<a href="javascript:void(0);" onclick="$('#vendor_list').val('');">Clear</a>
											</div>
										</div>
										<br>
									</div>
								</div>
							</div>
						</div>
					</form>
						<div class="card">
							<div class="card-body">
								
								@if((!empty(Request::get('start')) && !empty(Request::get('end'))) || !empty(Request::get('vendor_select')) || !empty(Request::get('manifest')) || Request::get('submit-find'))
								<div class="table-responsive mt-3">
									<table  class="table table-bordered table-striped table-sm" id="download-manifest">
										<thead>
											<th style="min-width: 16px"><i class="fa fa-list"></i></th>
											<th style="min-width: 106px">Manifest</th>
											<th style="min-width: 106px">Delivery Date</th>
											<th style="min-width: 106px">PO Number</th>
											<th style="min-width: 106px">Vendor</th>
											<th style="min-width: 215px">Vendor Name</th>
											<th style="min-width: 215px">Email</th>
											<th style="min-width: 16px"><i class="fa fa-envelope"></i></th>
											<th style="min-width: 16px"><i class="fa fa-file"></i></th>
											<th style="min-width: 16px"><i class="fa fa-download"></i></th>
											<th style="min-width: 16px"><i class="fa fa-clock"></i></th>
											<th style="min-width: 106px">File Name</th>
											
										</thead>
										<tbody>
											
										</tbody>
									</table>
								</div>
							</div>
							@else
							<div class="table-responsive mt-3">
								<table  class="table table-bordered table-striped table-sm" id="download-manifest-dummy">
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
						@endif
						<div class="card-footer">
						@if((!empty(Request::get('start')) && !empty(Request::get('end'))) || !empty(Request::get('vendor_select')) || !empty(Request::get('manifest')) || Request::get('submit-find'))
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
							@endif
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
	@endsection
	@section('javascript')
	<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
	<script>
$(document).ready(function(){
			$('#select_vendor').val('{{Request::get('vendor_select')}}').trigger('change');
	})
    
  function addVendor()
     {
      const textarea = document.getElementById('vendor_list');
      if(document.getElementById('select_vendor').value != "")
      {
      	  textarea.value += document.getElementById('select_vendor').value+'\n'
      }
    
     }
 $('#date_from').datepicker({
            uiLibrary: 'bootstrap5',
             format: 'yyyy-mm-dd'
        });
 $('#date_to').datepicker({
            uiLibrary: 'bootstrap5',
            format: 'yyyy-mm-dd'
        });
  
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
@if(empty(Request::get('start')) && empty(Request::get('end')))
$('#download-manifest-dummy').DataTable();
@endif

$("#start").change(function(e){
	$('#end').prop('min',$(this).val())
	$('#end').val('')

})
$("#start").click(function(e){
	$(this).removeProp('max')
	
})
$("#end").change(function(e){
	// $('#start').prop('max',$(this).val())
})
		var data = [];
		function selectedDwn(id)
		{
			var val = $(id).val();
			var dtval = $(id).data('filenm');
			if(!$(id).is(':checked'))
			{
				data.remove(val);
				$('#fl'+val).remove();
				$('#mf'+val).remove();
			} else{
				data.push(val);
				$('#download-list').append('<input type="hidden" id="fl'+val+'" name="download_doc[]" value="'+dtval+'" /> <input type="hidden" id="mf'+val+'" name="id_mf[]" value="'+val+'" />');
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
			 ).DataTable({ autoWidth:false,
	"order": [[ 1, "DESC" ]],
	processing: true,
	serverSide: true,
	autoWidth:false,
	"language": {
	"processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
	},
	ajax: "{!! route('api.schedule.delivery.datatables',['dt_start' => Request::get('start'),'dt_end' => Request::get('end'),'manifest' => Request::get('manifest'),'vendor_list' => Request::get('vendor_list'),'vendor_select' => Request::get('vendor_select')])!!}",
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
	data: 'file_stat',
	name: 'file_stat'
	},
	{
	data: 'downloaded',
	name: 'downloaded'
	},
	{
	data: 'active',
	name: 'active'
	},
	{
	data: 'file_nm',
	name: 'file_nm'
	},
	],"oLanguage": {"sSearch": "Search No Manifest:"}
	});
	$('.select2').select2();


	</script>
	@endsection