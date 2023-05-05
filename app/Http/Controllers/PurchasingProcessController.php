<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchasingProcess;
use Carbon\Carbon;
use App\Models\Vendor;
use App\Models\MasterUser;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportPo;
use Storage;

class PurchasingProcessController extends Controller
{
    public function upload()
    {
        return view('purchasing_process/upload');
    }

    public function index()
    {
        $vendor = Vendor::all();
        return view('purchasing_process/index', ['list_vendor' => $vendor]);
    }

    public function getListPo(Request $request)
    {
        if($request->search == true)
        {
             $vendor_list =array_filter(preg_split('/\r\n|\r|\n/',$request->vendor_list));
            $q = PurchasingProcess::where(function($query) use ($request,$vendor_list){
                if (!empty($request->po_num)) {
                   return $query->where('po_num', 'like', "%" . $request->po_num . "%");
                }

                if (!empty($request->date_from) && !empty($request->date_to)) {
                    return $query->whereBetween('doc_date', [Carbon::parse($request->date_from.' 00:00:00'), Carbon::parse($request->date_to.' 23:59:59')]);
                }

                if (!empty($vendor_list)) {
                    return $query->whereIn('id_vendor', $vendor_list);
                }
            });
             // AND $request->vendor_select != "Choose Vendor"

            if((count($vendor_list)>0) || ($request->vendor_select != "Choose Vendor"))
            {
              if ((count($vendor_list)>0)) {
                    $q->whereIn('id_vendor', $vendor_list);
                } elseif((count($vendor_list)==0)){
                   $q->whereIn('id_vendor',[$request->vendor_select]);
                }
            }
            $data = $q->where('id_vendor','!=','')->get();

        }
       
        return \DataTables::of($data)
        ->editColumn('number', function($data){
            return 1;
        })
        ->editColumn('rel_stat', function($data){
             if($data->relind == '1'){
            $rel_stat = "<small><i class='fa fa-check-circle' style='color: green;' 
                                data-toggle=tooltip' data-placement='left' title='Released'>
                                </i>
                        </small>";
        } else {
            $rel_stat = "<small><i class='fa fa-exclamation-circle' style='color: red;'
                                data-toggle=tooltip' data-placement='left' title='Not Released'>
                                </i>
                        </small>";
        }

       

      
            return $rel_stat;
        })
        ->editColumn('mail_stat', function($data){
          
             if($data->sent != '0000-00-00 00:00:00'){
            $mail_stat = "<small><i class='fa fa-check-circle' style='color: green;'
                                data-toggle=tooltip' data-placement='left' title='Sent'>
                                </i>
                        </small>";
        } else {
            $mail_stat = "<small><i class='fa fa-exclamation-circle' style='color: red;'
                                data-toggle=tooltip' data-placement='left' title='Not Sent'>
                                </i>
                        </small>";
        }
        return $mail_stat;
        })
        ->editColumn('file_exist', function($data){
           $filenm = $data->filenm;
            if ($filenm != "-" && $filenm != "" ) {
            //activate
            $file_exist = "<small><i class='fa fa-check-circle' style='color: green;'
                                    data-toggle='tooltip' data-placement='left' title='Exist'>
                                  </i>
                          </small>";
            } else {
                $file_exist = "<small><i class='fa fa-exclamation-circle' style='color: red;'
                                        data-toggle='tooltip' data-placement='left' title='Not exist'>
                                    </i>
                               </small>";
                
            }
             return $file_exist;

        })
        ->editColumn('download_stat', function($data){
             if($data->downloaded != '0000-00-00 00:00:00'){
            $dwld_stat = "<small><i class='fa fa-check-circle' style='color: green;'
                                    data-toggle=tooltip' data-placement='left' title='Downloaded'>
                                </i>
                          </small>";
        } else {
            $dwld_stat = "<small><i class='fa fa-exclamation-circle' style='color: red;'
                                    data-toggle=tooltip' data-placement='left' title='Not Downloaded'>
                                 </i>
                        </small>";
           
        }
         return $dwld_stat;
        })
        ->editColumn('upload_date', function($data){
            return @$data->last_change;
        })
        ->editColumn('po_amount', function($data){
           
            $po_value = number_format($data->po_val, 2, '.', ',');
            $po_val   = "<p class='text-right' >".$po_value."</p>";

             return @$po_val;
        })
        ->editColumn('total_amount', function($data){
            

            $total_value = number_format($data->tot_va, 2, '.', ',');
            $tot_val   = "<p class='text-right' >".$total_value."</p>";

            return @$tot_val ;
        })
        ->editColumn('upload_group', function($data){
            return @$data->batch;
        })
        ->editColumn('nm_vendor', function($data){
            return @$data->vendors->nm_vendor;
        })->editColumn('vend_email', function($data){
            if(!empty($data->vendors)){
                $v = @$data->vendors->vend_email;
            } else{
                $v="";
            }
            $get = MasterUser::where('foreign_id', $data->id_vendor)->first();
            if(@$get->status_user == "A")
            {
                $s = " <i title='User Active' class='fas fa-check-circle text-success'></i> ";
            } else{
                $s=" <i title='User Not active' class='fas fa-exclamation-circle text-warning'></i> ";
            }
            return $v.($v!=""?$s:"");
        })
        ->editColumn('doc_date', function ($data) {                    
            return date('d.m.Y',strtotime($data->doc_date));
        })
        // ->whereBetween('doc_date', [Carbon::parse($data->doc_date.' 00:00:00'), Carbon::parse($data->doc_date.' 23:59:59')])
        // ->where('id_vendor', $data->id_vendor)
        ->rawColumns(['action','vend_email','rel_stat','mail_stat','file_exist','download_stat','po_amount','total_amount'])->make(true);
                // ->editColumn('last_change_by', function ($data) {
                                
                //                return @$data->users->nm_user;
                //             })  
                // ->editColumn('modify_date', function ($data) {
                                
                //                return date('d.m.y',strtotime($data->modify_date));
                //             }) 
                // ->editColumn('prod_assc', function ($data) {
                //             if ($data->assigned == 'Y'){
                //                 $assigned = "<small class='badge bg-success'> Assigned</small>";
                //             } elseif ($data->assigned == 'N') {
                //                 $assigned = "<small class='badge bg-warning'> Not-Assigned</small>";
                //             }

                //             if ($data->status == "A"){
                //                 $status = "<small class='badge bg-success'> Active</small>";
                //             } elseif ($data->status == "N") {
                //                 $status = "<small class='badge bg-danger'> Non-active</small>";
                //             }
 
                //                return   $assigned;
                //             }) 
                // ->editColumn('action', function ($data) {
                                
                //                return  view('project_management/project_master/buttons')->with(['data' => $data]);
                //             }) 
                // ->editColumn('number', function ($data) {
                                
                //                return 1;
                //             }) 
                // ->rawColumns(['prod_assc','action'])
                             
    }

