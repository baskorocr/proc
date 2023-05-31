<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchasingProcess;
use Carbon\Carbon;
use App\Models\Vendor;
use App\Models\MasterUser;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\EmailGroup;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportPo;
use Mail;
use App\Mail\PoMailBatch;
use Storage;

class PurchasingProcessController extends Controller
{
    //Testing Purpose Only
    public function test_read()
    {
        $dir1 = preg_grep('~^5111010602-.*\.pdf$~', scandir(public_path('PROD/')));
        $dir2 = preg_grep('~^5111010602-.*\.pdf$~', scandir(public_path('QAS/')));

        $files = array_merge($dir1,$dir2);
        $gf = [];
        foreach($files as $key => $file)
        {
            $gf[] = $file;
        }
        dd($gf);
    }
    //End Testing Purpose Only

    public function upload()
    {
        return view('purchasing_process/upload');
    }

    public function index()
    {
        $vendor = Vendor::all();
        return view('purchasing_process/index', ['list_vendor' => $vendor]);
    }


    public function sendmail(Request $request)
    {
        
        try{
          
            $vendor = Vendor::where('id_vendor',$request->id_vendor)->first();
            $po = PurchasingProcess::where(function ($query) {
                                            $query->where('sent','=','0000-00-00 00:00:00')
                                                ->orWhereNull('sent');
                                        })->get();
            if(count($po) == 0)
            {
                return redirect()->back()->with(['message_fail' => "Nothing to send."]);
            }

            if($this->mailer_send($po) > 0)
            {
                return redirect()->back()->with(['message_fail' => "Some PO email failed to send, email user vendor not found."]);
            }

            return redirect()->back()->with(['message_success' => "All PO emails have been sent."]);



        } catch(\Exception $e) {
           return redirect()->back()->with(['message_fail' => $e->getMessage()]);
        }
    }

