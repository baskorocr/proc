@extends('layouts.main')
@section('title',"Master ISO Expired Notify ")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Master ISO Expired Notify</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
				<li class="breadcrumb-item active"><a href="{{route('delivery.schedule.mf')}}">Master ISO Expired Notify</a></li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<div class="table-responsive mt-3">
								<table  class="table table-bordered table-stripped table-sm" id="master-notify">
									<thead>
										<th><i class="fa fa-list"></i></th>
										<th>Notify ID</th>
										<th>Notify Sequence</th>
										<th>Notify Before</th>
										<th>Measurement</th>
										<th>Last Changed by</th>
										<th>Last Changed Date</th>
										<th>Action</th>
										
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
      $('#master-notify').DataTable({
        "order": [[ 1, "DESC" ]],
        processing: true,
        serverSide: true,
        autoWidth:false,
        "language": {
        "processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
        },
        ajax: "{{ route('datatables.doc-iso.master.notify')}}",
        columns: [
          {
						data: 'DT_RowIndex', name: 'DT_RowIndex'
          },
          {
            data: 'notif_id', name: 'notif_id'
          },
          {
            data: 'notif_seq', name: 'notif_seq'
          },
          {
            data: 'notif_before', name: 'notif_before'
          },
          {
            data: 'uom', name: 'uom'
          },
          {
            data: 'cr_by', name: 'cr_by'
          },
          {
            data: 'cr_date', name: 'cr_date'
          },
          {
						data: 'action', name: 'action'
          },
          // {
          //   data: 'ch_by', name: 'ch_by'
          // },
          // {
          //   data: 'ch_date', name: 'ch_date'
          // },
          
        ]
      });

	  function deleteProject(url,id)
		{
			Swal.fire({
				  title: '',
				  html: 'All reference data will be deleted. Are you sure want to delete this data <b>['+id+']</b>?',
				  // showDenyButton: true,
				  showCancelButton: true,
				  confirmButtonText: 'Confirm',
				  denyButtonText: `Cancel`,
				}).then((result) => {
				  /* Read more about isConfirmed, isDenied below */
				  if (result.isConfirmed) {
				    window.location = url;
				  }
				})
		}
    
    </script>
	@endsection