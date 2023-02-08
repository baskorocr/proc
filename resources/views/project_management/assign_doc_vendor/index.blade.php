@extends('layouts.main')
@section('title',"Assign Vendor")
@section('content')
<?php
	$doc_arr        = array();
$data_arr       = array();
$checked_arr    = array();
$completed_arr  = array();
?>
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Assign Vendor</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
				<li class="breadcrumb-item active">Assign Vendor</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="" method="get" enctype="multipart/form-data">
								
								<div class="box-body mt-3">
									
									<label>Choose Project</label>
									<select  style="width: 100%;"  class="form-control  option-select-doc" id="id_project" name="id_project" required>
										
										@foreach($project as $p)
										<option value="{{$p->id_project}}">{{$p->nm_project}}</option>"
										@endforeach
									</select>
									</div><!-- /.box-body -->
									<div class="box-footer"><hr>
										<button type="submit"  class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					@if(!empty($prodforProject))
					<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="" method="get" enctype="multipart/form-data">
								
								<div class="box-body mt-3">
									
									<input type="hidden" name="id_project" value="{{Request::get('id_project')}}">
									<label>Choose Product</label>
									<select  style="width: 100%;"  class="form-control  option-select-doc" id="prod_part" name="prod_part" required>
										
										@foreach($prodforProject as $p)
										

										<option value="{{$p->id_product}}">{{$p->product->nm_product}}</option>
										
										@endforeach
									</select>
									</div><!-- /.box-body -->
									<div class="box-footer">
										<button type="submit"  class="btn btn-outline-secondary"><i class="fas fa-search"></i> Search</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				
					@endif
					@if(!empty($vendor))
					<form action="{{route('project.management.assign.vendor.act')}}" method="POST" enctype="multipart/form-data">
					<div class="col-lg-12">
					<div class="card">
						@csrf
						<div class="card-body">
						
								
								<div class="box-body mt-3">
									
									<input type="hidden" name="id_project" value="{{Request::get('id_project')}}">
									<label>Choose Vendor</label>
									<select  style="width: 100%;"  class="form-control  option-select-doc" id="prod_part" name="prod_part" required>
										
										@foreach($vendor as $v)
										

										<option value="{{$v->id_vendor}}">{{@$v->nm_vendor}} ({{@$v->allias}})</option>
										
										@endforeach
									</select>
									</div><!-- /.box-body -->
									
								
							</div>
						</div>
					</div>

					<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
						
								
								<div class="box-body mt-3">
								<b>[BRAKET]</b>
								  <table class="table table-bordered table-striped">
							           <thead>
								            <th>Part Name</th>
								            <th>Doc Status</th>
								            <th>Choose Part</th>
								            <th>Has Assigned to </th>
							        	</thead>
							        	<tbody>
							        		 <?php

								                $query_exec4 = PM::get_group_all_join_prod_part_data3(Request::get('id_project'), Request::get('prod_part'), 'P');

								                // dd($query_exec4);
								                foreach ($query_exec4 as $row4) {
								                    $nm_part = @$row4['nm_part'];
								                    $nm_prod = @$row4['nm_product'];
								                    $string   = $nm_prod.'_'.$nm_part;
								                    $htm_nm   = preg_replace('/\s+/', '', $string);
								                    $htm_name = str_replace('-', '', $htm_nm);
								                    $htm_name = md5($htm_name);

								                    $id_project_1 = @$row4['id_project'];
								                    $id_product_1 = @$row4['id_product'];
								                    $id_part_1    = @$row4['id_part'];

								                    //count row check per doc
								                    // dd([$id_project_1, $id_product_1, $id_part_1]);
								                    $query_exec_a   = PM::get_proj_doc_assign_part_doc_all_new($id_project_1, $id_product_1, $id_part_1);
								                    // dd($query_exec_a);
								                    $row_a          = $query_exec_a;
								                    $count_row_a    = count($query_exec_a);

								                    $query_exec_b   = PM::get_proj_doc_assign_sum_part_doc_all_new($id_project_1, $id_product_1, $id_part_1);
								                    $row_b          = $query_exec_b;
								                    $count_row_b    = $row_b;
								                    $doc_completion ="";
								                    // dd([$count_row_a, $count_row_b,count($query_exec_a)]);
								                    $disabled ="";
								                    if ($count_row_a == $count_row_b AND count($query_exec_a) > 0){
								                        $disabled = "";
								                        $doc_completion = "<small class ='badge bg-success' data-toggle='tooltip' title='Mandatory document complete'>
								                                                <i class='fa fa-check-square-o'></i> 
								                                            Assignment allowed</small>";
								                    } elseif ($count_row_a != $count_row_b AND count($query_exec_a) > 0) {
								                        $disabled = "disabled";
								                        $doc_completion = "<small class ='badge bg-danger' data-toggle='tooltip' title='Mandatory document not completed'>
								                                                <i class='fa fa-warning'></i> 
								                                                Assignment not allowed</small>";
								                    }

								                    echo"
                    <tr>
                        <td><label>".$nm_part. "</label></td>
                        <td>".$doc_completion."</td>
                        <td><input type='checkbox' id='$htm_name' value='1' name='$htm_name' $disabled></td>
                    ";

                    echo '<input type="hidden" name="id_part[]" value="'.$id_part_1.'"/>';

                    $query_execute =  PM::proj_prod_part_vendor_assigned($id_project_1, $id_product_1, $id_part_1);

                    echo "    
                          <td>";
                                $no = 1;
                               foreach ($query_execute as $row_ex) {
                                    $nm_vendor = @$row_ex->vendor->nm_vendor;
                                    $alias     = @$row_ex->vendor->allias;
                                    echo "<label>".$no.") ".$nm_vendor." (".$alias.")</label><br>";
                                    $no++;
                                }
                    echo "
                           </td>
                    </tr>";

                }//while ($row4 = mysqli_fetch_assoc($query_exec4))

            ?>
							        		
							        	</tbody>
							        </table>
									<div class="row">
										<div class="col-md-3">
											<button class="btn btn-primary btn-block">Assign </button>
										</div>
									</div>
									</div><!-- /.box-body -->
									
							</div>
						</div>
					</div>
				</form>
				
					@endif
				</div>
			</section>
		</main>
		@endsection
		@section('javascript')
		<script>
			$('.option-select-doc').select2({
			});
			@if(!empty(Request::get('id_project')))
			
			$(document).ready(function(){
			window.table = $('#tb-proj').DataTable({
						});
			});
			
			@endif
		</script>
		@endsection