<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Product;
use App\Models\Part;
use App\Models\DocPart;
use App\Models\DocForPart;
use App\Models\DocCheckList;
use App\Models\ProductForProject;
use App\Models\PartForProduct;
use App\Models\ProjectDocAssign;
use App\Models\ProjectDocUpload;
use App\Models\ProjectVendorUpload;
use App\Models\ProjectVendorAssign;
use Numbering;
use DB;
use PM;
use App\Models\Vendor;

class ProjectManagementController extends Controller
{
    public function projectMaster()
    {
        $prj = Project::where('status','A')->where('assigned','N')->get();
        $prod = Product::where('status','A')->where('assigned','Y')->get();
        return view('project_management/project_master/index')->with(['project' => $prj,'product' => $prod]);
    }

    public function productMaster()
    {
         $prj = Part::where('status','A')->where('assigned','Y')->get();
        $prod = Product::where('status','A')->where('assigned','N')->get();
        return view('project_management/product_master/index')->with(['parts' => $prj,'product' => $prod]);
    }  

    public function viewDocVendor(Request $request)
    {
        $prj = ProjectVendorAssign::where('id_vendor',auth()->user()->vendor->id_vendor)->get();
        $ret = ['project' => $prj];
         if(!empty($request->id_project))
        {
            $project = Project::where('id_project',$request->id_project)->get();
            $ret['detail'] =$project;
        }
           return view('project_management/view_doc_vendor/index')->with($ret);
    }

     public function checkDocVendor(Request $request)
    {
        $prj = Project::get();
        $ret = ['project' => $prj];
         if(!empty($request->id_project))
        {
            $project = Project::where('id_project',$request->id_project)->get();
            $ret['detail'] =$project;
        }
           return view('project_management/check_uploaded_vendor/index')->with($ret);
    }


    public function checkDocEng(Request $request)
    {
       $prj = Project::where('status','A')->where('assigned','Y')->get();
        $ret = ['project' => $prj];

        if(!empty($request->id_project))
        {
            $project = ProjectDocUpload::where('id_project',$request->id_project)->get();
            $ret['project_uploaded'] = $project;
        }
        return view('project_management/check_doc_eng/index')->with($ret);
    }  

    public function dashboardMonProject(Request $request)
    {
       $prj = ProjectVendorAssign::groupBy('id_project','id_vendor')->get();
       $ret['project'] = $prj;
        return view('project_management/project_monitoring/index')->with($ret);
    }  

    public function dashboardMonVendor(Request $request)
    {
       $prj = ProjectVendorAssign::groupBy('id_project','id_vendor')->get();
       $ret['project'] = $prj;
        return view('project_management/vendor_monitoring/index')->with($ret);
    }  
    public function file_master(Request $request)
    {
    
        return view('project_management/file_master/index');
    }  

    public function assignVendor(Request $request)
    {
       $prj = Project::where('status','A')->where('assigned','Y')->get();
        $ret = ['project' => $prj];

        if(!empty($request->id_project))
        {
            $pfp = ProductForProject::where('id_project',$request->id_project)->get();
        
            $ret['prodforProject'] = $pfp;
        } 

        if(!empty($request->prod_part))
        {
            // PM::get_proj_doc_assign_part_doc_all_new($request->id_project,$request->prod_part,'P');
            $pfp = Vendor::where('status_vendor','A')->get();
            // $prod = Vendor::get();
        
            $ret['vendor'] = $pfp;
            $ret['prod'] = $pfp;
        }
        return view('project_management/assign_doc_vendor/index')->with($ret);
    }

    public function assignVendorAct(Request $request)
    {
       
            $id_project = $request->id_project;
            $id_vendor  = $request->id_vendor;

            $query_exec5 = PM::get_group_all_join_proj_prod_part_doc_data($id_project, "V");
            $pack=[];
            foreach ($query_exec5 as $row5) {
                $id_product = $row5['id_product'];
                $nm_product = $row5['nm_product'];
                $id_part = $row5['id_part'];
                $nm_part = $row5['nm_part'];
                $id_doc_part = $row5['id_doc_part'];
                $nm_doc = $row5['nm_doc_part'];
                $doc_required = $row5['doc_required'];

                $nm_part = $row5['nm_part'];
                $nm_prod = $row5['nm_product'];
                $string = $nm_prod . '_' . $nm_part;
                $htm_nm = preg_replace('/\s+/', '', $string);
                $htm_name = str_replace('-', '', $htm_nm);
              $htm_name = md5($htm_name);    
                // dd([$string,$htm_name]);
                if (isset($request->{$htm_name})) {
                    $query_executes = PM::get_proj_vendor_assign_data_vendor($id_project, $id_product, $id_part, $id_vendor);
                    $num_rows = count($query_executes);

                    if ($num_rows == 0) {
                        echo"xx"; 
                        PM::insert_proj_vendor_upload($id_project, $id_product, $id_part, $id_doc_part, "", "", "", "", "", "", $id_vendor);
                    } //if ($num_row == 0)

                }//if (isset($_POST[$htm_name]))

            } //while ($row5 = mysqli_fetch_assoc($query_exec5))

            $query_exec6 = PM::get_group_all_join_prod_part_data4($id_project, '');
            // dd($query_exec6);
            foreach ($query_exec6 as $row6) {
                $id_product = $row6['id_product'];
                $id_part = $row6['id_part'];
                $id_doc_part = $row6['id_doc_part'];
                $check_params = $row6['check_params'];
                $doc_type = $row6['doc_type'];

                $nm_part = $row6['nm_part'];
                $nm_prod = $row6['nm_product'];
                $string = $nm_prod . '_' . $nm_part;
                $htm_nm = preg_replace('/\s+/', '', $string);
                $htm_name = str_replace('-', '', $htm_nm);
                 $htm_name = md5($htm_name);


            
                // dd($row6);
                if (isset($request->{$htm_name})) {
                    //echo $id_project."-".$id_product."-".$id_part."-".$id_doc_part."-".$check_params."-".$doc_type."-".$id_vendor."<br>";
                    $query_executes2 = PM::get_proj_vendor_assign_data_vendor2($id_project, $id_product, $id_part, $id_doc_part, $check_params, $id_vendor);
                    $num_rows2 = count($query_executes2);

                    if ($num_rows2 == 0) {
                        // echo"up 2";
                        PM::insert_proj_vendor_assign($id_project, $id_product, $id_part, $id_doc_part, $check_params, $id_vendor);
                    }//if ($num_row == 0)

                }//if (isset($_POST[$htm_name]))

            }//while ($row6 = mysqli_fetch_assoc($query_exec6))

            /*
            echo " <script> window.alert('Success Assigned!'); 
                            window.location=('home.php?mnu=monitoring');
                   </script>";
            */
                   // exit();
            return redirect()->route('project.management.assign.vendor')->with(['message_success' => "Assign Success"]);

        }//if (isset($_POST['assign-vendor']))


