<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManifestHeader;

class DeliveryScheduleController extends Controller
{
    public function index()
    {
        return view('delivery_schedule/index');
    }

    public function index_spo()
    {
        return view('delivery_schedule/index_spc');
    }

    public function getDeliveryMf()
    {
       if(auth()->user()->role == 'vendor')
       {
             $data = ManifestHeader::where('id_vendor', auth()->user()->foreign_id)->where('mf_type','MI')->get();
       } else {
            $data = ManifestHeader::orderBy('delivery_date','DESC')->where('mf_type','MI')->get();
       }
 
       return \DataTables::of($data)
          
            ->editColumn('delivery_date', function ($data) {
                
               return  date('Y-m-d',strtotime($data->delivery_date));
            }) 
            ->addColumn('vendor_name', function ($data) {
               return empty($data->vendors) ? "-":$data->vendors->nm_vendor;
            })
            ->addColumn('vendor_email', function ($data) {
               return empty($data->vendors->user) ? "-":$data->vendors->user->username;
            })

            ->addColumn('download_check', function ($data) {
               return '<input type="checkbox" name="downloadchk[]" value="'.$data->id.'">';
            })
            ->addColumn('mail_stat', function ($data) {
               if(!empty($data->sent) || ($data->sent != '0000-00-00 00:00:00'))
               {
                return "<small><i class='fa fa-check-circle' style='color: green;'></i></small>";
               } 
                 return "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";
            
            }) 
            ->addColumn('downloaded', function ($data) {
               if(!empty($data->downloaded) || ($data->downloaded != '0000-00-00 00:00:00'))
               {
                return "<small><i class='fa fa-check-circle' style='color: green;'></i></small>";
               } 
                 return "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";
            
            })
             ->addColumn('file_stat', function ($data) {
               if(!empty($data->file_nm))
               {
                return "<small><i class='fa fa-check-circle' style='color: green;'></i></small>";
               } 
                 return "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";
            
            }) 
             ->addColumn('active', function ($data) {
               if($data->active == "A")
               {
                return "<small><i class='fa fa-check-circle' style='color: green;'></i></small>";
               } 
                 return "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";
            
            })
            ->rawColumns(['download_check','mail_stat','downloaded','file_stat','active'])
            ->make(true);
    }

    public function getDeliverySPC()
    {
        if(auth()->user()->role == 'vendor')
       {
             $data = ManifestHeader::where('id_vendor', auth()->user()->foreign_id)->where('mf_type','SO')->get();
       } else {
            $data = ManifestHeader::orderBy('delivery_date','DESC')->where('mf_type','SO')->get();
       }
       return \DataTables::of($data)
          
            ->editColumn('delivery_date', function ($data) {
                
               return  date('Y-m-d',strtotime($data->delivery_date));
            }) 
            ->addColumn('vendor_name', function ($data) {
               return empty($data->vendors) ? "-":$data->vendors->nm_vendor;
            })
            ->addColumn('vendor_email', function ($data) {
               return empty($data->vendors->user) ? "-":$data->vendors->user->username;
            })

            ->addColumn('download_check', function ($data) {
               return '<input type="checkbox" name="downloadchk[]" value="'.$data->id.'">';
            })
            ->addColumn('mail_stat', function ($data) {
               if(!empty($data->sent) || ($data->sent != '0000-00-00 00:00:00'))
               {
                return "<small><i class='fa fa-check-circle' style='color: green;'></i></small>";
               } 
                 return "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";
            
            }) 
            ->addColumn('downloaded', function ($data) {
               if(!empty($data->downloaded) || ($data->downloaded != '0000-00-00 00:00:00'))
               {
                return "<small><i class='fa fa-check-circle' style='color: green;'></i></small>";
               } 
                 return "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";
            
            })
             ->addColumn('file_stat', function ($data) {
               if(!empty($data->file_nm))
               {
                return "<small><i class='fa fa-check-circle' style='color: green;'></i></small>";
               } 
                 return "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";
            
            }) 
             ->addColumn('active', function ($data) {
               if($data->active == "A")
               {
                return "<small><i class='fa fa-check-circle' style='color: green;'></i></small>";
               } 
                 return "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";
            
            })
            ->rawColumns(['download_check','mail_stat','downloaded','file_stat','active'])
            ->make(true);
    }
}
