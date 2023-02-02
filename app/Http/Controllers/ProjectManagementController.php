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
            $pfp = Vendor::get();
            $prod = Vendor::get();
        
            $ret['vendor'] = $pfp;
        }
        return view('project_management/assign_doc_vendor/index')->with($ret);
    }  

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

   
    public function uploadDocAct(Request $request)
    {
        $id_project_new     = $request->id_project;
        $dest_path          = "DATA/$id_project_new";
        $id_product_new     = $request->id_product;
        $id_part_new        = $request->id_part;
        $id_doc_part_new    = $request->doc_arr;

        $upload_count = PM::get_upload_sequence($id_project_new, $id_product_new, $id_part_new);
        $upload_n = intval($upload_count) + 1;

        $upld_count = count($request->doc);

        if($upld_count == 0){ //check doc choosen

          return "RR";

        } else {
            $data = (object)PM::allJoin($request->id_project,"P");
            foreach($data as $aj)
            {
                ProjectDocAssign::create(['id_assign' => Numbering::autoIncrement(new \App\Models\ProjectDocAssign(),"id_assign"),
                                          'id_product' => $aj->id_product,
                                            'id_part' => $aj->id_part,
                                            'id_doc_part'  => $aj->id_doc_part,
                                            'check_params'  => $aj->check_params
                                        ]);
            }

        }

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
