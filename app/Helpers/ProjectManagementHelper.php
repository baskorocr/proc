<?php
namespace App\Helpers;

use App\Models\Project;
use App\Models\ProjectDocUpload;
use App\Models\ProjectDocAssign;
use App\Models\ProjectVendorAssign;
use App\Models\ProjectVendorUpload;
use App\Models\ProductForProject;
use App\Models\DocForPart;
use App\Models\PartForProduct;
use App\Models\DocPart;
use App\Models\DocChecklist;
use DB;

class ProjectManagementHelper {
	function getDocUploadData($id_project,$id_product,$id_part,$id_doc_part){
		$data = ProjectDocUpload::where(['id_project' => $id_project,'id_product' => $id_product, 'id_part' => $id_part,'id_doc_part' => $id_doc_part])->first();
		return $data;
	}
 
	function get_proj_doc_assign_data($id_project,$id_product,$id_part,$id_doc_part){
		$data = ProjectVendorAssign::where(['id_project' => $id_project,'id_product' => $id_product, 'id_part' => $id_part,'id_doc_part' => $id_doc_part])->get();
		// $data = ProjectVendorAssign::where(['id_project' => "440000000003",'id_product' => "410000000005", 'id_part' => "420000000001",'id_doc_part' => "430000000001"])->get();

		return $data;
	}
	function getProjectAssign($id_project){
		$data = ProjectVendorAssign::where('id_project',$id_project)->first();
		// $data = ProjectVendorAssign::where(['id_project' => "440000000003",'id_product' => "410000000005", 'id_part' => "420000000001",'id_doc_part' => "430000000001"])->get();

		return $data;
	}
	function get_proj_vendor_assign_data_status_all($id_project, $id_vendor){

		
		$result = ProjectVendorAssign::where('id_project',$id_project)->where('id_vendor',$id_vendor)->sum('check_status_a');

		return $result;
	}
	function get_proj_vendor_assign_data_status_all2($id_project, $id_vendor){

		
		$result = ProjectVendorAssign::where('id_project',$id_project)->where('id_vendor',$id_vendor)->sum('check_status_b');

		return $result;
	}

	function get_vendor_doc_has_uploaded_data($id_project, $id_vendor){

		// $conn = get_connection(); 
		// $query = "SELECT a.id_project, b.nm_project, a.id_product, c.nm_product, a.id_part, d.nm_part, a.id_doc_part, e.nm_doc_part, e.doc_required, a.file_nm, a.upload_path, a.upload_n, a.version_n, a.file_nm, date_format(a.upload_date, '%d.%m.%Y') as upload_date, a.uploader_id, f.nm_user, e.doc_required from proj_vendor_upload a
		// 		join project b on b.id_project = a.id_project
		// 		join product c on c.id_product = a.id_product
		// 		join part d on d.id_part = a.id_part
		// 		join doc_part e on e.id_doc_part = a.id_doc_part
		// 		left join user f on f.id_user = a.uploader_id
		// 		where a.id_project ='$id_project' AND a.id_vendor = '$id_vendor'
		// 		order by a.id_product";
		// /* $result = mysql_query($query) or die(mysqli_error($conn));
		// mysql_close($conn); */
		// $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		// mysqli_close($conn);
		$result = ProjectVendorUpload::where('id_project',$id_project)->where('id_vendor', $id_vendor)->get();
	return $result;
	}

	function get_vendor_assign_data($id_project){

		// $conn = get_connection(); 
		// $query = "SELECT distinct(a.id_project), a.id_vendor, b.nm_vendor, b.allias FROM `proj_vendor_upload` a
		// 		left join vendor b on a.id_vendor = b.id_vendor
		// 		WHERE a.id_project = '$id_project'";
		// /* $result = mysql_query($query) or die(mysqli_error($conn));
		// mysql_close($conn); */
		// $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		// mysqli_close($conn);
		$result = ProjectVendorAssign::where(['id_project' => $id_project])->groupBy('id_project')->get();

		return $result;
	}
	function get_proj_vendor_assign_data_all($id_project, $id_vendor){

		// $conn = get_connection(); 
		// $query = "SELECT a.*, b.doc_type, b.doc_required FROM proj_vendor_assign a left join doc_part b on a.id_doc_part = b.id_doc_part WHERE id_project= '$id_project' AND doc_type ='V' AND (doc_required ='Y' OR doc_required = 'M') AND id_vendor = '$id_vendor' group by id_project, id_product, id_part, id_doc_part";
		// /* $result = mysql_query($query) or die(mysqli_error($conn));
		// mysql_close($conn); */
		// $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		// mysqli_close($conn);

		$arrd = [];
		$a = ProjectVendorAssign::where('id_project',$id_project)->where('id_vendor',$id_vendor)->groupBy('id_project','id_product','id_part','id_doc_part')->get();
		foreach($a as $a)
		{
			$b = DocPart::where('id_doc_part',$a->id_doc_part)->where('doc_type','V')->whereIn('doc_required',['Y','M'])->get();

			foreach($b as $b)
			{
				$arrd[]=[
							'id_assign' => $a->id_assign,
							'id_project' => $a->id_project,
							'id_product' => $a->id_product,
							'id_part' => $a->id_part,
							'id_doc_part' => $a->id_doc_part,
							'check_params' => $a->check_params,
							'comment' => $a->e,
							'check_status' => $a->check_status,
							'checker_id' => $a->checker_id,
							'check_date' => $a->check_date,
							'doc_type' => $b->doc_type,
							'doc_required' => $b->doc_required,
					];
			}
		}

			return  $arrd;

	}

