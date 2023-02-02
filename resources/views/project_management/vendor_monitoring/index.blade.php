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
								 <table id="example2" class="table table-bordered table-striped">                      
        
									        <thead>
									            <tr>
									                <th><small>Project Name</small></th>
									                <!--
									                <th><small>Dwld (Vdr)</small></th>
									                -->
									                <th><small>Doc Assignment (Proc)</small></th>
									                <th><small>Upld (Vdr)</small></th>
									                <th><small>Fin. Check (Proc)</small></th>
									                <th><small>Fin. Check (QA)</small></th>
									                <th><small>Stat</small></th>
									            </tr>
									        </thead>
									        <tbody> 
									       
										@foreach($project as $p)
										<?php 
												$proj = PM::get_vendor_has_assigned_detail2($p->id_project, $p->id_vendor, "P");
												$arr_stat=[];
												 $count_rows = 0;
												foreach($proj as $a)
												{
													$id_product_dt    = $a->id_product;
							                        $id_part_dt        = $a->id_part;
							                        $id_doc_part_dt    = $a->id_doc_part;
							                        $doc_required_dt   = $a->doc_required;

							                        $row = PM::get_proj_doc_assign_data_status($p->id_project, $id_product_dt, $id_part_dt, $id_doc_part_dt);

							                         $count_row_data = PM::get_proj_doc_assign_data($p->id_project, $id_product_dt, $id_part_dt, $id_doc_part_dt);
                        							 $sum_check_data = $row;

							                        if (count($count_row_data) == $sum_check_data) {
							                            array_push($arr_stat, "1");
							                        }
							                        $count_rows++;
												}

												  if ($p->id_vendor != "" ){
								                        $vendor_ass = "<span>".$p->vendor->nm_vendor."</span>";
								                    } else {
								                        $vendor_ass = "<span class='badge bg-warning'>Waiting...</span>";
								                    }

												$checked_doc = count($arr_stat);
							                    if ($checked_doc == $count_rows AND ($checked_doc != 0 AND $count_rows != 0) ){
							                        $doc_assignment_stat =  "<span class='badge bg-success'>Completed ($checked_doc/$count_rows)</span>";
							                        $doc_assignment = 1;
							                    } elseif ($checked_doc != $count_rows AND ($checked_doc > 0 AND $count_rows != 0)) {
							                        $doc_assignment_stat =  "<span class='badge bg-warning'>Uncomplete ($checked_doc/$count_rows)</span>";
							                        $doc_assignment = 0;
							                    } else {
							                        $doc_assignment_stat =  "<span class='badge bg-danger'>No Assignment($checked_doc/$count_rows)</span>";
							                        $doc_assignment = 0;
							                    }

							                    //UPLOAD (ENG)
							                    $query_exec4    = PM::get_proj_doc_assign_data2($p->id_project);
							                    // dd($query_exec4);
							                    /* $row4           = mysqli_fetch_assoc($query_exec4);
							                    $count_row4     = mysqli_num_rows($query_exec4); */
												$row4           = $query_exec4;
							                    $count_row4     =count($query_exec4);

							                    $query_exec5    = PM::get_proj_doc_upload_data_status($p->id_project);
							                    /* $row5           = mysqli_fetch_assoc($query_exec5);
							                    $count_row5     = mysqli_num_rows($query_exec5); */
												$row5           = $query_exec5;
							                    $count_row5     = count($query_exec5);
							                    
							                    /*
							                    if ( $count_row4 == $count_row5 AND ($count_row4 != 0 AND $count_row5 != 0) ){
							                        $upload_stat =  "<span class='badge bg-green'>Completed ($count_row4/$count_row5)</span>";
							                    } else {
							                        $upload_stat =  "<span class='badge bg-red'>Uncomplete ($count_row4/$count_row5)</span>";
							                    }
							                    */

							                    if ( $count_row4 == $count_row5 AND ($count_row4 != 0 AND $count_row5 != 0) ){
							                        $upload_stat =  "<span class='badge bg-success'>Completed ($count_row5/$count_row4)</span>";
							                        $checked_upload_eng = 1;
							                    } elseif ($count_row4 != $count_row5 AND ($count_row4 > 0 AND $count_row5 != 0)) {
							                        $upload_stat =  "<span class='badge bg-warning'>Uncomplete ($count_row5/$count_row4)</span>";
							                        $checked_upload_eng = 0;
							                    } else {
							                        $upload_stat =  "<span class='badge bg-danger'>No upload($count_row5/$count_row4)</span>";
							                        $checked_upload_eng = 0;
							                    }


							                    //CHECK STAT BY VENDOR (PROC)
							                    //count uploaded doc by engineering and make stat uploaded doc
							                    $query_exec_new1 = PM::get_proj_doc_assign_data_status_all_vendor($p->id_project,$p->id_vendor);
							                    //$row_new = mysqli_fetch_assoc($query_exec_new1);
							                    $row_new =  $query_exec_new1;

							                    $query_exec_new2 = PM::get_proj_doc_assign_data_status_sum_vendor($p->id_project,$p->id_vendor);
							                    //$row_new2 = mysqli_fetch_assoc($query_exec_new2);
							                    $row_new2 = $query_exec_new2;

							                    //$count_row_new = mysqli_num_rows($query_exec_new1);
							                    $count_row_new = count($query_exec_new1);
							                    $sum_check_new = $row_new2;

							                    if ($count_row_new == $sum_check_new AND ($sum_check_new != "" AND $count_row_new != "") ){
							                        $stat_check_new =  "<span class='badge bg-success'>Completed ($sum_check_new/$count_row_new)</span>";
							                        $checked_doc_eng_vend = 1; //ok
							                    } elseif ($count_row_new != $sum_check_new AND ($count_row_new != 0 AND $sum_check_new != 0)) {
							                        $stat_check_new =  "<span class='badge bg-warning'>Uncomplete ($sum_check_new/$count_row_new)</span>";
							                        $checked_doc_eng_vend = 0; //not ok
							                    } else {
							                        $sum_check_new = 0;
							                        $stat_check_new =  "<span class='badge bg-danger'>Unchecked ($sum_check_new/$count_row_new)</span>";
							                        $checked_doc_eng_vend = 0; //not ok
							                    }

							                     //UPLOAD (VDR)
								                    $query_exec6    = PM::get_proj_doc_assign_data3($p->id_project,$p->id_vendor);
								                    /* $row6           = mysqli_fetch_assoc($query_exec6);
								                    $count_row6     = mysqli_num_rows($query_exec6); */
													$row6           = $query_exec6;
								                    $count_row6     = count($row6);

								                    $query_exec7    = PM::get_proj_doc_upload_data_status2($p->id_project,$p->id_vendor);
								                    /* $row7           = mysqli_fetch_assoc($query_exec7);
								                    $count_row7     = mysqli_num_rows($query_exec7); */
													$row7           = $query_exec7;
								                    $count_row7     = count($query_exec7);

								                    if ( $count_row6 == $count_row7 AND ($count_row6 != 0 AND $count_row7 != 0) ){
								                        $upload_vendor_stat =  "<span class='badge bg-success'>Completed ($count_row7/$count_row6)</span>";
								                        $checked_upload_vdr = 1;
								                    } elseif ($count_row6 != $count_row7 AND ($count_row6 != 0 AND $count_row7 > 0)) {
								                        $upload_vendor_stat =  "<span class='badge bg-warning'>Uncomplete ($count_row7/$count_row6)</span>";
								                        $checked_upload_vdr = 0;
								                    } else {
								                        $upload_vendor_stat =  "<span class='badge bg-danger'>No upload($count_row7/$count_row6)</span>";
								                        $checked_upload_vdr = 0;
								                    }


								                    //FIN CHECK (PROC)
								                    $query_exec8 = PM::get_proj_vendor_assign_data_all($p->id_project,$p->id_vendor);
								                    //$row8 = mysqli_fetch_assoc($query_exec8);
								                    $row8 = $query_exec8;

								                    $query_exec9 = PM::get_proj_vendor_assign_data_status_all($p->id_project,$p->id_vendor);
								                    //$row9 = mysqli_fetch_assoc($query_exec9);
								                   

								                    $query_exec10 = PM::get_proj_vendor_assign_data_status_all2($p->id_project,$p->id_vendor);
								                    $count_row8 = count($query_exec8);
								                
								                    $sum_check_a = $query_exec9;
								                    $sum_check_b = $query_exec10;

								                    $data = $p->id_project.','.$p->id_vendor;

								                    //check by proc
								                    if ($count_row8 == $sum_check_a AND ($sum_check_a != "" AND $count_row8 != "") ){
								                        $stat_check_fin_proc =  "<span class='badge bg-success'>Completed ($sum_check_a/$count_row8)</span></h4>";
								                        $checked_fin_proc = 1;
								                    } elseif ($count_row8 != $sum_check_a AND ($count_row8 != 0 AND $sum_check_a != 0)) {
								                        $stat_check_fin_proc =  "<span class='badge bg-warning'>Uncomplete ($sum_check_a/$count_row8)</span></h4>";
								                        $checked_fin_proc = 0;


								                    }elseif ($count_row8 != $sum_check_a AND ($count_row8 != 0 AND $sum_check_a < $count_row8 )) {
								                        $stat_check_fin_proc =  "<span class='badge bg-warning'>Uncomplete ($sum_check_a/$count_row8)</span></h4>";
								                        $checked_fin_proc = 0;
								                    } else {
								                        $sum_check_a = 0;
								                        $stat_check_fin_proc =  "<span class='badge bg-danger'>Unchecked ($sum_check_a/$count_row8)</span></h4>";
								                        $checked_fin_proc = 0;
								                    }

								                     //check by qa
										           if ($count_row8 == $sum_check_b AND ($sum_check_b != "" AND $count_row8 != "") ){
										               $stat_check_fin_qa   =  "<span class='badge bg-success'>Completed ($sum_check_b/$count_row8)</span>";
										               $checked_fin_qa = 1;
										           } elseif ($count_row8 != $sum_check_b AND ($count_row8 != 0 AND $sum_check_b != 0)) {
										               $stat_check_fin_qa   =  "<span class='badge bg-warning'>Uncomplete ($sum_check_b/$count_row8)</span>";
										               $checked_fin_qa = 0;
										           } elseif ($count_row8 != $sum_check_b AND ($count_row8 != 0 AND $sum_check_b < $count_row8 )) {
										               $stat_check_fin_qa   =  "<span class='badge bg-warning'>Uncomplete ($sum_check_b/$count_row8)</span>";
										               $checked_fin_qa = 0;
										           } else {
										               $sum_check_b = 0;
										               $checked_fin_qa = 0;
										               $stat_check_fin_qa   =  "<span class='badge bg-danger'>Unchecked ($sum_check_b/$count_row8)</span>";
										           }


									           //close project
									                    // $checked_upload_en
									        if ($doc_assignment == 1 AND $checked_doc_eng_vend == 1 AND $checked_upload_vdr == 1 AND $checked_fin_proc == 1 AND $checked_fin_qa == 1){
									            $proj_stat      =  "<a href='DATA/zip_it_all.php?data=$data' target='_blank' data-toggle='tooltip' title='click to download'><span class='badge bg-green'>CLOSED <i class='fa fa-download'></i></span></a>";
									        } elseif ($doc_assignment != 1 OR $checked_doc_eng != 1 OR $checked_upload_vdr != 1 OR $checked_fin_proc != 1 OR $checked_fin_qa != 1) {
									            $proj_stat      =  "<span class='badge bg-warning'>OPEN</span>";
									        } else {
									            $proj_stat      =  "<span class='badge bg-danger'>UNDEFINED</span>";
									        }

										?>
											<tr>
												<td>{{@$p->project->nm_project}}</td>
												 <td><?php echo $doc_assignment_stat; ?></td>
                    							<td><?php echo $upload_vendor_stat; ?></td>
												<td>{!!$stat_check_fin_proc!!}</td>
												<td>{!!$stat_check_fin_qa!!}</td>
												<td>{!!$proj_stat!!}</td>
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