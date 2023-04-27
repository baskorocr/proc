<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegisIsoDoc;

class DashboardIsoDocController extends Controller
{
    public function index(Request $request)
    {
        $data['regis'] = RegisIsoDoc::with('vendor')->where('del_indicator','!=','X')->get();
        
        return view('doc_iso.master-notify.dashboard-iso', $data);
    }

    public function stat_iso($stat)
    {
        if(auth()->user()->role == 'vendor'){
            $data['regis'] = RegisIsoDoc::with('vendor')->where('stat',$stat)->where('del_indicator','!=','X')->where('id_vendor',auth()->user()->foreign_id)->get();
        } else{
            $data['regis'] = RegisIsoDoc::with('vendor')->where('stat',$stat)->where('del_indicator','!=','X')->get();
        }
        
         switch ($stat) {
            case 'V':
                $stat_t = "Valid";
                break;
            case 'N':
                $stat_t = "Renewed";
                break;

            case 'E':
                $stat_t = "Expired";
                break; 
          
            
            default:
                return redirect()->route('doc-iso.dashboard-iso')->with(['message_fail' => "Stat ISO Invalid."]);
                break;
        }
        $data['stat_type']=$stat_t;
        return view('doc_iso.master-notify.dashboard-iso-stat', $data);
    }
}