	function get_proj_doc_upload_data_status2($id_project, $id_vendor){

		$arrd=[];
		$a = ProjectDocUpload::where('upload_path','<>','')->where('id_project',$id_project)->get();
		foreach($a as $a)
		{
				$b = DocPart::where('id_doc_part',$a->id_doc_part)->where('doc_type','V')->whereIn('doc_required',['Y','M'])->get();

			foreach($b as $b)
			{
				$arrd[]=[
							'id_assign' => $a->id_assign,
							'id_project' => $a->id_project,
							'id_product' => $a->id_product,
							'id_part' => $a->id_part,
							'file_nm' => $a->file_nm,
							'upload_n' => $a->upload_n,
							'version_n' => $a->version_n,
							'doc_required' => $a->doc_required,
							'upload_id' => $a->upload_id,
							'upload_path' => $a->upload_path,
							'download_stat' => $a->download_stat,
							'download_date' => $a->download_date,
							'downloader_id' => $a->downloader_id,
							'permit_n' => $a->permit_n,
							'uploader_id' => $a->uploader_id,
							'doc_type' => $b->doc_type,
							'doc_required' => $b->doc_required,
							];
			}
		}
			return  $arrd;
	

	}
	function get_proj_doc_assign_data_status_sum_vendor($id_project, $id_vendor){

      

        $a = ProjectVendorAssign::where('id_project', $id_project)->where('id_vendor', $id_vendor)->get();
        $sum = 0;
        foreach($a as $a)
        {
        		$b = DocPart::where('id_doc_part',$a->id_doc_part)->whereIn('doc_required',['Y','M'])->get();

			foreach($b as $b)
			{
				$c = ProjectDocAssign::where('id_project',$id_project)->where('id_product', $a->id_product)->where('id_part',$a->id_part)->where('check_params',$a->check_params)->where('id_doc_part', $a->id_doc_part)->get();

				foreach($c as $c)
				{
					$sum += $c->check_status;
				}
			}
        }

    return $sum;
    }
	function get_proj_doc_assign_data_status_all_vendor($id_project, $id_vendor){

        // $conn = get_connection();
        // $query = "SELECT a.id_assign, a.id_project, a.id_product, a.id_part, a.id_doc_part, a.check_params, 
        //           c.check_status, b.doc_type, a.id_vendor FROM proj_vendor_assign a 
        //           join doc_part b on a.id_doc_part = b.id_doc_part
        //           right join proj_doc_assign c on a.id_project = c.id_project and a.id_product =  c.id_product 
        //           and a.id_part = c.id_part and a.id_doc_part = c.id_doc_part  and a.check_params = c.check_params
        //           WHERE a.id_project= '$id_project' and a.id_vendor = '$id_vendor' and doc_type = 'P'";
      

        $result = ProjectVendorAssign::where('id_project',$id_project)->where('id_vendor',$id_vendor)->get();

    return $result;
    }

    function proj_prod_part_vendor_assigned($id_project, $id_product, $id_part){

		// $conn = get_connection(); 
		// $query = "SELECT a.*, b.* FROM `proj_vendor_assign` a
		// 		left join vendor b on a.id_vendor = b.id_vendor 
		// 		where id_project ='$id_project' and id_product = '$id_product' and id_part = '$id_part'
		// 		group by id_project, id_product, id_part, a.id_vendor ";
		// /* $result = mysql_query($query) or die(mysqli_error($conn));
		// mysql_close($conn); */
		// $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		// mysqli_close($conn);

		$proj = ProjectVendorAssign::where('id_project', $id_project)->where('id_part', $id_part)->where('id_product',$id_product)->groupBy('id_project', 'id_product', 'id_part','id_vendor')->get();
		// dd($proj);
			return $proj;
	}


     function get_proj_doc_assign_sum_part_doc_all_new($id_project, $id_product, $id_part){
        // $conn = get_connection();
        // $query = "SELECT a.*, b.doc_required, b.doc_type FROM proj_doc_assign a left join doc_part b on a.id_doc_part = b.id_doc_part where a.id_project='$id_project' AND a.id_product = '$id_product' AND a.id_part = '$id_part' AND b.doc_type = 'P' AND b.doc_required = 'M'";
        // /* $result = mysql_query($query) or die(mysqli_error($conn));
		// mysql_close($conn); */
		// $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		// mysqli_close($conn);
     	$result = ProjectDocAssign::where('id_project', $id_project)->where('id_part', $id_part)->where('id_product',$id_product)->get();

     	$sumar=0;
     	foreach($result as $r)
     	{
     		if( $r->docPart->doc_type == "P" AND  $r->docPart->doc_required == "M")
     		{
     			$sumar += empty($r->check_status)?0:inval($r->check_status);
     		}
     	}
    	return $sumar;

    }

//      	$result =  DB::table('proj_doc_assign')
// ->select(['doc_part.doc_required', 'doc_part.doc_type'])
// ->leftJoin('doc_part','proj_doc_assign.id_doc_part','=','doc_part.id_doc_part')
// // ->where('proj_doc_assign.id_project','=','$id_project')
// // ->where('proj_doc_assign.id_product','=','$id_product')
// // ->where('proj_doc_assign.id_part','=','$id_part')
// // ->where('doc_part.doc_type','=','P')
// // ->where('doc_part.doc_required','=','M')
// ->first();

// dd($result);


