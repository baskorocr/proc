@extends('layouts.main')
@section('title',"View Doc (Vendor)")
@section('content')
<?php
	$doc_arr        = array();
$data_arr       = array();
$checked_arr    = array();
$completed_arr  = array();
?>
<main id="main" class="main">
	<div class="pagetitle">
		<h1>View Doc (Vendor)</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
				<li class="breadcrumb-item active">View Doc (Vendor)</li>
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
										<option value="{{$p->id_project}}">{{$p->project->nm_project}}</option>"
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
				@if(!empty($detail))
				<div class="col-lg-12">
					 <?php
					        
					        $id_vendor  = isset(auth()->user()->vendor->id_vendor) ? auth()->user()->vendor->id_vendor : '';

					    ?>
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="" method="get" enctype="multipart/form-data">

									    <label>Project Document List</label>   
									        {{-- <input type = "hidden" name="id_vendor" value = "<?php echo $id_vendor; ?>" > --}}

									    <div class="table-responsive">
									        <table id="tb-proj-dtl" class="table table-bordered table-striped">
									            <thead>
									                <th>Proj.</th>
									                <th>Product</th>
									                <th>Part</th>
									                <th>Document </th>
									                <th>Ver.</th>
									                <th>Upl. Date</th>
									                <th>Upload stat (M)</th>
									            </thead>
									            <tbody>
									            	<?php

								                    $no = 1;
								                    $id_project = Request::get('id_project');
								                    $arr        = array();
								                    $arr_mdt    = array();
								                    $arr2       = array();
								                    $arr2_mdt   = array();
								                    $files      = array();

								                    $arr_check = array();

								                    $query_exec2 = PM::get_vendor_has_assigned_detail2($id_project, $id_vendor, 'P');
								                    // dd($query_exec2);
								                    foreach($query_exec2 as $row2) {   

								                        $id_product = $row2->id_product;
								                        $id_part    = $row2->id_part;
								                        $id_doc_part= $row2->id_doc_part;
								                        $doc_required = $row2->ProjDocAssign->doc_required;

								                        //check doc part sum check and doc count di id_project, id_product, id_part and id_vendor
								                        //count row check per doc

								                        $query_exec_a   = PM::get_proj_doc_assign_part_doc_all2_new($id_project, $id_product, $id_part, $id_doc_part);
								                        // dd($query_exec_a);
								                        $row_a          = $query_exec_a;
								                        $count_row_a    = count($query_exec_a);

								                        $query_exec_b   = PM::get_proj_doc_assign_sum_part_doc_all2_new($id_project, $id_product, $id_part, $id_doc_part);
								                        // dd($query_exec_b);
								                        $count_row_b    = $query_exec_b;

								                        if ($count_row_a == $count_row_b AND count($query_exec_a) > 0 AND $row2->upload_path != ""){
								                            $status = "<span class='badge bg-success'>Uploaded ($doc_required)</span>";
								                            $act    ="";
								                            $nm_user = $row2->nm_user;
								                            $show_data = "Y";
								                            array_push($arr, "1"); // array doc yang ada path nya
								                            
								                            if ($row2->ProjDocAssign->doc_required == "Y"){
								                                array_push($arr_mdt, "Y");
								                            }

								                        } else {
								                            $status = "<span class='badge bg-warning'> Waiting ($doc_required)...</span>";
								                            $act    = "disabled";
								                            $nm_user = "";
								                            $show_data = "N";
								                        }

								                        $query_exec3 = PM::get_proj_doc_assign_data($id_project, $id_product, $id_part, $id_doc_part);
								                        $row3 = $query_exec3;

								                        $query_exec4 = PM::get_proj_doc_assign_data_status($id_project, $id_product, $id_part, $id_doc_part);
								                        $row4 =$query_exec4;

								                        $count_row3 = count($query_exec3);
								                        $sum_check = $row4;



								                        $nama_data = $row2->ProjDocAssign->file_nm;
								                        $temp = explode(".", $nama_data);
								                        $filename = $temp[0];

								                        $data = $row2->id_project.",".$row2->id_product.",".$row2->id_part.",".$row2->id_doc_part;

								                        $ver            =$row2->ProjDocAssign->version_n;
								                        $upldate        =$row2->ProjDocAssign->upload_date;


								                        if ($ver == 0 or $ver == "" ){
								                            $version = "<center> - </center>";
								                            $upload_date = "<center> - </center>";
								                        } elseif($ver > 0 or $ver != "" ) {
								                            $version = "Ver 0".$ver;
								                            $upload_date = $upldate;
								                        }


								                        if ($count_row3 == $sum_check){
								                            $stat_check =  "<span class='badge bg-primary'>Completed ($sum_check/$count_row3)</span>";
								                        } else {
								                            $stat_check =  "<span class='badge bg-danger'>Uncomplete ($sum_check/$count_row3)</span>";
								                            $version = "<center> - </center>";
								                            $upload_date = "<center> - </center>";
								                        }

								                        ?>

								                <tr>
								                    <td><?php echo @$row2->project->nm_project;?></td>
								                    <td><?php echo @$row2->product->nm_product;?></td>
								                    <td><?php echo @$row2->part->nm_part;?></td>
								                    <td><?php echo @\App\Models\DocPart::where('id_doc_part',$row2->id_doc_part)->first()->nm_doc_part?></td>
								                    <td><?php echo $version;?></td>
								                    <td><?php echo $upload_date;?></td>
								                    <td>
								                        <a href="{{asset('DATA')."/view_data.php?p=$filename"}}" target="_blank" data-toggle='tooltip' title='click to preview' >
								                           <?php echo $status;?>
								                        </a>
								                    </td>

								                    <?php 
								                        if ($temp[1] != ""){
								                    ?>

								                    <input type="hidden" name="files[]" value="<?php echo $id_project."/".$nama_data; ?>" >

								                    <?php
								                        }// if ($temp[1] != ""){
								                    ?>

								                    <input type="hidden" name="nm_file" value="<?php echo $row2->nm_project; ?>" >
								                </tr>

								                <?php
								                        array_push($arr2, $row2->id_project); // all doc

								                        if ($row2->doc_required == "Y"){
								                            array_push($arr2_mdt, "Y");
								                        }

								                        $no++;

								                    } //while ($row2 = mysqli_fetch_assoc($query_exec2))
								                ?>
									            </tbody>
									        </table>
									    </div>
								</form>
							</div>
						</div>
					</div>
					
				</div>
				@endif
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

			$('#tb-proj-dtl').DataTable();
		</script>
		@endsection