    private function mailer_send($po)
    {
        $vendor = [];
        $creator = [];
        $failed_send = 0;
        foreach($po as $po)
        {
           

            if(!in_array($po->id_vendor,$vendor) AND !in_array($po->creator,$creator))
            {
                    $vendor[] = $po->id_vendor;
                    $creator[] = $po->creator;
                 
                    $dataPo = PurchasingProcess::where('id_vendor',$po->id_vendor)->where('creator',$po->creator)->where(function ($query) {
                                                    $query->where('sent','=','0000-00-00 00:00:00')
                                                        ->orWhereNull('sent');
                                                })->get();
                    $list_permission=[];
                    $user = User::where('foreign_id',  $po->id_vendor)->where('is_vendor',true)->where('status_user','A')->get();
                    foreach($user as $u)
                    {   
                        $list_permission[]=$u->role_id;
                    }
                    $lperm = array_unique($list_permission);
                    $getMenu = Permission::where('name','Download PO')->first();
                    $role =  Role::whereIn('_id',$list_permission)->get();
            
                    $allowed = [];
                    $sended = [];
                    //Proses Pencarian Role mana saja yang diizinkan mengakses permission
                    foreach($role as $r)
                    {
                        $permissions=[];
                        foreach($r->permissions as $p){
                            $permissions[] = $p->permission_id; 
                            
                        }
                        
                        if(in_array($getMenu->_id, $permissions))
                        {
                            $allowed[] = $r->_id;
                        }
            
                    }


                    //Ambil Data Vendor
                    $user =  MasterUser::whereIn('role_id',$allowed)->get();
                    $nameGroupMail  = $this->split_creator($po->creator);
                    $emailgrp = EmailGroup::where('abrev',$nameGroupMail)->first();
                     $cc = [];
                    if(!empty($emailgrp))
                    {
                       $emaillist = $emailgrp->mailgroup;
                        //TO USER
                        //TO Listed Group DEPT
                       
                        foreach ($emaillist as $e) {
                            if (filter_var($e->mail, FILTER_VALIDATE_EMAIL)) {
                             $cc[] =$e->mail;
                            }
                        
                        }
                    } else{
                        throw new Exception('Email Group "'.$nameGroupMail.'"" is not registered in E-Proc.');
                    }

                    //Kirim Ke Akun Vendor
                    $mailVendorUser = [];
                    $user =  MasterUser::whereIn('role_id',$allowed)->where('status_user','A')->where('foreign_id', $po->id_vendor)->get();
                    foreach($user as $vendor_user){
                        if (filter_var($vendor_user->username, FILTER_VALIDATE_EMAIL)) {
                            
                            $mailVendorUser[]=$vendor_user->username;
                            
                        }
                    }
                    $userv = User::where('foreign_id', $po->id_vendor)->first();
                    if(count($mailVendorUser) == 0)
                    {
                        $failed_send++;
                    } else{
                        // dd("A");
                        Mail::to($mailVendorUser)->cc($cc)->send(new PoMailBatch($dataPo, $userv));

                    }

                    //Set field 'sent' untuk flag terkirim
                   
            }
                     PurchasingProcess::where('_id',$po->id)->update(['sent' => date('Y-m-d H:i:s')]);

        }
         return $failed_send;
            
        
    }
    public function send_mail()
    {
        $vendor = Vendor::all();
        return view('purchasing_process/send_mail', ['list_vendor' => $vendor]);
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
            
             if(($data->sent != '-0001-11-30 00:00:00' AND $data->sent != '0000-00-00 00:00:00') AND isset($data->sent) ){
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
           $filenm = $data->file_nm;
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
             if(($data->sent != '-0001-11-30 00:00:00' AND $data->sent != '0000-00-00 00:00:00')   AND isset($data->downloaded)){
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
            if(($data->last_change != '-0001-11-30 00:00:00' AND $data->last_change != '0000-00-00 00:00:00')   AND isset($data->last_change)){
                $uploaddt = $data->last_change;
            } else {
                $uploaddt = "-";
               
            }
         return $uploaddt;
        })
        ->editColumn('po_amount', function($data){
           
            $po_value = number_format($data->po_val, 2, '.', ',');
            $po_val   = "<p class='text-right' >".$po_value."</p>";

             return @$po_val;
        })
        ->editColumn('total_amount', function($data){
            

            $total_value = number_format($data->tot_val, 2, '.', ',');
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
            $get = MasterUser::Where('username',@$data->vendors->vend_email)->first();
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

    public function getListPoSend(Request $request)
    {
       
        $data = PurchasingProcess::where('id_vendor','!=','')->where(function ($query) {
                                        $query->where('sent','=','0000-00-00 00:00:00')
                                            ->orWhereNull('sent');
                                    })->get();

        
       
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
          
             if($data->sent != '-0001-11-30 00:00:00'  AND isset($data->sent) ){
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
           $filenm = $data->file_nm;
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
             if(($data->sent != '-0001-11-30 00:00:00' AND $data->sent != '0000-00-00 00:00:00')   AND isset($data->downloaded)){
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
            if(($data->last_change != '-0001-11-30 00:00:00' AND $data->last_change != '0000-00-00 00:00:00')   AND isset($data->last_change)){
                $uploaddt = $data->last_change;
            } else {
                $uploaddt = "-";
               
            }
         return $uploaddt;
        })
        ->editColumn('po_amount', function($data){
           
            $po_value = number_format($data->po_val, 2, '.', ',');
            $po_val   = "<p class='text-right' >".$po_value."</p>";

             return @$po_val;
        })
        ->editColumn('total_amount', function($data){
            

            $total_value = number_format($data->tot_val, 2, '.', ',');
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
            $get = MasterUser::Where('username',@$data->vendors->vend_email)->first();
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
          
             if($data->sent != '-0001-11-30 00:00:00'   AND isset($data->sent)){
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
           $filenm = $data->file_nm;
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
             if(($data->sent != '-0001-11-30 00:00:00' AND $data->sent != '0000-00-00 00:00:00')  AND isset($data->downloaded) ){
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
            if(($data->last_change != '-0001-11-30 00:00:00' AND $data->last_change != '0000-00-00 00:00:00')   AND isset($data->last_change)){
                $uploaddt = $data->last_change;
            } else {
                $uploaddt = "-";
               
            }
         return $uploaddt;
        })
        ->editColumn('sent', function($data){
            return !empty($data->sent) ? date('Y-m-d H:i:s',strtotime($data->sent)):"-";
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
            

            $total_value = number_format($data->tot_val, 2, '.', ',');
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
            $get = MasterUser::Where('username',@$data->vendors->vend_email)->first();
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
             // return '<input type="checkbox" data-filenm="'.$data->file_nm.'" data-mgid="'.$data->_id.'"  class="checked" id="'.$data->_id.'" onclick="selectedDwn(\'#'.$data->_id.'\')"  name="downloadchk[]" value="'.$data->po_num.'">';
            if($data->file_nm=="-"  || empty($data->file_nm)){
                 return '<input type="checkbox" data-filenm="'.@$data->file_nm.'" data-mgid="'.@$data->_id.'"  class="checked" id="'.@$data->_id.'" onclick=""  name="disabled" disabled  style="cursor: not-allowed;" value="'.@$data->po_num.'">';

            }
            $file = Storage::disk('po_directory')->path(""). $data->file_nm;
            $file_qas = Storage::disk('po_qas_directory')->path(""). $data->file_nm;
            $relativeName = basename($file);
            if(file_exists($file))
            {
              return '<input type="checkbox" data-filenm="'.$data->file_nm.'" data-mgid="'.$data->_id.'"  class="checked" id="'.$data->_id.'" onclick="selectedDwn(\'#'.$data->_id.'\')"  name="downloadchk[]" value="'.$data->po_num.'">';
            } elseif(file_exists($file_qas)){

                 return '<input type="checkbox" data-filenm="'.$data->file_nm.'" data-mgid="'.$data->_id.'"  class="checked" id="'.$data->_id.'" onclick="selectedDwn(\'#'.$data->_id.'\')"  name="downloadchk[]" value="'.$data->po_num.'">';
            }else{
               return '<input type="checkbox" data-filenm="'.@$data->file_nm.'" data-mgid="'.@$data->_id.'"  class="checked" id="'.@$data->_id.'" onclick=""  name="disabled" disabled style="cursor: not-allowed;"  value="'.@$data->po_num.'">';
            }
           
            
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
        if(!extension_loaded('zip'))
        {
            return redirect()->back()->with(['message_fail' => 'Zip extension not enabled or not installed on server, please contact the IT team.']);
        }
        if(empty($request->download_doc))
        {
            return redirect()->back()->with(['message_fail' => 'Belum ada data yang dipilih.']);
        }

        $zip = new \ZipArchive();
        $fileName = "DHARMA_POLIMETAL_PO_LIST_".date("d-m-Y").".zip";
        try{
            $zipnm = md5($request->ip().time().$fileName);
            ///ZIPPING FILES
            if ($zip->open(storage_path('temp_zip/PO-'.$zipnm.'.tmp'), \ZipArchive::CREATE) == TRUE)
            {
               
                foreach ($request->download_doc as $k){

                    $filenm = $k;
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
                ///SET DOWNLOAD FLAG
                foreach($request->id_po as $po)
                {
                     PurchasingProcess::where('_id',$po)->update(['downloaded' => date('Y-m-d H:i:s')]);
                }
                ///DOWNLOADING
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
            return redirect()->back()->with(['message_fail' => 'File Not Found, maybe PO Directory in filesystem config not been set in applicaton or directory not been mount on server, please contact IT Team']);
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


    private function split_creator($creator)
    {
        try{
             //PISAHKAN TEXT dan Spesial Karakter
            $get_group = array_filter(preg_split('/(\w+)/', $creator, -1, PREG_SPLIT_DELIM_CAPTURE));
            // Pisahkan numeric dan alpha
            // Pisahkan numeric dan alpha
            $res = [];
            foreach($get_group as $key => $gg)
            {
                $res[] = $gg;
            }
            // dd($res);
            $get_name = sscanf(isset($res[2]) ? $res[2]:$res[0], "%[A-Z]%d");
            //Get PUR
            return $get_name[0];
        } catch(\Exception $e)
        {
            throw new Exception("Creator format is invalid. Accept : DPM-{ex: PUR03 or INVMGR}");
        }
       
    }

    private function reIndexArray( $arr, $startAt=0 )
    {
        return ( 0 == $startAt )
            ? array_values( array_filter($arr) )
            : array_combine( array_filter(range( $startAt, count( $arr ) + ( $startAt - 1 ) ), array_values( $arr )) );
    }
}