     function get_proj_vendor_assign_data_vendor2($id_project, $id_product, $id_part, $id_doc_part, $check_params, $id_vendor){

    
		$result = ProjectVendorAssign::where('id_project', $id_project)->where('id_product', $id_product)->where('id_part',$id_part)->where('id_vendor', $id_vendor)->where('id_doc_part',$id_doc_part)->where('check_params', $check_params)->get();

    	return $result;
    } 

    function get_proj_vendor_assign_data_vendor($id_project, $id_product, $id_part,  $id_vendor){

    
		$result = ProjectVendorAssign::where('id_project', $id_project)->where('id_product', $id_product)->where('id_part',$id_part)->where('id_vendor', $id_vendor)->get();

    	return $result;
    }

    function get_proj_doc_assign_part_doc_all_new($id_project, $id_product, $id_part){
    	// dd([$id_project, $id_product, $id_part]);
		$result = ProjectDocAssign::where('id_project', $id_project)->where('id_product',$id_product)->get();

     	$arrd=[];
     	foreach($result as $r)
     	{
     		if( $r->docPart->doc_type == "P" AND  $r->docPart->doc_required == "M")
     		{
     			$arrd[] = ['id_assign' => $r->id_assign,'id_product' => $r->id_product,'id_part' => $r->id_part,'id_doc_part' => $r->id_doc_part,'check_params' => $r->check_params,'comment' => $r->comment,'check_status' => $r->check_status,'checker_id' => $r->checker_id,'check_date' => $r->check_date,'doc_type' => $r->docPart->doc_type, 'doc_required' =>$r->docPart->doc_required];
     		}
     	}
    	return $arrd;
    }

    function get_group_all_join_prod_part_data3($id_project, $id_product, $doc_type){

	// 	$conn = get_connection();
	// 	$query = "SELECT a.id_project, b.nm_project, a.id_product, c.nm_product, d.id_part, e.nm_part, f.id_doc_part, g.nm_doc_part, h.check_params,  g.doc_type from product_for_project a
	// 		join project b on a.id_project = b.id_project
	// 		join product c on c.id_product = a.id_product

	// 		join part_for_product d on d.id_product = a.id_product
	// 		join part e on e.id_part = d.id_part

	// 		left join doc_for_part f on f.id_part = d.id_part
	// 		left join doc_part g on g.id_doc_part = f.id_doc_part

	// 		left join doc_check_list h on f.id_doc_part = h.id_doc_part
	// 		WHERE a.id_project = '$id_project' AND c.id_product = '$id_product' AND doc_type = '$doc_type'
    //         GROUP BY id_product, id_part
	// 		ORDER BY a.id_product ASC";

	// 	/* $result = mysql_query($query) or die(mysqli_error($conn));
	// 	mysql_close($conn); */
	// 	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	// 	mysqli_close($conn);
	// return $result;

    	$prodProject = ProductForProject::select('id_product','id_project','id_user')->where('id_project',$id_project)->groupBy('id_product')->get(); //11
    	// dd($prodProject);
    	$groupingProd = "";
    	$groupingPart = "";
		$arrd=[];
		foreach($prodProject as $p)
		{
			$partProduct = PartForProduct::where('id_product',$id_product)->groupBy('id_product','id_part')->get();//1
			foreach($partProduct as $p2)
			{
				$docofpart = DocForPart::where('id_part', $p2->id_part)->get(); //3
				foreach($docofpart as $d)
				{
					$getDoc = DocPart::where('id_doc_part', $d->id_doc_part)->whereIn('doc_type', [$doc_type])->first();
					// dd($getDoc);
					$docChecklist = DocChecklist::where('id_doc_part', $d->id_doc_part)->get();//13
					foreach($docChecklist as $d2)
					{
						if(in_array(@$getDoc->doc_type, [$doc_type]))
						{
							// dd($p);
							if($groupingPart != $p2->id_part AND $groupingProd != $p->id_product)
							{

								$arrd[] = ['id_project' => $p->id_project,'id_product' => $p->id_product,'nm_product' => $p->product->nm_product,'nm_part' => $p2->part->nm_part,'id_part' => $p2->id_part,'id_doc_part' => $d->id_doc_part, 'nm_doc_part' => $getDoc->nm_doc_part, 'check_params' => $d2->check_params,'doc_type' => $getDoc->doc_type,'doc_required' => $getDoc->doc_required];
								$groupingProd = $p->id_product;
								$groupingPart = $p2->id_part;
							}	
						}
						

					}
				}
			}
		}

		return $arrd;
	} 
	function get_group_all_join_prod_part_data4($id_project, $doc_type){

	// 	$conn = get_connection();
	// 	$query = "SELECT a.id_project, b.nm_project, a.id_product, c.nm_product, d.id_part, e.nm_part, f.id_doc_part, g.nm_doc_part, h.check_params,  g.doc_type from product_for_project a
	// 		join project b on a.id_project = b.id_project
	// 		join product c on c.id_product = a.id_product

	// 		join part_for_product d on d.id_product = a.id_product
	// 		join part e on e.id_part = d.id_part

	// 		left join doc_for_part f on f.id_part = d.id_part
	// 		left join doc_part g on g.id_doc_part = f.id_doc_part

	// 		left join doc_check_list h on f.id_doc_part = h.id_doc_part
	// 		WHERE a.id_project = '$id_project' AND c.id_product = '$id_product' AND doc_type = '$doc_type'
    //         GROUP BY id_product, id_part
	// 		ORDER BY a.id_product ASC";

	// 	/* $result = mysql_query($query) or die(mysqli_error($conn));
	// 	mysql_close($conn); */
	// 	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	// 	mysqli_close($conn);
	// return $result;

    	$prodProject = ProductForProject::select('id_product','id_project','id_user')->where('id_project',$id_project)->groupBy('id_product')->get(); //11
    	// dd($prodProject);
    	$groupingProd = "";
    	$groupingPart = "";
    	$groupingCP = "";
    	$groupingDoc = "";
		$arrd=[];
		foreach($prodProject as $p)
		{
			$partProduct = PartForProduct::groupBy('id_product','id_part')->get();//1
			foreach($partProduct as $p2)
			{
				$docofpart = DocForPart::where('id_part', $p2->id_part)->get(); //3
				foreach($docofpart as $d)
				{
					$getDoc = DocPart::where('id_doc_part', $d->id_doc_part)->first();
					$docChecklist = DocChecklist::where('id_doc_part', $d->id_doc_part)->get();//13
					foreach($docChecklist as $d2)
					{
						
							// dd($p);
							if($groupingPart != $p2->id_part AND $groupingProd != $p->id_product AND $d->id_doc_part !=$groupingDoc AND $d2->check_params != $groupingCP)
							{

								$arrd[] = ['id_project' => $p->id_project,'id_product' => $p->id_product,'nm_product' => $p->product->nm_product,'nm_part' => $p2->part->nm_part,'id_part' => $p2->id_part,'id_doc_part' => $d->id_doc_part, 'nm_doc_part' => $getDoc->nm_doc_part, 'check_params' => $d2->check_params,'doc_type' => $getDoc->doc_type,'doc_required' => $getDoc->doc_required];
								$groupingProd = $p->id_product;
								$groupingPart = $p2->id_part;
								$groupingCP = $d2->check_params;
								$groupingDoc = $d->id_doc_part;
							
							}
						

					}
				}
			}
		}

		return $arrd;
	}