    public function DocCheckListMaster()
    {
         $prj = Part::where('status','A')->where('assigned','N')->get();
        $prod = Product::where('status','A')->where('assigned','Y')->get();
        return view('project_management/list_check_master/index')->with(['parts' => $prj,'product' => $prod]);
    }  

    public function DocMaster()
    {
         $prj = Part::where('status','A')->where('assigned','N')->get();
        $prod = Product::where('status','A')->where('assigned','Y')->get();
        return view('project_management/list_check_master/index_docmaster')->with(['parts' => $prj,'product' => $prod]);
    } 

    public function uplReqDoc(Request $request)
    {
        $prj = ProjectVendorAssign::where('id_vendor',auth()->user()->vendor->id_vendor)->get();
        
        $ret = ['project' => $prj];
       if(!empty($request->id_project)){
        // DB::connection('mongodb')->enableQueryLog();
        $pfp = ProductForProject::where('id_project',$request->id_project)->get();
        // dd(DB::connection('mongodb')->getQueryLog());
        // dd($pfp);
        $wherein=[];
        foreach($pfp as $pfp)
        {
            $wherein[]=$pfp->id_product;
        }
        $prod = PartForProduct::whereIn('id_product',$wherein)->get();
        $ret['prodforProject'] = $prod;
        if(!empty($request->prod_part)){
            $exp =  explode("_", $request->prod_part);
            $id_product = $exp[0];
            $id_part    = $exp[1];
            $ret['id_product'] = $id_product;
            $ret['id_part'] = $id_part;
            $ret['id_vendor'] = auth()->user()->vendor->id_vendor;
            $ret['docpart'] = DocPart::get();
        }
       }


        return view('project_management/upl_req_doc/index')->with($ret);
    
    }
   