    private function params($request,$update=false)
    {
        $params = [
                    'doc_date' => date('Y-m-d'),
                ];
        // if($update)
        // {
        //     $params['id_project'] = $request->id_project;
        // }
        return $params;
    }

    public function download()
    {
        $vendor = Vendor::all();
        return view('purchasing_process/download', ['list_vendor' => $vendor]);
    }

    public function getDownloadListPo(Request $request)
    {
         if($request->search)
        {
             $vendor_list =array_filter(preg_split('/\r\n|\r|\n/',$request->vendor_list));
            $q = PurchasingProcess::where(function($query) use ($request,$vendor_list){
                if (!empty($request->po_num)) {
                   return $query->where('po_num', 'like', "%" . $request->po_num . "%");
                }

                if (!empty($request->date_from) && !empty($request->date_to)) {
                    return $query->whereBetween('doc_date', [Carbon::parse($request->date_from.' 00:00:00'), Carbon::parse($request->date_to.' 23:59:59')]);
                }

                if (!empty($vendor_list)) {
                    return $query->whereIn('id_vendor', $vendor_list);
                }
            });
             // AND $request->vendor_select != "Choose Vendor"

            if((count($vendor_list)>0) || ($request->vendor_select != "Choose Vendor"))
            {
              if ((count($vendor_list)>0)) {
                    $q->whereIn('id_vendor', $vendor_list);
                } elseif((count($vendor_list)==0)){
                   $q->whereIn('id_vendor',[$request->vendor_select]);
                }
            }
            $data = $q->where('id_vendor','!=','')->get();

        } else{
            $data = [];
        }

        return \DataTables::of($data)

        ->editColumn('rel_stat', function($data){
             if($data->relind == '1'){
            $rel_stat = "<small><i class='fa fa-check-circle' style='color: green;' 
                                data-toggle=tooltip' data-placement='left' title='Released'>
                                </i>
                        </small>";
        } else {
            $rel_stat = "<small><i class='fa fa-exclamation-circle' style='color: red;'
                                data-toggle=tooltip' data-placement='left' title='Not Released'>
                                </i>
                        </small>";
        }

       

      
            return $rel_stat;
        })
        ->editColumn('mail_stat', function($data){
          
             if($data->sent != '0000-00-00 00:00:00'){
            $mail_stat = "<small><i class='fa fa-check-circle' style='color: green;'
                                data-toggle=tooltip' data-placement='left' title='Sent'>
                                </i>
                        </small>";
        } else {
            $mail_stat = "<small><i class='fa fa-exclamation-circle' style='color: red;'
                                data-toggle=tooltip' data-placement='left' title='Not Sent'>
                                </i>
                        </small>";
        }
        return $mail_stat;
        })
        ->editColumn('file_exist', function($data){
           $filenm = $data->filenm;
            if ($filenm != "-" && $filenm != "" ) {
            //activate
            $file_exist = "<small><i class='fa fa-check-circle' style='color: green;'
                                    data-toggle='tooltip' data-placement='left' title='Exist'>
                                  </i>
                          </small>";
            } else {
                $file_exist = "<small><i class='fa fa-exclamation-circle' style='color: red;'
                                        data-toggle='tooltip' data-placement='left' title='Not exist'>
                                    </i>
                               </small>";
                
            }
             return $file_exist;

        })
        ->editColumn('download_stat', function($data){
             if($data->downloaded != '0000-00-00 00:00:00'){
            $dwld_stat = "<small><i class='fa fa-check-circle' style='color: green;'
                                    data-toggle=tooltip' data-placement='left' title='Downloaded'>
                                </i>
                          </small>";
        } else {
            $dwld_stat = "<small><i class='fa fa-exclamation-circle' style='color: red;'
                                    data-toggle=tooltip' data-placement='left' title='Not Downloaded'>
                                 </i>
                        </small>";
           
        }
         return $dwld_stat;
        })
        ->editColumn('active', function($data){
           

            $datetime1 = date_create($data->doc_date);
            $datetime2 = date_create(date("Y-m-d"));

            $interval = date_diff($datetime1, $datetime2);

            

            $diff = $interval->format('%m');
             if($diff >= 3){
                $stat = 'disabled';
            } else {
                $stat = '';

                if (isset($_GET['check']))
                {
                    if ($_GET['check'] == "X")
                    {
                        $cb_check = 'checked';
                    }
                }
            }

            if($stat == 'disabled'){

            $active = "<small><i class='fa fa-exclamation-circle' style='color: red;'
                                data-toggle=tooltip' data-placement='left' title='Not Active'>
                              </i>
                       </small>";

        } else {
            $active = "<small><i class='fa fa-check-circle' style='color: green;'
                                data-toggle=tooltip' data-placement='left' title='Active'>
                             </i>
                        </small>";
        }
         return $active;
        })
        ->editColumn('upload_date', function($data){
            return @$data->last_change;
        }) 
        ->editColumn('sent', function($data){
            return date('Y-m-d H:i:s',strtotime($data->sent));
        })
        ->editColumn('po_amount', function($data){
           
            $po_value = number_format($data->po_val, 2, '.', ',');
            $po_val   = "<p class='text-right' >".$po_value."</p>";

             return @$po_val;
        })
        ->editColumn('upload_group', function($data){
            return @$data->batch;
        })
        ->editColumn('total_amount', function($data){
            

            $total_value = number_format($data->tot_va, 2, '.', ',');
            $tot_val   = "<p class='text-right' >".$total_value."</p>";

            return @$tot_val ;
        })
        ->editColumn('number', function($data){
            return 1;
        })
        ->editColumn('nm_vendor', function($data){
            return @$data->vendors->nm_vendor;
        })
        ->editColumn('vend_email', function($data){
            if(!empty($data->vendors)){
                $v = @$data->vendors->vend_email;
            } else{
                $v="";
            }
            $get = MasterUser::where('foreign_id', $data->id_vendor)->first();
            if(@$get->status_user == "A")
            {
                $s = " <i title='Pengguna Aktif' class='fas fa-check-circle text-success'></i> ";
            } else{
                $s=" <i title='Pengguna Non-aktif' class='fas fa-exclamation-circle text-warning'></i> ";
            }
            return $v.($v!=""?$s:"");
        })
        ->editColumn('doc_date', function ($data) {                    
            return date('d.m.Y',strtotime($data->doc_date));
        }) 
        ->addColumn('download_check', function ($data) {
            return '<input type="checkbox" data-filenm="'.$data->file_nm.'"  class="checked" id="'.$data->po_num.'" onclick="selectedDwn(\'#'.$data->po_num.'\')"  name="downloadchk[]" value="'.$data->po_num.'">';
        })
        ->rawColumns(['download_check','vend_email','active','action','rel_stat','mail_stat','file_exist','download_stat','po_amount','total_amount'])->make(true);
                // ->editColumn('last_change_by', function ($data) {
                                
                //                return @$data->users->nm_user;
                //             })  
                // ->editColumn('modify_date', function ($data) {
                                
                //                return date('d.m.y',strtotime($data->modify_date));
                //             }) 
                // ->editColumn('prod_assc', function ($data) {
                //             if ($data->assigned == 'Y'){
                //                 $assigned = "<small class='badge bg-success'> Assigned</small>";
                //             } elseif ($data->assigned == 'N') {
                //                 $assigned = "<small class='badge bg-warning'> Not-Assigned</small>";
                //             }

                //             if ($data->status == "A"){
                //                 $status = "<small class='badge bg-success'> Active</small>";
                //             } elseif ($data->status == "N") {
                //                 $status = "<small class='badge bg-danger'> Non-active</small>";
                //             }
 
                //                return   $assigned;
                //             }) 
                // ->editColumn('action', function ($data) {
                                
                //                return  view('project_management/project_master/buttons')->with(['data' => $data]);
                //             }) 
                // ->editColumn('number', function ($data) {
                                
                //                return 1;
                //             }) 
                // ->rawColumns(['prod_assc','action'])
                             
    }