	function insert_proj_vendor_assign($id_project, $id_product, $id_part, $id_doc_part, $check_params, $id_vendor){

		$result = ProjectVendorAssign::create(['id_assign' => Numbering::generateAuto(new \App\Models\ProjectVendorAssign(),"id_assign", 18, 18, 1, ""),'id_project' => $id_project, 'id_product' => $id_product, 'id_part' => $id_part, 'id_doc_part' => $id_doc_part, 'check_params' => $check_params, 'id_vendor' => $id_vendor]);
	return $result;
	}

    function get_group_all_join_proj_prod_part_data_required($id_project, $id_product, $id_part, $doc_type, $required, $mandatory){
    	$prodProject = ProductForProject::select('id_product','id_project','id_user')->where('id_project',$id_project)->groupBy('id_product','id_part')->get(); //11
		$arrd=[];
		foreach($prodProject as $p)
		{
			$partProduct = PartForProduct::where('id_product',$p->id_product)->get();//1
			foreach($partProduct as $p2)
			{
				$docofpart = DocForPart::where('id_part', $p2->id_part)->groupBy('id_doc_part')->get(); //3
				foreach($docofpart as $d)
				{
					$getDoc = DocPart::where('id_doc_part', $d->id_doc_part)->whereIn('doc_type', ['P', 'Y', 'M'])->first();
					$docChecklist = DocChecklist::where('id_doc_part', $d->id_doc_part)->get();//13
					foreach($docChecklist as $d2)
					{
						if(in_array($getDoc->doc_type, ['P', 'Y', 'M']))
						{
							$arrd[] = ['id_project' => $p->id_project,'id_product' => $p->id_product,'id_part' => $p2->id_part,'id_doc_part' => $d->id_doc_part, 'nm_doc_part' => $getDoc->nm_doc_part, 'check_params' => $d2->check_params,'doc_type' => $getDoc->doc_type];	
						}
						

					}
				}
			}
		}

		return $arrd;
		
	} 
	function get_proj_doc_assign_data_vendor($id_project, $id_product, $id_part, $id_doc_part, $id_vendor){

		$result = ProjectVendorAssign::where('id_project',$id_project)->where('id_product',$id_product)->where('id_part',$id_part)->where('id_doc_part',$id_doc_part)->where('id_vendor',$id_vendor)->get();
	return $result;
	}

