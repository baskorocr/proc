<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManifestHeader;
use App\Models\ManifestDetail;
use App\Models\Permission;
use App\Models\Role;
use App\Models\MasterUser;
use Carbon\Carbon;
use App\Models\Vendor;
use Mail;
use App\Mail\ManifestMail;

class ManifestController extends Controller
{
    public function manifestHeader(Request $request)
    {   
        $manifest = ManifestHeader::with('manifestDetails')->where('manifest', $request->manifest)->first();
        $isExists = !empty($manifest) ? true : false ;
        
        if ($isExists) {
            $vendor = Vendor::where('id_vendor', $manifest->id_vendor)->first();
            // change all! the old code is all wrong
            $getManifestDetail = ManifestDetail::where('manifest', $manifest->manifest)->get();
            $groupByMaterial = $getManifestDetail->groupBy('manterial');
            $mapMaterial = $groupByMaterial->map(function($data){
                return [
                    'material' => $data->first()->material,
                    'material_desc' => $data->first()->material_desc,
                    'qty_scan' => $data->sum('qty_pack'),
                    'qty_scan_outstanding' => $data->sum('qty_scan_outstanding'),
                    'qty_gr' => $data->sum('qty_in'),
                    'qty_gr_outstanding' => $data->sum('qty_gr_outstanding'),
                    'kanban' => $data->count(),
                    'kanban_outstanding' => $data->where('qty_scan_outstanding', '>', 0)->count(),
                ];
            })->values();

            return response()->json([
                'data' => [
                    "_id" => $manifest->_id,
                    "manifest" => $manifest->manifest,
                    "mf_type" => $manifest->mf_type,
                    "release_date" => $manifest->release_date,
                    "id_vendor" => $manifest->id_vendor,
                    "delivery_date" => $manifest->delivery_date,
                    "delivery_time" => $manifest->delivery_time,
                    "po_num" => $manifest->po_num,
                    "sent" => $manifest->sent,
                    "downloaded" => $manifest->downloaded,
                    "file_nm" => $manifest->file_nm,
                    "stat" => $manifest->stat,
                    "active" => $manifest->active,
                    "purch_org" => $vendor->purch_org,
                    "nm_vendor" => $vendor->nm_vendor,
                    "allias" => $vendor->allias,
                    "street" => $vendor->street,
                    "district" => $vendor->district,
                    "postal_code" => $vendor->postal_code,
                    "city" => $vendor->city,
                    "country" => $vendor->country,
                    "region" => $vendor->region,
                    "phone_1" => $vendor->phone_1,
                    "vat_reg" => $vendor->vat_reg,
                    "order_curr" => $vendor->order_curr,
                    "pay_term" => $vendor->pay_term,
                    "sales_person" => $vendor->sales_person,
                    "phone_2" => $vendor->phone_2,
                    "vend_email" => $vendor->vend_email,
                    "status_vendor" => $vendor->status_vendor,
                    "details" => $mapMaterial
                ]
            ]);
    
        } else {
            return response()->json([
                'type' => 'error',
                'isExists' => $isExists,
                'message' => 'Please check manifest number!',
                'data' => null
            ], 422);
        }
    }

    public function manifestDetail(Request $request, $manifest)
    {
        $manifest_detail = ManifestDetail::where('manifest', $manifest)->get();

        return response()->json([
            'type' => 'success',
            'data' => $manifest_detail
        ]);
    }

    public function manifest_test_mail($manifestId)
    {
        $this->mailer_send($manifestId, [1]);
    }

