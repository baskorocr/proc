<?php
namespace App\Helpers;

use App\Models\Project;
use App\Models\ProjectDocUpload;
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