	function get_proj_doc_assign_data_status_vendor($id_project, $id_product, $id_part, $id_doc_part, $id_vendor){

		// $conn = get_connection(); 
		// $query = "SELECT sum(check_status_a) as check_status FROM proj_vendor_assign
		// 	WHERE id_project= '$id_project' AND id_product ='$id_product' AND id_part='$id_part' AND id_doc_part='$id_doc_part' AND id_vendor = '$id_vendor' ";
		// /* $result = mysql_query($query) or die(mysqli_error($conn));
		// mysql_close($conn); */
		// $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		// mysqli_close($conn);
		$data = ProjectVendorAssign::where(['id_project' => $id_project,'id_product' => $id_product,'id_vendor' => $id_vendor, 'id_part' => $id_part,'id_doc_part' => $id_doc_part])->sum('check_status_a');
		// $data = ProjectVendorAssign::where(['id_project' => "440000000003",'id_product' => "410000000005", 'id_part' => "420000000001",'id_doc_part' => "430000000001"])->sum('check_status');

		return $data;
	}
	function get_proj_doc_assign_data_status_vendor2($id_project, $id_product, $id_part, $id_doc_part, $id_vendor){

		// $conn = get_connection(); 
		// $query = "SELECT sum(check_status_a) as check_status FROM proj_vendor_assign
		// 	WHERE id_project= '$id_project' AND id_product ='$id_product' AND id_part='$id_part' AND id_doc_part='$id_doc_part' AND id_vendor = '$id_vendor' ";
		// /* $result = mysql_query($query) or die(mysqli_error($conn));
		// mysql_close($conn); */
		// $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		// mysqli_close($conn);
		$data = ProjectVendorAssign::where(['id_project' => $id_project,'id_product' => $id_product,'id_vendor' => $id_vendor, 'id_part' => $id_part,'id_doc_part' => $id_doc_part])->sum('check_status_b');
		// $data = ProjectVendorAssign::where(['id_project' => "440000000003",'id_product' => "410000000005", 'id_part' => "420000000001",'id_doc_part' => "430000000001"])->sum('check_status');

		return $data;
	}

	function get_vendor_prod_part_doc_data($id_project, $id_product, $id_part, $doc_type, $id_vendor){

		// $conn = get_connection();
		// $query = "SELECT a.id_project, b.nm_project, a.id_product, c.nm_product, a.id_part, d.nm_part, a.id_doc_part, e.nm_doc_part, f.id_vendor, e.doc_type, a.check_status_a, a.check_status_b, f.upload_path, f.file_nm, f.version_n, f.upload_n FROM `proj_vendor_assign` a 
		// 	join project b on a.id_project = b.id_project 
		// 	join product c on a.id_product = c.id_product 
		// 	join part d on a.id_part = d.id_part 
		// 	join doc_part e on a.id_doc_part = e.id_doc_part
      //       join proj_vendor_upload f on a.id_project = f.id_project and a.id_product = f.id_product and a.id_part = f.id_part and a.id_doc_part = f.id_doc_part
		// 	WHERE a.id_project = '$id_project' AND a.id_product = '$id_product' 
		// 	AND a.id_part = '$id_part' AND f.id_vendor = '$id_vendor' AND e.doc_type = '$doc_type' 
		// 	group by a.id_project, a.id_product, a.id_part, a.id_doc_part
		// 	order by a.id_project";

		// /* $result = mysql_query($query) or die(mysqli_error($conn));
		// mysql_close($conn); */
		// $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		// mysqli_close($conn);
		$a = ProjectVendorAssign::get();
		$result=[];
		foreach($a as $a)
		{
			$result[] = ['id_project' => @$a->id_project,
			'nm_project'=>@$a->project->nm_project,
			'id_product' => @$a->id_product,
			'nm_product' => @$a->product->nm_product,
			'id_part' => @$a->part->id_part,
			'nm_part' => @$a->part->nm_part,
			'id_doc_part'=>@$a->id_doc_part,
			'nm_doc_part'=> @$a->nm_doc_part,
			'id_vendor'=>@$a->vendor->id_vendor,
			'doc_type' => @$a->docPart->doc_type,
			'check_status_a' => @$a->check_status_a,
			'check_status_b' =>  @$a->check_status_b,
			'upload_path' => @$a->ProjDocAssign->upload_path,
			'file_nm' => @$a->ProjDocAssign->file_nm,
			'version_n' => @$a->ProjDocAssign->version_n,
			'upload_n' => @$a->ProjDocAssign->version_n];
		}
	return $result;
	}

	function update_proj_doc_upload($id_project, $id_product, $id_part, $id_doc_part, $file_nm, $upload_n, $version_n, $uploader_id, $upload_path){

	
		$result = ProjectDocUpload::where(['id_project' => $id_project, 'id_product' => $id_product, 'id_part' => $id_part, 'id_doc_part' => $id_doc_part])->update(['file_nm' => $file_nm, 'upload_n' => $upload_n, 'version_n' => $version_n, 'uploader_id' => $uploader_id, 'upload_path' => $upload_path, 'upload_date' => date("Y-m-d H:i:s")]);
		
	return true;
	}	
	function update_vendor_doc_upload($id_project, $id_product, $id_part, $id_doc_part, $file_nm, $upload_n, $version_n, $uploader_id, $upload_path, $id_vendor){

		// $conn = get_connection(); 
		// $query = "UPDATE proj_vendor_upload SET file_nm = '$file_nm', upload_n = '$upload_n', version_n = '$version_n', uploader_id = '$uploader_id', upload_path = '$upload_path', upload_date = '".date("Y-m-d H:i:s")."' WHERE id_project = '$id_project' AND id_product = '$id_product' AND id_part = '$id_part' AND id_doc_part = '$id_doc_part' AND id_vendor = '$id_vendor' ";
		// /* $result = mysql_query($query) or die(mysqli_error($conn));
		// mysql_close($conn); */
		// $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		// mysqli_close($conn);
		$result = ProjectVendorUpload::where(['id_project' => $id_project,'id_product' => $id_product,'id_part' => $id_part,'id_doc_part' => $id_doc_part,'id_vendor' => $id_vendor])->update(['file_nm' => $file_nm ,
					'upload_n' => $upload_n ,
					'version_n' => $version_n ,
					'uploader_id' => $uploader_id ,
					'upload_path' => $upload_path ,
					'upload_date' => now() ]);
		return $result;
	}
		
