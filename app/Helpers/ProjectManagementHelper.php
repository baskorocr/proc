<?php
namespace App\Helpers;

use App\Models\Project;
use App\Models\ProjectDocUpload;
use App\Models\ProjectDocAssign;
use App\Models\ProjectVendorAssign;
use App\Models\ProductForProject;
use App\Models\DocForPart;
use App\Models\PartForProduct;
use App\Models\DocPart;
use App\Models\DocChecklist;

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
	function get_proj_vendor_assign_data_status_all($id_project, $id_vendor){

		
		$result = ProjectVendorAssign::where('id_project',$id_project)->where('id_vendor',$id_vendor)->sum('check_status_a');

		return $result;
	}
	function get_proj_vendor_assign_data_status_all2($id_project, $id_vendor){

		
		$result = ProjectVendorAssign::where('id_project',$id_project)->where('id_vendor',$id_vendor)->sum('check_status_b');

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

    function get_proj_doc_assign_data3($id_project, $id_vendor)
    {

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
		$data = ProjectVendorAssign::where('id_project',$id_project)->where('id_vendor',$id_vendor)->with(['docPart' => function($query) use($docType){
			$query->where('id_doc_part',$docType);
		}])->get();

		return $data;
	}
	function get_proj_doc_assign_data_status($id_project,$id_product,$id_part,$id_doc_part){
		$data = ProjectVendorAssign::where(['id_project' => $id_project,'id_product' => $id_product, 'id_part' => $id_part,'id_doc_part' => $id_doc_part])->sum('check_status');
		// $data = ProjectVendorAssign::where(['id_project' => "440000000003",'id_product' => "410000000005", 'id_part' => "420000000001",'id_doc_part' => "430000000001"])->sum('check_status');

		return $data;
	}

	function allJoin($id_project, $docType)
	{
		$prodProject = ProductForProject::where('id_project',$id_project)->get(); //11
		$arrd=[];
		foreach($prodProject as $p)
		{
			$partProduct = PartForProduct::where('id_product',$p->id_product)->get();//1
			foreach($partProduct as $p2)
			{
				$docofpart = DocForPart::where('id_part', $p2->id_part)->get(); //3
				foreach($docofpart as $d)
				{
					$getDoc = DocPart::where('id_doc_part', $d->id_doc_part)->first();
					$docChecklist = DocChecklist::where('id_doc_part', $d->id_doc_part)->get();//13
					foreach($docChecklist as $d2)
					{
						if($getDoc->doc_type == "P")
						{
							$arrd[] = ['id_project' => $p->id_project,'id_product' => $p->id_product,'id_part' => $p2->id_part,'id_doc_part' => $d->id_doc_part, 'nm_doc_part' => $getDoc->nm_doc_part, 'check_params' => $d2->check_params,'doc_type' => $getDoc->doc_type];	
						}
						

					}
				}
			}
		}

		return $arrd;
	}
	function get_permit($id_project, $id_product, $id_part){

		

		$data = ProjectDocUpload::where(['id_project' => $id_project,'id_product' => $id_product, 'id_part' => $id_part])->sum('permit_n');
		

		return $data;
	}

	function get_upload_sequence($id_project, $id_product, $id_part)
	{

		$data = ProjectDocUpload::where(['id_project' => $id_project,'id_product' => $id_product, 'id_part' => $id_part])->max('upload_n');

		return $data;
	}


}
