<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManifestHeader;
use App\Models\ManifestDetail;
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
        
        if (!empty($manifest)) {
            $vendor = Vendor::where('id_vendor', $manifest->id_vendor)->first();
            return response()->json([
                'type' => 'success',
                'isExists' => $isExists,
                'message' => 'Success',
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
                    "details" => $manifest->manifestDetails
                ]
            ], 200);
    
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

    public function sendManifest(Request $request)
    {
        $vendor = Vendor::where('id_vendor', $request->id_vendor)->first();

        $manifest = new ManifestHeader;
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
            $manifest_detail->manifest = $detail['manifest'];
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

        Mail::to($vendor->vend_email)->send(new ManifestMail($manifest, $vendor));

        
        return response()->json([
            'message' => 'Data saved successfully',
            'data' => $manifest,
        ], 200);
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
        $manifest = ManifestDetail::where('manifest', $request->manifest)->where('kanban', $request->kanban)->first();
        
        $isExists = !empty($manifest) ? true : false ;

        if (!empty($manifest)) {
            return response()->json([
                'type' => 'success',
                'isExists' => $isExists,
                'data' => $manifest
            ]);
    
        } else {
            return response()->json([
            'message' => 'Kanban Not Found',
            'isExists' => $isExists,
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
                        $total = $sum_qty_scan - $sum_qty_gr;
                        $vendor = Vendor::where('id_vendor', $data->id_vendor)->first();

                        return [
                            'manifest' => $data->manifest,
                            'qty_sgt' => "[$sum_qty_scan][$sum_qty_gr][$total]",
                            'delivery_date' => $data->delivery_date,
                            'po_number' => $data->po_num,
                            'vendor_id' => $data->id_vendor,
                            'vendor_name' => $vendor->nm_vendor
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

}