	function insert_proj_doc_assign($id_project, $id_product, $id_part, $id_doc_part, $check_params){

	
		$result = ProjectDocAssign::create(['id_assign' => Numbering::autoIncrement(new \App\Models\ProjectDocAssign(),"id_assign"),'id_project' => $id_project, 'id_product' => $id_product, 'id_part' => $id_part, 'id_doc_part' => $id_doc_part, 'check_params' => $check_params]);

		return $result;
	}


	function insert_proj_doc_upload($id_project, $id_product, $id_part, $id_doc_part, $doc_required, $file_nm, $upload_n, $version_n, $uploader_id, $upload_path){
		
		
		$result = ProjectDocUpload::create(['id_assign' => Numbering::autoIncrement(new \App\Models\ProjectDocUpload(),"id_assign"),
											'id_project' => $id_project,
											 'id_product' => $id_product,
											 'id_part' => $id_part,
											 'id_doc_part' => $id_doc_part,
											 'file_nm' => $file_nm,
											 'upload_n' => $upload_n,
											 'version_n' => $version_n,
											 'uploader_id' => $uploader_id,
											 'doc_required' => $doc_required,
											 'upload_path' => $upload_path,
											 'upload_date' => date("Y-m-d H:i:s")
											]);
			return $result;
	}

	function insert_proj_vendor_upload($id_project, $id_product, $id_part, $id_doc_part, $doc_required, $file_nm, $upload_n, $version_n, $uploader_id, $upload_path, $id_vendor){
		

	$ret = ProjectVendorUpload::create([
								'id_assign' => Numbering::generateAuto(new \App\Models\ProjectVendorUpload(),"id_assign", 18, 18, 1, ""),
							'id_project'=>$id_project,
							 'id_product'=>$id_product,
							 'id_part'=>$id_part,
							 'id_doc_part'=>$id_doc_part,
							 'doc_required'=>$doc_required,
							 'file_nm'=>$file_nm,
							 'upload_n'=>$upload_n,
							 'version_n'=>$version_n,
							 'upload_date'=>date("Y-m-d H:i:s"),
							 'uploader_id'=>$uploader_id,
							 'upload_path'=>$upload_path,
							 'id_vendor'=>$id_vendor]);
	return $ret;
	}

	function get_group_all_join_proj_prod_part_doc_data($id_project, $doc_type){

		
		$prodProject = ProductForProject::where('id_project',$id_project)->groupBy('id_product')->get(); //11
			$arrd=[];
			foreach($prodProject as $p)
			{
				$partProduct = PartForProduct::where('id_product',$p->id_product)->groupBy('id_part')->get();//1
				foreach($partProduct as $p2)
				{
					$docofpart = DocForPart::where('id_part', $p2->id_part)->groupBy('id_doc_part')->get(); //3
					foreach($docofpart as $d)
					{
						$getDoc = DocPart::where('id_doc_part', $d->id_doc_part)->where('doc_type',$doc_type)->first();
						$docChecklist = DocChecklist::where('id_doc_part', $d->id_doc_part)->get();//13
						foreach($docChecklist as $d2)
						{
							if(!empty($getDoc))
							{
								$arrd[] = ['id_project' => $p->id_project,'id_product' => $p->id_product,'nm_product' => $p->product->nm_product,'nm_part' => $p2->part->nm_part,'id_part' => $p2->id_part,'id_doc_part' => $d->id_doc_part, 'nm_doc_part' => $getDoc->nm_doc_part, 'check_params' => $d2->check_params,'doc_type' => $getDoc->doc_type,'doc_required' => $getDoc->doc_required];	
							}
							

						}
					}
				}
			}
			// dd($arrd);
			return $arrd;
	}

	function get_group_all_join_proj_prod_part_data($id_project, $id_product, $id_part, $doc_type){
    	$prodProject = ProductForProject::where('id_project',$id_project)->get(); //11
		$arrd=[];
		foreach($prodProject as $p)
		{
			$partProduct = PartForProduct::where('id_product',$p->id_product)->get();//1
			foreach($partProduct as $p2)
			{
				$docofpart = DocForPart::where('id_part', $p2->id_part)->groupBy('id_doc_part')->get(); //3
				foreach($docofpart as $d)
				{
					$getDoc = DocPart::where('id_doc_part', $d->id_doc_part)->where('doc_type',$doc_type)->first();
					$docChecklist = DocChecklist::where('id_doc_part', $d->id_doc_part)->get();//13
					foreach($docChecklist as $d2)
					{
						if(!empty($getDoc))
						{
							$arrd[] = ['id_project' => $p->id_project,'id_product' => $p->id_product,'nm_product' => $p->product->nm_product,'nm_part' => $p2->part->nm_part,'id_part' => $p2->id_part,'id_doc_part' => $d->id_doc_part, 'nm_doc_part' => $getDoc->nm_doc_part, 'check_params' => $d2->check_params,'doc_type' => $getDoc->doc_type,'doc_required' => $getDoc->doc_required];	
						}
						

					}
				}
			}
		}
		// dd($arrd);
		return $arrd;
		
	}
	function get_all_proj_doc_upload_data($id_project){

		$result = ProjectDocUpload::where('id_project', $id_project)->get();
		


		return $result;
	}
	function deleteUploaded($id_project){

		$result = ProjectDocUpload::where('id_project', $id_project)->delete();
		


		return $result;
	}
	function get_proj_assign_data($id_project){

		$result = ProjectDocAssign::where('id_project', $id_project)->get();
		return $result;
	}
	
