<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegisIsoDoc;

class ReportIsoDocController extends Controller
{
    public function index(Request $request)
    {
        if(auth()->user()->role == 'vendor'){
            $data['regis'] = RegisIsoDoc::with('vendor')->where('del_indicator','!=','X')->where('id_vendor',auth()->user()->foreign_id)->get();
        } else{
            $data['regis'] = RegisIsoDoc::with('vendor')->where('del_indicator','!=','X')->get();
        }
        
        
        return view('doc_iso.master-notify.report-iso', $data);
    }
    public function stat_iso($stat)
    {
        if(auth()->user()->role == 'vendor'){
            $data['regis'] = RegisIsoDoc::with('vendor')->where('trn_type',$stat)->where('del_indicator','!=','X')->where('id_vendor',auth()->user()->foreign_id)->get();
        } else{
            $data['regis'] = RegisIsoDoc::with('vendor')->where('trn_type',$stat)->where('del_indicator','!=','X')->get();
        }
        switch ($stat) {
            case 'S':
                $stat_t = "Submitted";
                break;
            case 'C':
                $stat_t = "Rejected";
                break;

            case 'U':
                $stat_t = "Updated";
                break; 
            case 'R':
                $stat_t = "Approved";
                break; 

            case 'I':
                $stat_t = "Notified";
                break;
            
            default:
                 $stat_t = "Unknown";
                break;
        }
        $data['stat_type']=$stat_t;
        return view('doc_iso.master-notify.report-iso-stat', $data);
    }

    public function view(Request $request)
    {
        $data['regis'] = RegisIsoDoc::with('vendor')->get();
        
        return view('doc_iso.master-notify.report-iso', $data);
    } 

    
}