    public function uploadDocAct(Request $request)
    {
        $id_project_new     = $request->id_project;
        $dest_path          = "DATA/$id_project_new";
        $id_product_new     = $request->id_product;
        $id_part_new        = $request->id_part;
        $id_doc_part_new    = $request->id_doc_part;
        // dd($id_project_new);
        $upload_count = PM::get_upload_sequence($id_project_new, $id_product_new, $id_part_new);
        $upload_n = intval($upload_count) + 1;
        $upload_count_n =$upload_count;
        $upld_count = count($request->doc);

            $nm_product         = array();
            $nm_part            = array();
            $nm_doc_part        = array();

            $query_exec5 = PM::allJoin($request->id_project,"P");
            foreach($query_exec5 as $aj)
            {
                $product     = $aj['nm_product'];
                $part        = $aj['nm_part'];
                $doc_part    = $aj['nm_doc_part'];

                array_push($nm_part, $part);
                array_push($nm_doc_part, $doc_part);
                array_push($nm_product, $product);
            }

              $data_count       = PM::get_group_all_join_proj_prod_part_data_required($id_project_new, $id_product_new, $id_part_new, 'P', 'Y', 'M');
                $row_data_count   = count($data_count);    
                $count_doc        = count($id_doc_part_new);

                $upload_array = array();
                $upld_count = count($request->doc);
                for ($x = 0; $x <= $upld_count; $x++){
                    // dd($request->doc[$x]);
                    if (!empty($request->doc[$x])){
                        array_push($upload_array, $x);
                    }
                }
                // dd(count($request->doc));
                            //error
                if(count($upload_array) == 0){ //check doc choosen

                  return redirect()->back()->with(['message_fail' => "No File Choosen."]);

                } else { 
                     $row_query          = PM::get_all_proj_doc_upload_data($id_project_new);
                    $row_proj_upload    = count($row_query);

                    $row_query_ass      = PM::get_proj_assign_data($id_project_new);
                    $row_project_assign = count($row_query_ass);
                    // dd(PM::deleteUploaded($id_project_new) );
                    if ($row_proj_upload == 0 AND $row_project_assign == 0) {
                         $path = public_path("DATA/$id_project_new/" );
                         if (!file_exists($path)) {
                                                mkdir($path, 0777, true);
                                            }

                          $query_exec5 = PM::get_group_all_join_proj_prod_part_doc_data($id_project_new, "P");
                            foreach($query_exec5 as $row5) {
                                $id_product     = $row5['id_product'];
                                $nm_product     = $row5['nm_product'];
                                $id_part        = $row5['id_part'];
                                $nm_part        = $row5['nm_part'];
                                $id_doc_part    = $row5['id_doc_part'];
                                $nm_doc         = $row5['nm_doc_part'];
                                $doc_required   = $row5['doc_required'];

                                PM::insert_proj_doc_upload($id_project_new, $id_product, $id_part, $id_doc_part, $doc_required, "", "", "", "", "");

                            } //while ($row5 = mysqli_fetch_assoc($query_exec5))

                             //insert detail data to proj_doc_assign
                            $idproj_arr         = array();
                            $idprod_arr         = array();
                            $idpart_arr         = array();
                            $iddoc_arr          = array();
                            $checkparams_arr    = array();

                            $i = 0;

                            $query_exec6 = PM::allJoin($request->id_project,"P");
                            // dd($query_exec6);
                            foreach ($query_exec6 as $row6) {
                                // code...
                         

                                $idproj_arr[]       = $request->id_project;
                                $idprod_arr[]       = $row6['id_product'];
                                $idpart_arr[]       = $row6['id_part'];
                                $iddoc_arr[]        = $row6['id_doc_part'];
                                $checkparams_arr[]  = $row6['check_params'];

                                PM::insert_proj_doc_assign($idproj_arr[$i], $idprod_arr[$i], $idpart_arr[$i], $iddoc_arr[$i], $checkparams_arr[$i]);

                                $i++;
                            }

                            foreach($_FILES['doc']['tmp_name'] as $key => $tmp_name)
                                    {
                                        if(!empty($_FILES['doc']['name'][$key]))
                                        {
                                             $file_name  = $_FILES['doc']['name'][$key];
                                        $file_size  = $_FILES['doc']['size'][$key];
                                        $file_tmp   = $_FILES['doc']['tmp_name'][$key];
                                        $file_type  = $_FILES['doc']['type'][$key];
                                        // dd(($request->file('doc')[$key]));
                                        $file = $request->file('doc')[$key];
                                        if ($file_tmp  != ""){

                                            //$query_exec_data = get_upload_sequence($id_project_new, $id_product_new, $id_part_new, $id_doc_part_new[$key]);
                                            /*
                                            $query_exec_data = get_upload_sequence($id_project_new, $id_product_new, $id_part_new);
                                            $upload_count   = mysqli_fetch_assoc($query_exec_data);
                                            $upload_count_n = $upload_count['upload_n'];
                                            $upload_n = intval($upload_count_n) + 1;
                                            */

                                            $query_exec_data2 = PM::get_doc_ver($id_project_new, $id_product_new, $id_part_new, $id_doc_part_new[$key]);
                                            $version_count   = $query_exec_data2;
                                            $version_count_n = $version_count->version_n;
                                            $version_n      = intval($version_count_n) + 1;
                                            $uploader_id = auth()->user()->id_user;

                                            $query = PM::get_group_all_join_proj_prod_part_data($id_project_new, $id_product_new, $id_part_new, 'P');
                                            $rows = $query;
                                            $nm_product_file = $rows[0]['nm_product'];
                                            $nm_part_file    = $rows[0]['nm_part'];

                                            $temp = explode(".", $_FILES["doc"]["name"][$key]);
                                            $newfilename = \Str::snake($nm_product_file."_ver".$version_n). '.' . end($temp);

                                            $newfilename = str_replace(',', '', $newfilename);

                                            /*
                                                nama product pasti nama file di array
                                                sehingga nama nya akan selalu restart ke product 1
                                                begitu juga nama part
                                                pasti akan selalu restart ke part A
                                            */
                                            $path = public_path("DATA/$id_project_new/" );
                                            // dd($path);
                                            if (!file_exists($path)) {
                                                mkdir($path, 0777, true);
                                            }
                                            if ( $file->move($path,$newfilename)){
                                                $upload_path    =$path;
                                                $upload_n       = intval($upload_count_n) + 1;
                                                $version_n      = intval($version_count_n) + 1;
                                            } else {

                                                $upload_path    ="";
                                                $upload_n       = "";
                                                $version_n      = "";
                                            }
                                             PM::update_proj_doc_upload($id_project_new, $id_product_new, $id_part_new, $id_doc_part_new[$key], $newfilename, $upload_n, $version_n, $uploader_id, $upload_path);
                                        } else{
                                          
                                        }
                                        
                                            // dd("A");
                                           

                                            //echo "<script> alert('Upload success'); </script>";

                                    } //if ($file_tmp  != "")
                            return redirect()->back()->with(['message_success' => 'Upload Success']);

                           
                        }
                    }
                                    
                    elseif ($row_proj_upload > 0 AND $row_project_assign > 0)
                    {
                              $query_exec = PM::get_upload_sequence($id_project_new, $id_product_new, $id_part_new);
                                $upload_count   = $query_exec;
                                $upload_count_x = $upload_count;
                                $upload_x = intval($upload_count_x);

                                //get permit 1
                                $query_exec1 = PM::get_permit($id_project_new, $id_product_new, $id_part_new);
                                $permit_count1   = $query_exec1;
                                $permit_count_1 = $permit_count1;
                                $permit_x = intval($permit_count_1);

                                $permit_max1 = 6;
                                $permit_max2 = 7;

                                if ($permit_x == 1){
                                    $permit1 = $permit_x;
                                } elseif ($permit_x == 2) {
                                    $permit2 = $permit_x;
                                }


                                if ($upload_x < 5 OR ($permit_max1 == ($upload_x + $permit1)) OR ($permit_max2 == ($upload_x + $permit2)) ) {

                                    foreach($request->id_doc_part as $key => $tmp_name)
                                    {
                                        if(!empty($request->file('doc')[$key]))
                                        {
                                             $file_name  = $_FILES['doc']['name'][$key];
                                        $file_size  = $_FILES['doc']['size'][$key];
                                        $file_tmp   = $_FILES['doc']['tmp_name'][$key];
                                        $file_type  = $_FILES['doc']['type'][$key];
                                        // dd(($request->file('doc')[$key]));
                                        $file = $request->file('doc')[$key];
                                        if ($file_tmp  != ""){

                                            //$query_exec_data = get_upload_sequence($id_project_new, $id_product_new, $id_part_new, $id_doc_part_new[$key]);
                                            /*
                                            $query_exec_data = get_upload_sequence($id_project_new, $id_product_new, $id_part_new);
                                            $upload_count   = mysqli_fetch_assoc($query_exec_data);
                                            $upload_count_n = $upload_count['upload_n'];
                                            $upload_n = intval($upload_count_n) + 1;
                                            */

                                            $query_exec_data2 = PM::get_doc_ver($id_project_new, $id_product_new, $id_part_new, $id_doc_part_new[$key]);
                                            $version_count   = $query_exec_data2;
                                            $version_count_n = $version_count->version_n;
                                            $version_n      = intval($version_count_n) + 1;
                                            $uploader_id = auth()->user()->id_user;

                                            $query = PM::get_group_all_join_proj_prod_part_data($id_project_new, $id_product_new, $id_part_new, 'P');
                                            $rows = $query;
                                            $nm_product_file = $rows[0]['nm_product'];
                                            $nm_part_file    = $rows[0]['nm_part'];

                                            $temp = explode(".", $_FILES["doc"]["name"][$key]);
                                            $newfilename = \Str::snake($nm_product_file."_ver".$version_n). '.' . end($temp);

                                            $newfilename = str_replace(',', '', $newfilename);

                                            /*
                                                nama product pasti nama file di array
                                                sehingga nama nya akan selalu restart ke product 1
                                                begitu juga nama part
                                                pasti akan selalu restart ke part A
                                            */
                                            $path = public_path("DATA/$id_project_new/" );
                                            // dd($path);
                                            if (!file_exists($path)) {
                                                mkdir($path, 0777, true);
                                            }
                                            if ( $file->move($path,$newfilename)){
                                                $upload_path    ="DATA/$id_project_new/".$newfilename;
                                                $upload_n       = intval($upload_count_n) + 1;
                                                $version_n      = intval($version_count_n) + 1;
                                            } else {
                                                $upload_path    ="";
                                                $upload_n       = "";
                                                $version_n      = "";
                                            }
                                             PM::update_proj_doc_upload($id_project_new, $id_product_new, $id_part_new, $id_doc_part_new[$key], $newfilename, $upload_n, $version_n, $uploader_id, $upload_path);
                                        } else{
                                            
                                        }
                                        
                                            // dd("A");
                                           

                                            //echo "<script> alert('Upload success'); </script>";

                                        }//if ($file_tmp  != "")

                                    }
                                    //foreach($_FILES['doc']['tmp_name'] as $key => $tmp_name)

                                    //echo "<script> alert('Upload success'); </script>";

                                   return redirect()->back()->with(['message_success' => 'Upload Success']);

                                }// if ($upload_n < 5)



                    } else {
                         return redirect()->back()->with(['message_success' => 'You\'ve reached maximum upload. Please contact administrator for re-upload permission!']);
                                      

                                    }
                    }
                
           // dd($row_data_count);

  
        // if($upld_count == 0){ //check doc choosen

        //   return "RR";

        // } else {
        //     $data = 
           
        //         ProjectDocAssign::create(['id_assign' => Numbering::autoIncrement(new \App\Models\ProjectDocAssign(),"id_assign"),
        //                                   'id_product' => $aj->id_product,
        //                                     'id_part' => $aj->id_part,
        //                                     'id_doc_part'  => $aj->id_doc_part,
        //                                     'check_params'  => $aj->check_params
        //                                 ]);
        //     }

        // }

        }
    public function uploadDocReqAct(Request $request)
    {
        $id_project_new     = $request->id_project;
        $dest_path          = "DATA/$id_project_new";
        $id_product_new     = $request->id_product;
        $id_part_new        = $request->id_part;
        $id_doc_part_new    = $request->id_doc_part;
        $id_vendor = !empty(auth()->user()->vendor->id_vendor) ? auth()->user()->vendor->id_vendor:'1';
        // dd($id_project_new);
        $upload_count = PM::get_upload_sequence($id_project_new, $id_product_new, $id_part_new);
        $upload_n = intval($upload_count) + 1;
        $upload_count_n =$upload_count;
        $upld_count = count($request->doc);

            $nm_product         = array();
            $nm_part            = array();
            $nm_doc_part        = array();

            $query_exec5 = PM::allJoin($request->id_project,"P");
            foreach($query_exec5 as $aj)
            {
                $product     = $aj['nm_product'];
                $part        = $aj['nm_part'];
                $doc_part    = $aj['nm_doc_part'];

                array_push($nm_part, $part);
                array_push($nm_doc_part, $doc_part);
                array_push($nm_product, $product);
            }

              $data_count       = PM::get_group_all_join_proj_prod_part_data_required($id_project_new, $id_product_new, $id_part_new, 'P', 'Y', 'M');
                $row_data_count   = count($data_count);    
                $count_doc        = count($id_doc_part_new);

                $upload_array = array();
                $upld_count = count($request->doc);
                for ($x = 0; $x <= $upld_count; $x++){
                    // dd($request->doc[$x]);
                    if (!empty($request->doc[$x])){
                        array_push($upload_array, $x);
                    }
                }
                // dd(count($request->doc));
                            //error
                if(count($upload_array) == 0){ //check doc choosen

                  return redirect()->back()->with(['message_fail' => "No File Choosen."]);

                } else { 
                     $row_query          = PM::get_all_proj_doc_upload_data($id_project_new);
                    $row_proj_upload    = count($row_query);

                    $row_query_ass      = PM::get_proj_assign_data($id_project_new);
                    $row_project_assign = count($row_query_ass);
                    // dd(PM::deleteUploaded($id_project_new) );
                    // if ($row_proj_upload == 0 AND $row_project_assign == 0) {
                         $path = public_path("DATA/$id_project_new/" );
                         if (!file_exists($path)) {
                                                mkdir($path, 0777, true);
                                            }

                          $query_exec5 = PM::get_group_all_join_proj_prod_part_doc_data($id_project_new, "P");
                            foreach($query_exec5 as $row5) {
                                $id_product     = $row5['id_product'];
                                $nm_product     = $row5['nm_product'];
                                $id_part        = $row5['id_part'];
                                $nm_part        = $row5['nm_part'];
                                $id_doc_part    = $row5['id_doc_part'];
                                $nm_doc         = $row5['nm_doc_part'];
                                $doc_required   = $row5['doc_required'];

                                // PM::insert_proj_doc_upload($id_project_new, $id_product, $id_part, $id_doc_part, $doc_required, "", "", "", "", "");

                            } //while ($row5 = mysqli_fetch_assoc($query_exec5))

                             //insert detail data to proj_doc_assign
                            $idproj_arr         = array();
                            $idprod_arr         = array();
                            $idpart_arr         = array();
                            $iddoc_arr          = array();
                            $checkparams_arr    = array();

                            $i = 0;

                            $query_exec6 = PM::allJoin($request->id_project,"P");
                            // dd($query_exec6);
                            foreach ($query_exec6 as $row6) {
                                // code...
                         

                                $idproj_arr[]       = $request->id_project;
                                $idprod_arr[]       = $row6['id_product'];
                                $idpart_arr[]       = $row6['id_part'];
                                $iddoc_arr[]        = $row6['id_doc_part'];
                                $checkparams_arr[]  = $row6['check_params'];

                                $i++;
                            }

                            foreach($_FILES['doc']['tmp_name'] as $key => $tmp_name)
                                    {
                                        if(!empty($_FILES['doc']['name'][$key]))
                                        {
                                             $file_name  = $_FILES['doc']['name'][$key];
                                        $file_size  = $_FILES['doc']['size'][$key];
                                        $file_tmp   = $_FILES['doc']['tmp_name'][$key];
                                        $file_type  = $_FILES['doc']['type'][$key];
                                        // dd(($request->file('doc')[$key]));
                                        $file = $request->file('doc')[$key];
                                        if ($file_tmp  != ""){

                                            //$query_exec_data = get_upload_sequence($id_project_new, $id_product_new, $id_part_new, $id_doc_part_new[$key]);
                                            /*
                                            $query_exec_data = get_upload_sequence($id_project_new, $id_product_new, $id_part_new);
                                            $upload_count   = mysqli_fetch_assoc($query_exec_data);
                                            $upload_count_n = $upload_count['upload_n'];
                                            $upload_n = intval($upload_count_n) + 1;
                                            */

                                            $query_exec_data2 = PM::get_doc_ver($id_project_new, $id_product_new, $id_part_new, $id_doc_part_new[$key]);
                                            $version_count   = $query_exec_data2;
                                            $version_count_n = $version_count->version_n;
                                            $version_n      = intval($version_count_n) + 1;
                                            $uploader_id = auth()->user()->id_user;

                                            $query = PM::get_group_all_join_proj_prod_part_data($id_project_new, $id_product_new, $id_part_new, 'P');
                                            $rows = $query;
                                            $nm_product_file = $rows[0]['nm_product'];
                                            $nm_part_file    = $rows[0]['nm_part'];

                                            $temp = explode(".", $_FILES["doc"]["name"][$key]);
                                            $newfilename = \Str::snake($nm_product_file."_ver".$version_n). '.' . end($temp);

                                            $newfilename = str_replace(',', '', $newfilename);

                                            /*
                                                nama product pasti nama file di array
                                                sehingga nama nya akan selalu restart ke product 1
                                                begitu juga nama part
                                                pasti akan selalu restart ke part A
                                            */
                                            $path = public_path("DATA/$id_project_new/$id_vendor/" );
                                            // dd($path);
                                            if (!file_exists($path)) {
                                                mkdir($path, 0777, true);
                                            }
                                            if ( $file->move($path,$newfilename)){
                                                $upload_path    =$path;
                                                $upload_n       = intval($upload_count_n) + 1;
                                                $version_n      = intval($version_count_n) + 1;
                                            } else {

                                                $upload_path    ="";
                                                $upload_n       = "";
                                                $version_n      = "";
                                            }
                                             PM::update_vendor_doc_upload($id_project_new, $id_product_new, $id_part_new, $id_doc_part_new[$key], $newfilename, $upload_n, $version_n, $uploader_id, $upload_path, $id_vendor);
                                        } else{
                                          
                                        }
                                        
                                            // dd("A");
                                           

                                            //echo "<script> alert('Upload success'); </script>";

                                    } //if ($file_tmp  != "")
                            return redirect()->back()->with(['message_success' => 'Upload Success']);

                           
                        }
                  
                    }
                
           // dd($row_data_count);

  
        // if($upld_count == 0){ //check doc choosen

        //   return "RR";

        // } else {
        //     $data = 
           
        //         ProjectDocAssign::create(['id_assign' => Numbering::autoIncrement(new \App\Models\ProjectDocAssign(),"id_assign"),
        //                                   'id_product' => $aj->id_product,
        //                                     'id_part' => $aj->id_part,
        //                                     'id_doc_part'  => $aj->id_doc_part,
        //                                     'check_params'  => $aj->check_params
        //                                 ]);
        //     }

        // }

        }