    function get_proj_doc_assign_data3($id_project, $id_vendor)
    {

		// $conn = get_connection(); 
		// $query = "SELECT a.*, b.doc_type, b.doc_required FROM proj_vendor_assign a left join doc_part b on a.id_doc_part = b.id_doc_part WHERE id_project= '$id_project' AND doc_type ='V' AND (doc_required ='Y' OR doc_required = 'M') AND id_vendor = '$id_vendor' group by id_project, id_product, id_part, id_doc_part";
		// /* $result = mysql_query($query) or die(mysqli_error($conn));
		// mysql_close($conn); */
		// $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		// mysqli_close($conn);

		$arrd = [];
		$a = ProjectVendorAssign::where('id_project',$id_project)->where('id_vendor',$id_vendor)->get();
		foreach($a as $a)
		{
			$b = DocPart::where('id_doc_part',$a->id_doc_part)->where('doc_type','V')->whereIn('doc_required',['Y','M'])->get();

			foreach($b as $b)
			{
				$arrd[]=[
							'id_assign' => $a->id_assign,
							'id_project' => $a->id_project,
							'id_product' => $a->id_product,
							'id_part' => $a->id_part,
							'id_doc_part' => $a->id_doc_part,
							'check_params' => $a->check_params,
							'comment' => $a->e,
							'check_status' => $a->check_status,
							'checker_id' => $a->checker_id,
							'check_date' => $a->check_date,
							'doc_type' => $b->doc_type,
							'doc_required' => $b->doc_required,
					];
			}
		}

			return  $arrd;

	}

	function get_proj_doc_assign_data2($id_project){

		// $conn = get_connection(); 
		// $query = "SELECT a.*, b.doc_type, b.doc_required FROM proj_doc_assign a left join doc_part b on a.id_doc_part = b.id_doc_part WHERE id_project= '$id_project' AND doc_type ='P' AND (doc_required ='Y' OR doc_required = 'M') group by id_project, id_product, id_part, id_doc_part";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$arrd = [];
		$a = ProjectVendorAssign::where('id_project',$id_project)->groupBy('id_project','id_product','id_part','id_doc_part')->get();
		foreach($a as $a)
		{
			$b = DocPart::where('id_doc_part',$a->id_doc_part)->whereIn('doc_required',['Y','M'])->get();

			foreach($b as $b)
			{
				$arrd[]=[
							'id_assign' => $a->id_assign,
							'id_project' => $a->id_project,
							'id_product' => $a->id_product,
							'id_part' => $a->id_part,
							'id_doc_part' => $a->id_doc_part,
							'check_params' => $a->check_params,
							'comment' => $a->e,
							'check_status' => $a->check_status,
							'checker_id' => $a->checker_id,
							'check_date' => $a->check_date,
							'doc_type' => $b->doc_type,
							'doc_required' => $b->doc_required,
							];
			}
		}

			return  $arrd;
	}

	function get_proj_doc_upload_data_status($id_project){

		// $conn = get_connection(); 
		// $query = "SELECT a.*, b.doc_type, b.doc_required FROM proj_doc_upload a left join doc_part b on a.id_doc_part = b.id_doc_part WHERE id_project= '$id_project' AND doc_type ='P' AND (b.doc_required ='Y' OR b.doc_required = 'M') AND upload_path <> '' group by id_project, id_product, id_part, id_doc_part";
		// /* $result = mysql_query($query) or die(mysqli_error($conn));
		// mysql_close($conn); */
		// $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		// mysqli_close($conn); 'id_assign','id_project','id_product','id_part','id_doc_part','file_nm','upload_n','version_n','doc_required','upload_id','upload_path','download_stat','download_date','downloader_id','permit_n','uploader_id'
		$arrd=[];
		$a = ProjectDocUpload::where('upload_path','<>','')->where('id_project',$id_project)->get();
		foreach($a as $a)
		{
			$b = DocPart::where('id_doc_part',$a->id_doc_part)->whereIn('doc_required',['Y','M'])->get();

			foreach($b as $b)
			{
				$arrd[]=[
							'id_assign' => $a->id_assign,
							'id_project' => $a->id_project,
							'id_product' => $a->id_product,
							'id_part' => $a->id_part,
							'file_nm' => $a->file_nm,
							'upload_n' => $a->upload_n,
							'version_n' => $a->version_n,
							'doc_required' => $a->doc_required,
							'upload_id' => $a->upload_id,
							'upload_path' => $a->upload_path,
							'download_stat' => $a->download_stat,
							'download_date' => $a->download_date,
							'downloader_id' => $a->downloader_id,
							'permit_n' => $a->permit_n,
							'uploader_id' => $a->uploader_id,
							'doc_type' => $b->doc_type,
							'doc_required' => $b->doc_required,
							];
			}
		}
			return  $arrd;
	
	}