    public function sendManifest(Request $request)
    {
        // $cekManifest = ManifestHeader::where('manifest', $request->manifest)->first();
        $vendor = Vendor::where('id_vendor', $request->id_vendor)->first();
        $msg_mail = '';
        $msg_data = '';
        $resDuplicate = 0;

        $cekManifest = ManifestHeader::where('manifest', $request->manifest)->get();

        $manifest = new ManifestHeader;

        if(count($cekManifest) > 0) {
            $msg_data = 'Manifest send to eproc failed, cannot insert duplicate data manifest.';
            $msg_mail = 'Manifest send to vendor failed. because send manifest already exist';
            $resDuplicate = 1;
        } else {
            $manifest->manifest = $request->manifest;
            $manifest->id_vendor = $request->id_vendor;
            $manifest->delivery_time = $request->delivery_time;
            $manifest->delivery_date = $request->delivery_date;
            $manifest->po_num = $request->po_num;
            $manifest->file_nm = $request->file_nm;
            $manifest->mf_type = $request->mf_type;
            $manifest->release_date = $request->release_date;
            $manifest->save();
            
            foreach ($request->details as $detail){
                $manifest_detail = new ManifestDetail;
                $manifest_detail->kanban = $detail['kanban'];
                $manifest_detail->seq_kanban = $detail['seq_kanban'];
                $manifest_detail->item = $detail['item'];
                $manifest_detail->manifest = $request->manifest;
                $manifest_detail->material = $detail['material'];
                $manifest_detail->material_desc = $detail['material_desc'];
                $manifest_detail->qty_pack = $detail['qty_pack'];
                $manifest_detail->qty_in = $detail['qty_in'];
                $manifest_detail->arrival_date = Carbon::parse($detail['arrival_date']);
                $manifest_detail->arrival_time = Carbon::parse($detail['arrival_time']);
                $manifest_detail->scan_date = Carbon::parse($detail['scan_date']);
                $manifest_detail->scan_time = Carbon::parse($detail['scan_time']);
                $manifest_detail->scan_by = $detail['scan_by'];
                $manifest_detail->issued_date = Carbon::parse($detail['issued_date']);
                $manifest_detail->issued_time = Carbon::parse($detail['issued_time']);
                $manifest_detail->issued_by = $detail['issued_by'];
                $manifest_detail->active = $detail['active'];
                $manifest_detail->save();
            }

            $msg_data = 'Manifest send to eproc saved successfully.';
        }

        if($resDuplicate != 1) {
            if($vendor) {
                if($vendor->status_vendor === 'A') {
                    try {
                        $this->mailer_send($request->manifest, $cekManifest);
                        $msg_mail = 'Manifest send mailed to vendor successfully.';
                    } catch (Exception $e) {
                        $msg_mail = $e->getMessage();
                    }
    
                    return response()->json([
                        'msg_data' => $msg_data,
                        'msg_mail' => $msg_mail,
                        'data' => $manifest,
                    ], 200);
    
                } else {
                    return response()->json([
                        'msg_data' => $msg_data,
                        'msg_mail' => 'Manifest send to vendor failed.',
                    ], 200);
                }
            } else {
                return response()->json([
                    'msg_data' => $msg_data,
                    'msg_mail' => 'Manifest send to vendor failed.',
                ], 422);
            }
        } else {
            return response()->json([
                'msg_data' => $msg_data,
                'msg_mail' => $msg_mail,
            ], 422);
        }
        
    }

    public function resendEmailManifest(Request $request)
    {
        //$vendor = Vendor::where('id_vendor', $request->id_vendor)->first();
        $mannifest = ManifestHeader::where('manifest', $request->manifest)->first();
        $vendor = Vendor::where('id_vendor', $request->id_vendor)->first();
        $msg_mail = '';
        $msg_data = 'Manifest send to eproc saved successfully.';

        if($vendor){
            if($vendor->status_vendor === 'A'){

                //Mail::to($vendor->vend_email)->send(new PoMail($po, $vendor));
                try {
                    $this->mailer_send($mannifest);
                    // Mail::to($user->username)->send(new PoMail($po, $user));
                    $msg_mail = 'Manifest send mailed to vendor successfully';
                } catch (Exception $e) {
                    $msg_mail = $e->getMessage();
                }
                

                return response()->json([
                    'msg_data' => $msg_data,
                    'msg_mail' => $msg_mail,
                    'data' => $manifest
                ], 200);
            } else {
                return response()->json([
                    'msg_data' => $msg_data,
                    'msg_mail' => 'Manifest send to vendor failed.',
                    //'data' => $po
                ], 422);
            }
        } else {
            return response()->json([
                'msg_data' => $msg_data,
                'msg_mail' => 'Manifest send to vendor failed.',
                //'data' => $po
            ], 422);
        }
    }