    public function uploadProjectDoc(Request $request)
    {
        $prj = Project::where('status','A')->where('assigned','Y')->get();
        
        $ret = ['project' => $prj];
       if(!empty($request->id_project)){
        // DB::connection('mongodb')->enableQueryLog();
        $pfp = ProductForProject::where('id_project',$request->id_project)->get();
        // dd(DB::connection('mongodb')->getQueryLog());
        // dd($pfp);
        $wherein=[];
        foreach($pfp as $pfp)
        {
            $wherein[]=$pfp->id_product;
        }
        $prod = PartForProduct::whereIn('id_product',$wherein)->get();
        $ret['prodforProject'] = $prod;
        if(!empty($request->prod_part)){
            $exp =  explode("_", $request->prod_part);
            $id_product = $exp[0];
            $id_part    = $exp[1];
            $ret['id_product'] = $id_product;
            $ret['id_part'] = $id_part;
            $ret['docpart'] = DocPart::get();
        }
       }


        return view('project_management/upload_project_doc/index')->with($ret);
    }  

    public function DocCheckListModify(Request $request)
    {
    
       $doc = DocPart::where('status','A')->where('assigned','Y')->get();
       $ret = ['doc' => $doc];
       if(!empty($request->id_doc)){
        $doc_select = DocPart::where('status','A')->where('assigned','Y')->where('id_doc_part',$request->id_doc)->first();
        $ret['doc_detail'] = $doc_select;
       }
        return view('project_management/list_check_master/modify_doc_params')->with($ret);
    }  