	function get_vendor_has_assigned_detail2($id_project, $id_vendor, $docType = "P")
	{
		$data = ProjectVendorAssign::where('id_project',$id_project)->with(['docPart' => function($query) use($docType){
			$query->where('id_doc_part',$docType);
		}])->get();

		return $data;
	}
	function get_proj_doc_assign_part_doc_all2_new($id_project, $id_product, $id_part, $id_doc_part){

    // $conn = get_connection();
    // $query = "SELECT a.*, b.doc_required, b.doc_type FROM proj_doc_assign a left join doc_part b on a.id_doc_part = b.id_doc_part where a.id_project='$id_project' AND a.id_product = '$id_product' AND a.id_part = '$id_part' AND a.id_doc_part ='$id_doc_part' AND b.doc_type = 'P' AND (b.doc_required = 'Y' OR b.doc_required='M')";
    // /* $result = mysql_query($query) or die(mysqli_error($conn));
	// 	mysql_close($conn); */
	// 	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	// 	mysqli_close($conn);
		$arrd = [];
		$result = ProjectDocAssign::where('id_product',$id_product)->where('id_part',$id_part)->where('id_doc_part',$id_doc_part)->where('id_project',$id_project)->get();
		foreach($result as $r)
		{
			if(in_array($r->docPart->doc_required,['Y','M']) AND $r->docPart->doc_type == 'P')
			{
				$arrd[] = ['doc_required' => $r->docPart->doc_required,'doc_type'=> $r->docPart->doc_type,'id_assign' => $r->id_assign,'id_product' => $r->id_product,'id_part' => $r->id_part,'id_doc_part' => $r->id_doc_part,'check_params' => $r->check_params,'comment' => $r->comment,'check_status' => $r->check_status,'checker_id' => $r->checker_id,'check_date' => $r->check_date];
			}
			
		}
    return $arrd;
    }

    function get_proj_doc_assign_sum_part_doc_all2_new($id_project, $id_product, $id_part, $id_doc_part){

    // $conn = get_connection();
    // $query = "SELECT a.*, b.doc_required, b.doc_type FROM proj_doc_assign a left join doc_part b on a.id_doc_part = b.id_doc_part where a.id_project='$id_project' AND a.id_product = '$id_product' AND a.id_part = '$id_part' AND a.id_doc_part ='$id_doc_part' AND b.doc_type = 'P' AND (b.doc_required = 'Y' OR b.doc_required='M')";
    // /* $result = mysql_query($query) or die(mysqli_error($conn));
	// 	mysql_close($conn); */
	// 	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	// 	mysqli_close($conn);
		$sum = 0;
		$result = ProjectDocAssign::where('id_product',$id_product)->where('id_part',$id_part)->where('id_doc_part',$id_doc_part)->where('id_project',$id_project)->get();
		foreach($result as $r)
		{
			if(in_array($r->docPart->doc_required,['Y','M']) AND $r->docPart->doc_type == 'P')
			{
				$sum += intval($r->check_status);
			}
			
		}
    return $sum;
    }
	function get_proj_doc_assign_data_status($id_project,$id_product,$id_part,$id_doc_part){
		$data = ProjectVendorAssign::where(['id_project' => $id_project,'id_product' => $id_product, 'id_part' => $id_part,'id_doc_part' => $id_doc_part])->sum('check_status');
		// $data = ProjectVendorAssign::where(['id_project' => "440000000003",'id_product' => "410000000005", 'id_part' => "420000000001",'id_doc_part' => "430000000001"])->sum('check_status');

		return $data;
	}

	function allJoin($id_project, $docType)
	{
		$prodProject = ProductForProject::where('id_project',$id_project)->groupBy('id_product')->get(); //11
		$arrd=[];
		foreach($prodProject as $p)
		{
			$partProduct = PartForProduct::where('id_product',$p->id_product)->groupBy('id_part')->get();//1
			foreach($partProduct as $p2)
			{
				$docofpart = DocForPart::where('id_part', $p2->id_part)->groupBy('id_doc_part')->get(); //3
				foreach($docofpart as $d)
				{
					$getDoc = DocPart::where('id_doc_part', $d->id_doc_part)->first();
					$docChecklist = DocChecklist::where('id_doc_part', $d->id_doc_part)->get();//13
					foreach($docChecklist as $d2)
					{
						if($getDoc->doc_type == "P")
						{
							$arrd[] = ['id_project' => $p->id_project,'id_product' => $p->id_product,'nm_product' => $p->product->nm_product,'nm_part' => $p2->part->nm_part,'id_part' => $p2->id_part,'id_doc_part' => $d->id_doc_part, 'nm_doc_part' => $getDoc->nm_doc_part, 'check_params' => $d2->check_params,'doc_type' => $getDoc->doc_type];	
						}
						

					}
				}
			}
		}

		return $arrd;
	}


	function get_permit($id_project, $id_product, $id_part){

		

		$data = ProjectDocUpload::where(['id_project' => $id_project,'id_product' => $id_product, 'id_part' => $id_part])->max('permit_n');
		

		return $data;
	}

	function get_upload_sequence($id_project, $id_product, $id_part)
	{

		$data = ProjectDocUpload::where(['id_project' => $id_project,'id_product' => $id_product, 'id_part' => $id_part])->max('upload_n');

		return $data;
	}

	function get_doc_ver($id_project, $id_product, $id_part, $id_doc_part){

		$result =  ProjectDocUpload::where(['id_project'=>$id_project,'id_product'=>$id_product,'id_part'=>$id_part,'id_doc_part'=>$id_doc_part])->first();
	

		return $result;
	}


}