    private function mailer_send($manifest, $cekManifest)
    {
        if(count($cekManifest) > 0) {
            $manifestHead = ManifestHeader::where('manifest', $manifest)->first();
    
            //Ambil Permission dengan nama Delivery Schedule
            $getMenu = Permission::where('name','Delivery Schedule')->first();
            $role =  Role::get();
    
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
            $vendor = Vendor::where('id_vendor',$manifestHead->id_vendor)->first();
            $user =  MasterUser::whereIn('role_id',$allowed)->get();
            $cc=[];
            //Kirim Email Ke Pengguna yang dapat mengakses Delivery Schedule
            foreach($user as $u)
            {
                if (filter_var($u->username, FILTER_VALIDATE_EMAIL)) {
                    $cc[] =$u->username;
                    $sended[] = $u->username;
                }
            }
    
            //Kirim Ke Akun Vendor
            // $vendor_user = MasterUser::where('foreign_id',$manifestHead->id_vendor)->limit(1)->get();
    
            // foreach($vendor_user as $vendor_user){
            //     if (filter_var($vendor_user->username, FILTER_VALIDATE_EMAIL)) {
            //         if(!in_array($vendor_user->username,$sended))
            //         {
            //             Mail::to($vendor_user->username)->cc($cc)->send(new ManifestMail($manifestHead,$vendor));
            //         }
            //     }
            // }

            $vendor_user = MasterUser::where('foreign_id',$manifestHead->id_vendor)->where('status_user','A')->whereIn('role_id',$allowed)->get();
            $vendEmail = [];
            foreach($vendor_user as $vendor_user){
                if (filter_var($vendor_user->username, FILTER_VALIDATE_EMAIL)) {
                   
                        $vendEmail[] = $vendor_user->username;
                       
                }
            }
            // dd($allowed);
             Mail::to($vendEmail)->cc($vendEmail)->send(new ManifestMail($manifestHead,$vendor));
            //Set field 'sent' untuk flag terkirim
            ManifestHeader::where('_id',$manifestHead->_id)->update(['sent' => date('Y-m-d H:i:s')]);
        } else {
            return false;
        }
        
    }