    public function DocMasterAssign(Request $request)
    {
    
       $doc = DocPart::where('status','A')->where('assigned','N')->get();
       $ret = ['doc' => $doc];
       if(!empty($request->id_doc)){
        $doc_select = DocPart::where('status','A')->where('assigned','N')->where('id_doc_part',$request->id_doc)->first();
        $ret['doc_detail'] = $doc_select;
       }
        return view('project_management/list_check_master/assign_doc')->with($ret);
    } 


    public function partMaster()
    {
        $prj = Part::where('status','A')->where('assigned','N')->get();
        $doc = DocPart::where('status','A')->where('assigned','Y')->get();
        return view('project_management/part_master/index')->with(['parts' => $prj,'doc' => $doc]);
    }

    public function projectAssignMaster()
    {
      
        return view('project_management/project_master/project_assignment');
    } 

    public function partAssignMaster()
    {
      
        return view('project_management/part_master/part_assigment');
    } 

    public function productAssignMaster()
    {
      
        return view('project_management/product_master/product_assigment');
    }  

    public function editProject($id)
    {
        $prj = Project::where('id_project',$id)->firstOrFail();
        return view('project_management/project_master/edit')->with(['project' => $prj]);
    }   

    public function DocCheckListModifyEdit($id)
    {

        $prj = DocCheckList::where('id_check',intval($id))->firstOrFail();


        return view('project_management/list_check_master/edit_checklist')->with(['checklist' => $prj]);
    }
    public function DocMasterEdit($id)
    {

        $prj = DocPart::where('id_doc_part',$id)->firstOrFail();


        return view('project_management/list_check_master/edit_doc')->with(['doc' => $prj]);
    } 

    public function editPart($id)
    {
        $part = Part::where('id_part',$id)->firstOrFail();
        return view('project_management/part_master/edit')->with(['part' => $part]);
    }

    public function editProduct($id)
    {
        $prod = Product::where('id_product',$id)->firstOrFail();
        return view('project_management/product_master/edit')->with(['product' => $prod]);
    }
    public function projectAdd(Request $request)
    {
        $prj = Project::create($this->params($request));
        if($prj)
        {
                return response()->json([
                    'type' => 'success',
                    'message' => 'Berhasil Menambahkan Project',
                    'data' =>  $prj,
                ], 200);

        } 

         return response()->json([
                    'type' => 'error',
                    'message' => 'Gagal Menambahkan Project',
                    'data' =>  null,
                ], 200);
    } 


    public function docAdd(Request $request)
    {
        $prj = DocPart::create($this->paramsDocPart($request));
        if($prj)
        {
                return response()->json([
                    'type' => 'success',
                    'message' => 'Berhasil Menambahkan Dokumen',
                    'data' =>  $prj,
                ], 200);

        } 

         return response()->json([
                    'type' => 'error',
                    'message' => 'Gagal Menambahkan Dokumen',
                    'data' =>  null,
                ], 200);
    }
    public function productAdd(Request $request)
    {
        $prj = Product::create($this->paramsProduct($request));
        if($prj)
        {
                return response()->json([
                    'type' => 'success',
                    'message' => 'Berhasil Menambahkan Produk',
                    'data' =>  $prj,
                ], 200);

        } 

         return response()->json([
                    'type' => 'error',
                    'message' => 'Gagal Menambahkan Produk',
                    'data' =>  null,
                ], 200);
    }
    public function DocCheckListModifyAdd(Request $request)
    {
        foreach($request->check_params as $pd):
            $prj = DocCheckList::create([
                        'id_check' => Numbering::autoIncrement(new \App\Models\DocCheckList(),"id_check"),
                        'id_doc_part' => $request->id_doc_part,
                        'modify_date' => date('Y-m-d'),
                        'id_user' => auth()->user()->id_user,
                        'check_params' => $pd,
                    ]);
        endforeach;
        if($prj)
        {
            DocPart::where('id_doc_part', $request->id_doc_part)->update(['assigned' => 'Y']);
                 return redirect()->back()->with(['message_success' => 'Berhasil menambah additional parameter']);

        } 

         return redirect()->back()->with(['message_fail' => 'gagal menambah data.']);
    }

