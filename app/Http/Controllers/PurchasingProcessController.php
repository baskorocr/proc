<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchasingProcess;
use Carbon\Carbon;
use App\Models\Vendor;

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
        $data = PurchasingProcess::where(function($query) use ($request){
            if (!empty($request->po_num)) {
               return $query->where('po_num', 'like', "%" . $request->po_num . "%");
            }

            if (!empty($request->date_from) && !empty($request->date_to)) {
                return $query->whereBetween('doc_date', [Carbon::parse($request->date_from.' 00:00:00'), Carbon::parse($request->date_to.' 23:59:59')]);
            }

            if (!empty($request->id_vendor)) {
                return $query->where('id_vendor', (string) $request->id_vendor);
            }
        })->get();

        return \DataTables::of($data)
        ->editColumn('number', function($data){
            return 1;
        })
        ->editColumn('nm_vendor', function($data){
            return @$data->vendors->nm_vendor;
        })
        ->editColumn('vend_email', function($data){
            return @$data->vendors->vend_email;
        })
        ->editColumn('doc_date', function ($data) {                    
            return date('d.m.Y',strtotime($data->doc_date));
         })
        // ->whereBetween('doc_date', [Carbon::parse($data->doc_date.' 00:00:00'), Carbon::parse($data->doc_date.' 23:59:59')])
        // ->where('id_vendor', $data->id_vendor)
        ->rawColumns(['action'])->addIndexColumn()->make(true);
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
        $data = PurchasingProcess::where(function($query) use ($request){
            if (!empty($request->po_num)) {
               return $query->where('po_num', 'like', "%" . $request->po_num . "%");
            }

            if (!empty($request->date_from) && !empty($request->date_to)) {
                return $query->whereBetween('doc_date', [Carbon::parse($request->date_from.' 00:00:00'), Carbon::parse($request->date_to.' 23:59:59')]);
            }

            if (!empty($request->id_vendor)) {
                return $query->where('id_vendor', (string) $request->id_vendor);
            }
        })->get();

        return \DataTables::of($data)
        ->editColumn('number', function($data){
            return 1;
        })
        ->editColumn('nm_vendor', function($data){
            return @$data->vendors->nm_vendor;
        })
        ->editColumn('vend_email', function($data){
            return @$data->vendors->vend_email;
        })
        ->editColumn('doc_date', function ($data) {                    
            return date('d.m.Y',strtotime($data->doc_date));
         }) 
        ->rawColumns(['action'])->addIndexColumn()->make(true);
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
}
