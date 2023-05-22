@extends('layouts.main')
@section('title',"Check Uploaded Document from Vendor")
@section('content')
<?php
	$doc_arr        = array();
$data_arr       = array();
$checked_arr    = array();
$completed_arr  = array();
?>
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Check Uploaded Document from Vendor</h1>
		<nav>
			<ol class="breadcrumb">
				{{-- <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li> --}}
				<li class="breadcrumb-item active">Check Uploaded Document from Vendor</li>
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
										<option></option>
										@foreach($project as $p)
										<option value="{{$p->id_project}}">{{$p->nm_project}}</option>"
										@endforeach
									</select>
									</div><!-- /.box-body -->
									<div class="box-footer">
										<button type="submit"  class="btn btn-primary"><i class="fas fa-eye"></i> View</button>
									</div>
								</form>
							</div>
						</div>
						@if(!empty($prodforProject))
						<div class="card">
							<div class="card-body">
								<form role=form name="myForm" id="myForm"  action="" method="get" enctype="multipart/form-data">
									
									<div class="box-body mt-3">
										
										<input type="hidden" name="id_project" value="{{Request::get('id_project')}}">
										<label>Choose Product - Part</label>
										<select  style="width: 100%;"  class="form-control  option-select-doc" id="project_id" name="project_id" required>
											<option></option>
											@foreach($prodforProject as $p)
											
											<option value="{{$p->id_product}}_{{$p->part->id_part}}">{{$p->product->nm_product}} - {{$p->part->nm_part}}</option>
											
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
						@if(!empty(Request::get('id_project')))
						<div class="card">
							<div class="card-body mt-3">
								<form role=form name="myForm1" id="myForm1" onSubmit="return validateForm()" action="" method="get" enctype="multipart/form-data">
									<div class="box box-body box-primary">
										<div class="box-header">
											<input type="hidden" name ="id_project" value="<?php echo Request::get('id_project'); ?>">
											<label class="pull-left">Choose Vendor</label>
											<select class="form-control selectpicker id_vendor" name="id_vendor" data-live-search="true" required>
												<option></option>
												<?php
												//vendor yang terkait project tersebut
												// $vendor = PM::get_vendor_assign_data($id_project);
												
												foreach($vendor as $v):
												echo "<option value=".@$v->vendor->id_vendor.">".@$v->vendor->nm_vendor." (".@$v->vendor->allias.")</option>";
												endforeach;
												?>
											</select>
											<div class="form-group">
												<a href =""><button type="submit" id="show-data2" name="show-data2" class="btn btn-outline-secondary"><i class="fa fa-search"></i> Search</button></a>
											</div>
										</div>
									</div>
								</form>
							</form>
						</div>
					</div>
					@endif

					@if(!empty(Request::get('id_vendor')))
						{{-- <div class="card">
							<div class="card-body mt-3">
								<form role=form name="myForm1" id="myForm1" onSubmit="return validateForm()" action="" method="get" enctype="multipart/form-data">
									<div class="box box-body box-primary">
										<div class="box-header">
										
            								<input type="hidden" name ="id_vendor" value="<?php echo Request::get('id_vendor'); ?>">
											<input type="hidden" name ="id_project" value="<?php echo Request::get('id_project'); ?>">
											<label class="pull-left">Choose Vendor</label>
											<select class="form-control selectpicker id_vendor_1" name="id_vendor" data-live-search="true" required>
												<?php
												//vendor yang terkait project tersebut
												// $vendor = PM::get_vendor_assign_data($id_project);
												
												foreach($vendor as $v):
													echo "<option value=".@$v->vendor->id_vendor.">".@$v->vendor->nm_vendor." (".@$v->vendor->allias.")</option>";
												endforeach;
												?>
											</select>
											<div class="form-group">
												<a href =""><button type="submit" id="show-data2" name="show-data2" class="btn btn-outline-secondary"><i class="fa fa-search"></i> Search</button></a>
											</div>
										</div>
									</div>
								</form>
						
						</div>
					</div>
 --}}
					<div class="card">
							<div class="card-body mt-3">
								<div class="table-responsive">
							        <table id="example2" class="table table-bordered table-striped">
							            <thead>
							                <th># </th>
							                <th>Id Project</th>
							                <th>Proj.</th>
							                <th>Prod.</th>
							                <th>Part</th>
							                <th>Doc. </th>
							                <th>Ver.</th>
							                <th>Upl. Date</th>
							                <th>Uplder</th>
							                <th>Upload stat (M)</th>
							                <th>Check stat (C/N) </th>
							            </thead>
							            <tbody>
							            	  <?php
							            	  		$id_project = Request::get('id_project');
							            	  		$id_vendor = Request::get('id_vendor');
								                    $no = 1;
								                    $arr        = array();
								                    $arr_mdt    = array();
								                    $arr_req    = array();
								                    $arr_nreq   = array();

								                    $arr2       = array();
								                    $arr2_mdt   = array();
								                    $arr2_req    = array();
								                    $arr2_nreq   = array();

								                    $arr_check = array();


								                    $query_exec2 = PM::get_vendor_doc_has_uploaded_data($id_project, $id_vendor);
								                    foreach ($query_exec2 as $row2) {   

								                        $id_product = $row2->id_product;
								                        $id_part    = $row2->id_part;
								                        $id_doc_part= $row2->id_doc_part;
								                        $doc_required = $row2->doc_required;

								                        if ($row2['upload_path'] != ""){
								                            $status = "<h4><span class='badge badge-success'>Uploaded ($doc_required)</span></h4>";
								                            $act    ="btn-flat ";
								                            $nm_user = $row2->uploader->nm_user;
								                            array_push($arr, "1"); // array doc yang ada path nya

								                            if ($row2['doc_required'] == "M"){
								                                array_push($arr_mdt, "M");
								                            }

								                            if ($row2['doc_required'] == "Y"){
								                                array_push($arr_req, "Y");
								                            }

								                            if ($row2['doc_required'] == "N"){
								                                array_push($arr_nreq, "N");
								                            }

								                        } else {
								                            $status = "<h4><span class='badge badge-warning'> Waiting ($doc_required)...</span></h4>";
								                            $act    = "btn-secondary disabled text-dark";
								                            $nm_user = "";
								                        }

								                        $query_exec3 = PM::get_proj_doc_assign_data_vendor($id_project, $id_product, $id_part, $id_doc_part, $id_vendor);
								                        $row3 = $query_exec3;

								                        $query_exec4 = PM::get_proj_doc_assign_data_status_vendor($id_project, $id_product, $id_part, $id_doc_part, $id_vendor);
								                        $row4 = $query_exec4;

								                        $query_exec_b = PM::get_proj_doc_assign_data_status_vendor2($id_project, $id_product, $id_part, $id_doc_part, $id_vendor);
								                        $row_b = $query_exec_b;

								                        $count_row3  = count($query_exec3);
								                        $sum_check   = $row4;
								                        $sum_check_b = $row_b;

								                        $sum_tobe_checked = $count_row3 + $count_row3;
								                        $sum_checked      = $sum_check + $sum_check_b;

								                        $sum_of_row  = array();

								                        if ($sum_tobe_checked == $sum_checked){
								                            $stat_check =  "<h4><span class='badge badge-primary'>Completed ($sum_checked/$sum_tobe_checked)</span></h4>";
								                        } else {
								                            $stat_check =  "<h4><span class='badge badge-danger'>Uncomplete ($sum_checked/$sum_tobe_checked)</span></h4>";
								                        }

								                        $nama_data = $row2['file_nm'];
								                        $temp = explode(".", $nama_data);
								                        $filename = $temp[0];
								                        $pathname = $id_vendor."/".$filename;

								                        $data = $row2->id_project.",".$row2->id_product.",".$row2->id_part.",".$row2->id_doc_part.",".$id_vendor;

								                        $ver            = $row2->version_n;
								                        $upldate        = $row2->upload_date;

								                        if ($ver == 0 or $ver == ""){
								                            $version = "<center> - </center>";
								                            $upload_date = "<center> - </center>";
								                        } elseif ($ver > 0 or $ver != "") {
								                            $version = "Ver 0".$ver;
								                            $upload_date = $upldate;
								                        }
								                ?>

								                <tr>
								                    <td><?php echo $no; ?></td>
								                    <td><?php echo $row2->id_project;?></td>
								                    <td><?php echo $row2->project->nm_project;?></td>
								                    <td><?php echo $row2->product->nm_product;?></td>
								                    <td><?php echo @$row2->part->nm_part;?></td>
								                    <td><?php echo $row2->docPart->nm_doc_part;?></td>
								                    <td><?php echo $version;?></td>
								                    <td><?php echo $upload_date;?></td>
								                    <td><?php echo $nm_user;?></td>
								                    <td>
								                        <a href="DATA/viewpdf_2.php?id=<?php echo $id_project;?>&p=<?php echo $pathname; ?>&nm=<?php echo $filename; ?>" class="btn <?php echo $act;?>" target="_blank" data-toggle='tooltip' title='click to preview' >
								                           <?php echo $status;?>
								                        </a>
								                    </td>
								                    <td>
								                        <a href="home.php?mnu=checkdocproc&id_data=<?php echo $data;?>" class="btn  <?php echo $act;?>" data-toggle='tooltip' title='check document'>
								                           <?php echo $stat_check;?>
								                        </a>
								                    </td>
								                </tr>

								                <?php
								                        array_push($arr2, $row2['id_project']); // all doc

								                        if ($row2['doc_required'] == "M"){
								                            array_push($arr2_mdt, "M");
								                        }

								                        if ($row2['doc_required'] == "Y"){
								                            array_push($arr2_req, "Y");
								                        }

								                        if ($row2['doc_required'] == "N"){
								                            array_push($arr2_nreq, "N");
								                        }

								                        $no++;  
								                    } //while ($row2 = mysqli_fetch_assoc($query_exec2))


								                ?>

							            </tbody>
							        </table>
							
						</div>
					</div>

					@endif
				</section>
			</main>
			@endsection
			@section('javascript')
			<script>
				$('.option-select-doc').select2({
					placeholder: "Nothing Selected"
				});
				$('.id_vendor').select2({
					placeholder: "Nothing Selected"
				});
				@if(!empty(Request::get('id_project')))
				$("#id_project").val('{{Request::get('id_project')}}');
				$('#id_project').trigger('change');
				$(".id_vendor").val('{{Request::get('id_vendor')}}');
				$('.id_vendor').trigger('change');
				@endif
				@if(!empty($docpart))
				
				$(document).ready(function(){
			window.table = $('#tb-detail').DataTable();
					@endif
			</script>
			@endsection