    public function DocCheckListModifyUpdate(Request $request)
    {
       
            $prj = DocCheckList::where('id_check',intval($request->id_check))->update([
                        'modify_date' => date('Y-m-d'),
                        'id_user' => auth()->user()->id_user,
                        'check_params' => $request->check_params,
                    ]);
     
        if($prj)
        {         
                 $checklist = DocCheckList::where('id_check',intval($request->id_check))->first();
                 return redirect()->route('project.management.master.listcheck',['id_doc' => $checklist->docParts->id_doc_part])->with(['message_success' => 'Berhasil mengubah additional parameter']);

        } 

         return redirect()->back()->with(['message_fail' => 'gagal mengubah data.']);
    }

    public function partAdd(Request $request)
    {
        $prj = Part::create($this->paramsPart($request));
        if($prj)
        {
                return response()->json([
                    'type' => 'success',
                    'message' => 'Berhasil Menambahkan Part',
                    'data' =>  $prj,
                ], 200);

        } 

         return response()->json([
                    'type' => 'error',
                    'message' => 'Gagal Menambahkan Part',
                    'data' =>  null,
                ], 200);
    }

    public function projectAssign(Request $request)
    {   
        // UPDATE project SET assigned='Y', modify_date='".date("Y-m-d")."', id_user='$id_user' WHERE id_project='$id_project'"

        foreach($request->id_product as $pd):
           
                $prj = ProductForProject::create([
                        'id_assign' => Numbering::autoIncrement(new \App\Models\ProductForProject(),"id_assign"),
                        'id_project' => $request->id_project,
                        'id_product' => $pd,
                        'modify_date' => date('Y-m-d'),
                        'id_user' => auth()->user()->id_user,
                    ]);
         
        endforeach;

        if($prj)
        {
                Project::where('id_project',$request->id_project)->update(['assigned' => 'Y','modify_date' => date('Y-m-d')]);
                return response()->json([
                    'type' => 'success',
                    'message' => 'Success assign project to product',
                    'data' =>  $prj,
                ], 200);

        } 

         return response()->json([
                    'type' => 'error',
                    'message' => 'Success assign project to product',
                    'data' =>  null,
                ], 200);
    }

    public function productAssign(Request $request)
    {   
        // UPDATE project SET assigned='Y', modify_date='".date("Y-m-d")."', id_user='$id_user' WHERE id_project='$id_project'"

        foreach($request->id_part as $pd):
           
                $prj = PartForProduct::create([
                        'id_assign' => Numbering::autoIncrement(new \App\Models\PartForProduct(),"id_assign"),
                        'id_product' => $request->id_product,
                        'id_part' => $pd,
                        'modify_date' => date('Y-m-d'),
                        'id_user' => auth()->user()->id_user,
                    ]);
         
        endforeach;

        if($prj)
        {
                Product::where('id_product',$request->id_product)->update(['assigned' => 'Y','modify_date' => date('Y-m-d')]);
                return response()->json([
                    'type' => 'success',
                    'message' => 'Success assign part to product',
                    'data' =>  $prj,
                ], 200);

        } 

         return response()->json([
                    'type' => 'error',
                    'message' => 'Success assign part to product',
                    'data' =>  null,
                ], 200);
    }
    public function partAssign(Request $request)
    {   
        // UPDATE project SET assigned='Y', modify_date='".date("Y-m-d")."', id_user='$id_user' WHERE id_project='$id_project'"


        foreach($request->id_doc_assign as $pd):
           
                $prj = DocForPart::create([
                        'id_assign' => Numbering::autoIncrement(new \App\Models\DocForPart(),"id_assign"),
                        'id_part' => $request->id_part,
                        'id_doc_assign' => $pd,
                        'modify_date' => date('Y-m-d'),
                        'id_user' => auth()->user()->id_user,
                    ]);
         
        endforeach;

        if($prj)
        {
                Part::where('id_part',$request->id_part)->update(['assigned' => 'Y','modify_date' => date('Y-m-d')]);
                return response()->json([
                    'type' => 'success',
                    'message' => 'Success assign part to product',
                    'data' =>  $prj,
                ], 200);

        } 

         return response()->json([
                    'type' => 'error',
                    'message' => 'Success assign part to product',
                    'data' =>  null,
                ], 200);
    }

    public function updateProduct(Request $request)
    {
        $prj = Product::where('id_product',$request->id_product)->update($this->paramsProduct($request,true));
        if($prj)
        {
                return redirect()->route('project.management.master.product')->with(['message_success' => 'Berhasil mengubah data.']);

        } 

         return redirect()->route('project.management.master.product')->with(['message_fail' => 'Gagal mengubah data.']);
    }  


    public function updateDocPart(Request $request)
    {
        $prj = DocPart::where('id_doc_part',$request->id_doc)->update($this->paramsDocPart($request,true));
        if($prj)
        {
                return redirect()->route('project.management.master.listcheck.modify.doc.docmaster')->with(['message_success' => 'Berhasil mengubah data.']);

        } 

         return redirect()->route('project.management.master.listcheck.modify.doc.docmaster')->with(['message_fail' => 'Gagal mengubah data.']);
    }  

    public function updatePart(Request $request)
    {
        $prj = Part::where('id_part',$request->id_part)->update($this->paramsPart($request,true));
        if($prj)
        {
                return redirect()->route('project.management.master.part')->with(['message_success' => 'Berhasil mengubah data.']);

        } 

         return redirect()->route('project.management.master.part')->with(['message_fail' => 'Gagal mengubah data.']);
    }  

