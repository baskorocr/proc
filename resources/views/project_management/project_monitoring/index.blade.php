@extends('layouts.main')
@section('title',"Dashboard Monitoring Projects")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Dashboard Monitoring Projects</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
				<li class="breadcrumb-item active">Dashboard Monitoring Projects</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					
					<div class="card ">
						<div class="card-body">
							<div class="table-responsive mt-3">
								<table id="tb-proj" class="table table-bordered table-striped">
									
									<thead>
										<tr>
											<th><small>Project Number</small></th>
											<th><small>Project Name</small></th>
											<th><small>Upload (Eng)</small></th>
											<th><small>Check (Proc)</small></th>
											<th><small>Vendor Ass.</small></th>
											<!--
											<th><small>Dwld (Vdr)</small></th>
											-->
											<th><small>Upload (Vdr)</small></th>
											<th><small>Fin. Check (Proc)</small></th>
											<th><small>Fin. Check (QA)</small></th>
											<!--
											<th><small>Proj. Type</small></th>
											-->
											<th><small>Stat</small></th>
										</tr>
									</thead>
									<tbody>
										@foreach($project as $p)
											<tr>
												<td>{{@$p->project->proj_num}}</td>
												<td>{{@$p->project->nm_project}}</td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
										@endforeach
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
		$('.option-select-doc').select2({
		});
	
		$(document).ready(function(){
		window.table = $('#tb-proj').DataTable({
					});
		});
		
	
	</script>
	@endsection