    public function closeManifest(Request $request)
    {
        $manifest = ManifestHeader::where('manifest', $request->manifest)->first();
        $manifest->manifest = $request->manifest;
        $manifest->stat = $request->stat;
        $manifest->active = $request->active;
        $manifest->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Data Manifest Closed Successfully',
            'data' =>  $manifest,
        ]);
    }

    public function checkKanban(Request $request)
    {   
        $manifest_d = ManifestDetail::where('manifest', $request->manifest)->where('kanban', $request->kanban)->first();
        
        $isExists = !empty($manifest_d) ? true : false ;

        \Log::info($request->all());
        
        if ($isExists) {

            if ($manifest_d->qty_scan_outstanding > 0) {
                return response()->json([
                    'message' => 'Kanban already scanned!',
                    'errors' => [
                        'kanban' => [
                            'Kanban already scanned!'
                        ]
                    ]
                    ], 422);
            } else {

                $manifest_d->qty_scan_outstanding = $manifest_d->qty_pack;
                $manifest_d->scan_by = $request->scan_by;
                $manifest_d->save();

                
    
                $manifest = ManifestHeader::with('manifestDetails')->where('manifest', $request->manifest)->first();
                $getManifestDetail = ManifestDetail::where('manifest', $manifest->manifest)->get();
                $groupByMaterial = $getManifestDetail->groupBy('manterial');
                $mapMaterial = $groupByMaterial->map(function($data){
                    return [
                        'material' => $data->first()->material,
                        'material_desc' => $data->first()->material_desc,
                        'qty_scan' => $data->sum('qty_pack'),
                        'qty_scan_outstanding' => $data->sum('qty_scan_outstanding'),
                        'qty_gr' => $data->sum('qty_in'),
                        'qty_gr_outstanding' => $data->sum('qty_gr_outstanding'),
                        'kanban' => $data->count(),
                        'kanban_outstanding' => $data->where('qty_scan_outstanding', '>', 0)->count(),
                    ];
                })->values();
    
                return response()->json([
                    'type' => 'success',
                    'data' => $mapMaterial
                ]);
            }

    
        } else {
            return response()->json([
            'message' => 'Kanban Not Found',
            'errors' => [
                'kanban' => [
                    'Kanban not found!'
                ]
            ]
            ], 422);
        }
    }

    public function outstanding(Request $request)
    {
        $skip = $request->perpage * ($request->page - 1);
        $manifest = ManifestHeader::has('manifestDetails')->where(function($where) use ($request){
                        if(!empty($request->keyword)){
                            $where->where('manifest', 'like', '%'.$request->keyword.'%');
                        }
                    })
                    ->when(!empty($request->sort), function($query) use ($request){
                        $query->orderBy($request->sort, $request->order == 'ascend' ? 'asc' : 'desc');
                    })
                    ->take((int)$request->perpage)
                    ->skip((int)$skip)
                    ->get()
                    ->map(function($data){

                        $sum_qty_scan = $data->manifestDetails->sum('qty_pack');
                        $sum_qty_gr = $data->manifestDetails->sum('qty_in');
                        $total = $data->manifestDetails->count();
                        $vendor = Vendor::where('id_vendor', $data->id_vendor)->first();
                        $last = $data->manifestDetails->sort(function ($a, $b) {
                            return strtotime($a->updated_at) < strtotime($b->updated_at);
                        });

                        return [
                            'manifest' => $data->manifest,
                            'qty_sgt' => "[$sum_qty_scan][$sum_qty_gr][$total]",
                            'delivery_date' => $data->delivery_date,
                            'po_number' => $data->po_num,
                            'vendor_id' => $data->id_vendor,
                            'vendor_name' => $vendor->nm_vendor,
                            'last_scan' => $last->first()->updated_at,
                            'scan_by' => $last->first()->scan_by
                        ];
                    });

        $total = ManifestHeader::where(function($where) use ($request){
            if(!empty($request->keyword)){
                $where->where('manifest', 'like', '%'.$request->keyword.'%');
            }
        })
        ->count();

        return response()->json([
            'type' => 'success',
            'data' => $manifest,
            'total' => $total
        ], 200);
    }


    // new send SAP manifest
    public function sendManifestSap(Request $request)
    {
        
        $manifest_detail = ManifestDetail::where('manifest', $request->manifest)
                                    ->whereNotNull('qty_scan_outstanding')
                                    ->get();

        $username = 'DPM-EINVC';
        $password = 'Einvoice01';

        $data_parsed = $manifest_detail->map(function($req) {
            return [
                "MNNUM" => $req['manifest'],
                "ITEM" => $req['item'],
                "KBNNO" => $req['kanban'],
                "SEQUN" => $req['seq_kanban'],
                "GRDATE" => date('Y-m-d'),
                "GRTIME" => date('Hms'),
                "ENTRY_QNT" => $req['qty_scan_outstanding']
            ];
        });

        $payload = json_encode(["IT_INPUT" => $data_parsed]);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://erpqas-dp.dharmap.com:8001/sap/zapi/zmm_goodsmvt_createv1?sap-client=300');
        curl_setopt($curl, CURLOPT_COOKIE, 'sap-usercontext=sap-client=300; Path=/; Domain=erpqas-dp.dharmap.com;');
        // curl_setopt($curl, CURLOPT_COOKIE, $get_header['cookie']);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            // 'X-CSRF-TOKEN: '.$get_header['csrf'],
            'Content-Type: application/json',
            'accept: application/json'
        ));

        curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $restPostDP = curl_exec($curl);

        curl_close ($curl);

        $jsonData = json_decode($restPostDP, true);
        $result = $jsonData['return'];
        $status = $result[0]['type'];
        $message = $result[0]['message'];
        

        if ($status === 'E') {
            return response()->json(['message' => $message], 422);
        } else {

            foreach ($manifest_detail as $detail) {
                $manifest_d_update = ManifestDetail::find($detail->id);
                $manifest_d_update->qty_gr_outstanding = $detail->qty_scan_outstanding;
                $manifest_d_update->save();
            }

            return response()->json(['message' => 'Data saved successfully!']);
        }

    }

}