    public function updateProject(Request $request)
    {
        $prj = Project::where('id_project',$request->id_project)->update($this->params($request,true));
        if($prj)
        {
                return redirect()->route('project.management.master')->with(['message_success' => 'Berhasil mengubah data.']);

        } 

         return redirect()->route('project.management.master')->with(['message_fail' => 'Gagal mengubah data.']);
    }
    public function deletePart($id)
    {
        $prj = Part::where('id_part',$id)->delete();
        if($prj)
        {
                return redirect()->route('project.management.master.part')->with(['message_success' => 'Berhasil menghapus data.']);

        } 

         return redirect()->route('project.management.master.part')->with(['message_fail' => 'Gagal menghapus data.']);
    }
    public function deleteProject($id)
    {
        $prj = Project::where('id_project',$id)->delete();
        if($prj)
        {
                return redirect()->route('project.management.master')->with(['message_success' => 'Berhasil menghapus data.']);

        } 

         return redirect()->route('project.management.master')->with(['message_fail' => 'Gagal menghapus data.']);
    }
    public function deleteProduct($id)
    {
        $prj = Product::where('id_product',$id)->delete();
        if($prj)
        {
                return redirect()->route('project.management.master.product')->with(['message_success' => 'Berhasil menghapus data.']);

        } 

         return redirect()->route('project.management.master.product')->with(['message_fail' => 'Gagal menghapus data.']);
    }
////////////DATATABLES/////////////////
     public function getPartMaster()
    {
        $data = Part::get();
        // session(['number' => 1]);
        return \DataTables::of($data)
                ->editColumn('part_num', function ($data) {
                                
                               return @$data->part_num;
                            })

                ->editColumn('nm_part', function ($data) {
                                
                               return @$data->nm_part;
                            })
                ->editColumn('last_change_date', function ($data) {
                                
                                return date('d.m.y',strtotime($data->modify_date));
                            })
                
               
                ->editColumn('last_change_by', function ($data) {
                                
                               return @$data->users->nm_user;
                            })
               
                ->editColumn('part_ass', function ($data) {
                        if ($data->assigned == 'Y'){
                            $assigned = "<small class='badge bg-success'> Assigned</small>";
                        }elseif ($data->assigned == 'N') {
                            $assigned = "<small class='badge bg-warning'> Not-Assigned</small>";
                        }

                        return $assigned;
                            })
                ->editColumn('status', function ($data) {
                         if ($data->status == "A"){
                            $status = "<small class='badge bg-success'> Active</small>";
                        }elseif ($data->status == "N") {
                            $status = "<small class='badge bg-danger'> Nonactive</small>";
                        }

                        return $status;
                            })
                ->editColumn('action', function ($data) {
                                return view('project_management/part_master/buttons')->with(['data' => $data]);
                        
                            })
                 
                ->editColumn('status', function ($data) {
                                
                               return  "<small class='badge bg-success'> Active</small>";
                            }) 
                ->rawColumns(['status','part_ass','action'])
                ->addIndexColumn()
                            ->make(true);
    }  

      public function getProductMaster()
    {
        $data = Product::get();
        // session(['number' => 1]);
        return \DataTables::of($data)
                ->editColumn('prod_num', function ($data) {
                                
                               return @$data->prod_num;
                            })

                ->editColumn('nm_product', function ($data) {
                                
                               return @$data->nm_product;
                            })
                ->editColumn('last_change_date', function ($data) {
                                
                                return date('d.m.y',strtotime($data->modify_date));
                            })
                
               
                ->editColumn('last_change_by', function ($data) {
                                
                               return @$data->users->nm_user;
                            })
               
                ->editColumn('part_ass', function ($data) {
                        if ($data->assigned == 'Y'){
                            $assigned = "<small class='badge bg-success'> Assigned</small>";
                        }elseif ($data->assigned == 'N') {
                            $assigned = "<small class='badge bg-warning'> Not-Assigned</small>";
                        }

                        return $assigned;
                            })
                ->editColumn('status', function ($data) {
                         if ($data->status == "A"){
                            $status = "<small class='badge bg-success'> Active</small>";
                        }elseif ($data->status == "N") {
                            $status = "<small class='badge bg-danger'> Nonactive</small>";
                        }

                        return $status;
                            })
                ->editColumn('action', function ($data) {
                                return view('project_management/product_master/buttons')->with(['data' => $data]);
                        
                            })
                 
                ->editColumn('status', function ($data) {
                                
                               return  "<small class='badge bg-success'> Active</small>";
                            }) 
                ->rawColumns(['status','part_ass','action'])
                ->addIndexColumn()
                            ->make(true);
    }  

    public function getProjectAssignMaster()
    {
        $data = ProductForProject::get();

        return \DataTables::of($data)
                ->editColumn('id_project', function ($data) {
                                
                               return @$data->project->id_project;
                            })  
                ->editColumn('nm_project', function ($data) {
                                
                               return @$data->project->nm_project;
                            })  
                ->editColumn('nm_part', function ($data) {
                                $part = PartForProduct::where('id_product',$data->id_product)->first();
                               return @$part->part->nm_part;
                            })
                ->editColumn('nm_product', function ($data) {
                                
                               return @$data->product->nm_product;
                            })
                ->editColumn('last_change_by', function ($data) {
                                
                               return @$data->users->nm_user;
                            })
                ->editColumn('last_change_date', function ($data) {
                                
                               return date('d.m.y',strtotime($data->modify_date));
                            })

                ->editColumn('number', function ($data) {
                                
                                  return 1;
                            }) 
                ->editColumn('status', function ($data) {
                                
                               return  "<small class='badge bg-success'> Active</small>";
                            }) 
                ->rawColumns(['status'])
                 ->addIndexColumn()
                            ->make(true);
    }

    public function getProductAssignMaster()
    {
        $data = PartForProduct::get();

        return \DataTables::of($data)
                ->editColumn('id_product', function ($data) {
                                
                               return @$data->product->id_product;
                            })  
                ->editColumn('nm_product', function ($data) {
                                
                               return @$data->product->nm_product;
                            })  
                ->editColumn('nm_part', function ($data) {
                                ;
                               return @$data->part->nm_part;
                            })
                ->editColumn('nm_product', function ($data) {
                                
                               return @$data->product->nm_product;
                            })
                ->editColumn('last_change_by', function ($data) {
                                
                               return @$data->users->nm_user;
                            })
                ->editColumn('last_change_date', function ($data) {
                                
                               return date('d.m.y',strtotime($data->modify_date));
                            })

                ->editColumn('number', function ($data) {
                                
                                  return 1;
                            }) 
                ->editColumn('status', function ($data) {
                                
                               return  "<small class='badge bg-success'> Active</small>";
                            }) 
                ->rawColumns(['status'])
                 ->addIndexColumn()
                            ->make(true);
    } 
    public function getMasterCheckList()
    {
        $data = DocCheckList::get();

        return \DataTables::of($data)
                ->editColumn('id_document', function ($data) {
                                
                               return @$data->docParts->id_doc_part;
                            })  
                ->editColumn('nm_doc', function ($data) {
                                
                               return @$data->docParts->nm_doc_part;
                            })  
                ->editColumn('check_params', function ($data) {
                                ;
                               return @$data->check_params;
                            })
                ->editColumn('last_change_by', function ($data) {
                                
                               return @$data->users->nm_user;
                            })
                ->editColumn('last_change_date', function ($data) {
                                
                               return date('d.m.y',strtotime($data->modify_date));
                            })
                ->editColumn('action', function ($data) {
                                
                               return  view('project_management/list_check_master/buttons')->with(['data' => $data]);
                            }) 
                ->editColumn('number', function ($data) {
                                
                                  return 1;
                            })
                ->rawColumns(['status'])
                 ->addIndexColumn()
                            ->make(true);
    }
    public function getDocMaster()
    {
        $data = DocPart::get();
                
        return \DataTables::of($data)
                ->editColumn('id_doc', function ($data) {
                                
                               return @$data->id_doc_part;
                            })  
                ->editColumn('nm_doc', function ($data) {
                                
                               return @$data->nm_doc_part;
                            }) 
                ->editColumn('last_change_by', function ($data) {
                                
                               return @$data->users->nm_user;
                            })
                ->editColumn('last_change_date', function ($data) {
                                
                               return date('d.m.y',strtotime($data->modify_date));
                            })
                ->editColumn('doc_type', function ($data) {
                             if ($data->doc_type == "V") {
                                $doc_type = "Doc for Vendor";
                            } elseif($data->doc_type == "P"){
                                $doc_type = "Doc for Procurement";
                            }
                             return $doc_type;  
                            })
                ->editColumn('required_stat', function ($data) {
                            if ($data->doc_required == "M") {
                                $doc_required = "<small class='badge bg-success'> Mandatory</small>" ;
                            } elseif ($data->doc_required == "Y")  {
                                $doc_required = "<small class='badge bg-primary'> Required</small>" ;
                            } elseif ($data->doc_required == "N")  {
                                $doc_required = "<small class='badge bg-warning'> Not-required</small>" ;
                            }
                                return $doc_required;
                            })
                ->editColumn('check_stat', function ($data) {
                              if ($data->assigned == 'Y'){
                                 $assigned = "<small class='badge bg-success'> Assigned</small>";
                            }elseif ($data->assigned == 'N') {
                                $assigned = "<small class='badge bg-warning'> Not-Assigned</small>";
                            }  
                              return $assigned;         
                            })
                ->editColumn('action', function ($data) {
                                
                               return  view('project_management/list_check_master/button_doc_master')->with(['data' => $data]);
                            }) 
                ->editColumn('number', function ($data) {
                                
                                  return 1;
                            })
                ->rawColumns(['status','check_stat','doc_type','required_stat'])
                            ->make(true);
    }