    public function zipPurchasingProcess(Request $request)
    {
        if(empty($request->download_doc))
        {
            return redirect()->back()->with(['message_fail' => 'Belum ada data yang dipilih.']);
        }

        $zip = new \ZipArchive();
        $fileName = "DHARMA_POLIMETAL_PO_LIST_".date("d-m-Y").".zip";
        try{
            $zipnm = md5($request->ip().time().$fileName);
             if ($zip->open(storage_path('temp_zip/PO-'.$zipnm.'.tmp'), \ZipArchive::CREATE) == TRUE)
            
            {
                
                foreach ($request->download_doc as $k){
                    $filenm = $k;
                      // dd($filenm);
                 // "D:\\\\MANIFEST\\".$mf_type."\\PRD-".$mf_type."\\"
                    // $content[] =\File::get(Storage::disk('po_directory')->path("/").$filenm);
                    $file = Storage::disk('po_directory')->path("").$filenm;
                    $file_qas = Storage::disk('po_qas_directory')->path("").$filenm;
                    $relativeName = basename($file);
                    if(file_exists($file))
                    {
                      $zip->addFile($file, $filenm);
                    } else{
                      $zip->addFile($file_qas, $filenm);
                    }
                }
                $zip->close();
                // dd( $content);
                  return response()->download(storage_path('temp_zip/PO-'.$zipnm.'.tmp'), $fileName)->deleteFileAfterSend(true);
            }
        } catch(\Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException $e)
        {
            // return $e;
            return redirect()->back()->with(['message_fail' => 'File Not Found.']);
        } catch(\InvalidArgumentException $e)
        {
            return redirect()->back()->with(['message_fail' => 'PO Directory filesystem driver has not been set in  application, please contact the IT team.']);
        } catch(\Exception $e)
        {
            return redirect()->back()->with(['message_fail' => 'File Not Found, maybe PO Directory in filesystem config not been set in applicaton, please contact IT Team']);
        }

      
    }

    public function importPo(Request $request)
    {
        $file = $request->file('file');
        config(['excel.import.startRow' => 2]);
        try{
             Excel::import(new ImportPo, $file);
             return redirect()->back()->with(['message_success' => 'Berhasil import excel']);
        } catch(\Exception $e)
        {
             return redirect()->back()->with(['message_fail' => 'Format Excel tidak sesuai']);
        }
       

        // return response()->json([
        //     'type' => 'success',
        //     'message' => 'Import PO Successfully'
        // ]);
        //dd($file);
        //dd($request->all());
       
    }
}