    public function getCheckListModify(Request $request)
    {
        $data = DocCheckList::where('id_doc_part',$request->id_doc_part)->get();

        return \DataTables::of($data)
               
                ->editColumn('check_params', function ($data) {
                                ;
                               return @$data->check_params;
                            })
                ->editColumn('last_change_by', function ($data) {
                                
                               return @$data->users->nm_user;
                            })
                ->editColumn('last_change_date', function ($data) {
                                
                               return date('d.m.y',strtotime($data->modify_date));
                            })
                ->editColumn('action', function ($data) {
                                
                               return  view('project_management/list_check_master/button_checklist')->with(['data' => $data]);
                            }) 
                ->editColumn('number', function ($data) {
                                
                                  return 1;
                            })
                ->rawColumns(['status'])
                 ->addIndexColumn()
                            ->make(true);
    }
    public function getPartAssign()
    {
        $data = DocForPart::get();

        return \DataTables::of($data)
                ->editColumn('id_doc', function ($data) {
                                
                               return @$data->docparts->id_doc_part;
                            })  
                ->editColumn('nm_doc', function ($data) {
                                
                               return @$data->docparts->nm_doc_part;
                            })  
                ->editColumn('nm_part', function ($data) {
                                ;
                               return @$data->parts->nm_part;
                            })
                ->editColumn('last_change_by', function ($data) {
                                
                               return @$data->users->nm_user;
                            })
                ->editColumn('last_change_date', function ($data) {
                                
                               return date('d.m.y',strtotime($data->modify_date));
                            })

                ->editColumn('number', function ($data) {
                                
                                  return 1;
                            }) 
                ->editColumn('status', function ($data) {
                                
                               return  "<small class='badge bg-success'> Active</small>";
                            }) 
                ->rawColumns(['status'])
                 ->addIndexColumn()
                            ->make(true);
    }
    public function getProjectMaster()
    {
        $data = Project::get();

        return \DataTables::of($data)
                ->editColumn('last_change_by', function ($data) {
                                
                               return @$data->users->nm_user;
                            })  
                ->editColumn('modify_date', function ($data) {
                                
                               return date('d.m.y',strtotime($data->modify_date));
                            }) 
                ->editColumn('prod_assc', function ($data) {
                            if ($data->assigned == 'Y'){
                                $assigned = "<small class='badge bg-success'> Assigned</small>";
                            } elseif ($data->assigned == 'N') {
                                $assigned = "<small class='badge bg-warning'> Not-Assigned</small>";
                            }

                            if ($data->status == "A"){
                                $status = "<small class='badge bg-success'> Active</small>";
                            } elseif ($data->status == "N") {
                                $status = "<small class='badge bg-danger'> Non-active</small>";
                            }
 
                               return   $assigned;
                            }) 
                ->editColumn('action', function ($data) {
                                
                               return  view('project_management/project_master/buttons')->with(['data' => $data]);
                            }) 
                ->editColumn('number', function ($data) {
                                
                               return 1;
                            }) 
                ->rawColumns(['prod_assc','action'])
                 ->addIndexColumn()
                            ->make(true);
    }

    private function params($request,$update=false)
    {
        $params = [
                    'proj_num' => $request->proj_num,
                    'nm_project' => $request->nm_project,
                    'modify_date' => date('Y-m-d'),
                    'id_user' => auth()->user()->id_user,
                    'status' => "A",
                ];
        if(!$update)
        {
            $params['assigned'] = "N";
            $params['id_project'] = $request->id_project;
        }
        return $params;
    }

    private function paramsDocPart($request,$update=false)
    {
        $params = [
                    'nm_doc_part' => $request->nm_doc,
                    'modify_date' => date('Y-m-d'),
                    'id_user' => auth()->user()->id_user,
                    'status' => "A",
                    'doc_required' => $request->doc_required,
                    'doc_type' => $request->doc_type,
                ];

        if(!$update)
        {
            $params['assigned'] = "N";
            $params['id_doc_part'] = $request->id_doc;
        }
        return $params;
    } 

    private function paramsProduct($request,$update=false)
    {
        $params = [
                    'prod_num' => $request->prod_num,
                    'nm_product' => $request->nm_product,
                    'modify_date' => date('Y-m-d'),
                    'id_user' => auth()->user()->id_user,
                    'status' => "A",
                ];
        if(!$update)
        {
            $params['assigned'] = "N";
            $params['id_product'] = $request->id_product;
        }
        return $params;
    } 


    private function paramsPart($request,$update=false)
    {
        $params = [
                    'part_num' => $request->part_num,
                    'nm_part' => $request->nm_part,
                    'modify_date' => date('Y-m-d'),
                    'id_user' => auth()->user()->id_user,
                    'status' => "A",
                ];
        if(!$update)
        {
            $params['assigned'] = "N";
            $params['id_part'] = $request->id_part;
        }
        return $params;
    } 



}
