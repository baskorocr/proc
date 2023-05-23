<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegisIsoDoc;
use App\Models\Vendor;
use App\Models\IsoLog;
use App\Models\MasterNotify;

use Illuminate\Support\Facades\File;

use Auth;

class RegisIsoDocController extends Controller
{
    public function index(Request $request)
    {

        $data['vendor'] = Vendor::get();
        $data['notify'] = MasterNotify::get();
        
        return view('doc_iso.master-notify.register-iso', $data);
    }

    public function show(Request $request, $id)
    {
        $data['iso'] = RegisIsoDoc::findOrFail($id);
        $data['notify'] = MasterNotify::get();
       

        return view('doc_iso.master-notify.view-iso', $data);
    }

    public function renew(Request $request,$id)
    {
        $data['iso'] = RegisIsoDoc::findOrFail($id);
        $data['notify'] = MasterNotify::get();
         $data['vendor'] = Vendor::get();

        return view('doc_iso.master-notify.renew-iso', $data);
    }

    public function change(Request $request,$id)
    {
        $data['iso'] = RegisIsoDoc::findOrFail($id);
        $data['notify'] = MasterNotify::get();
         $data['vendor'] = Vendor::get();

        return view('doc_iso.master-notify.change-iso', $data);
    }
    public function approve(Request $request,$id)
    {
        $data['iso'] = RegisIsoDoc::findOrFail($id);
        $data['notify'] = MasterNotify::get();
         $data['vendor'] = Vendor::get();

        return view('doc_iso.master-notify.approval-iso', $data);
    }

    public function approval_iso(Request $request)
    {
        // dd($request->exp_date);
        
         $id_user    =auth()->user()->id_user;
            $trn_date   = date('Y-m-d');
            $trn_time   = date('H:i:s');
            $trn_detail = '';
            $ip_addr    = $request->ip();
            

            if (isset($request->approve_doc)){

                $trn_id     = $request->trn_id;
                $doc_year   = $request->doc_year;
                $trn_type   = 'R';
                $id_vendor  = $request->id_vendor;

                $mat_supply = $request->mat_supply;

           
                $exp_date_fm   = $request->exp_date;
                $exp_date      = $exp_date_fm; //check expire date with d-date

                //echo $_POST['simplf'] ;
                if ($request->simplf == "on") {
                    $simply      = 'X';
                } else {
                    $simply      = 'n';
                }

                $date_now = date("Y-m-d"); 
                if (strtotime( $exp_date) > strtotime( $date_now )) {
                   $stat = 'V';
                }else {
                    $stat = 'E';
                }

                //update_trn_reg_iso($trn_id, $doc_year, $trn_type);

                RegisIsoDoc::where('_id',$request->id)
                            ->where('del_indicator','<>','X')
                            ->update(['trn_type' => $trn_type,'stat' => $stat]);

                
                // return redirect()->route('doc-iso.report-iso')->with(['message_success' => 'Berhasil Approve Dokumen ISO.']);
                return redirect()->back()->with(['message_success' => 'Berhasil Approve Dokumen ISO.']);
              
        } else if (isset($request->reject_doc)){

                $trn_id     = $request->trn_id;
                $doc_year   = $request->doc_year;
                $trn_type   = 'C';
                $id_vendor  = $request->id_vendor;

                $mat_supply = $request->mat_supply;

                 $exp_date_fm   = $request->exp_date;
                $exp_date      = $exp_date_fm; //check expire date with d-date

                //echo $_POST['simplf'] ;
                if ($request->simplf == "on") {
                    $simply      = 'X';
                } else {
                    $simply      = '';
                }

                $date_now = date("Y-m-d"); 
                if (strtotime( $exp_date) > strtotime( $date_now )) {
                   $stat = 'V';
                }else {
                    $stat = 'E';
                }

                //update_trn_reg_iso($trn_id, $doc_year, $trn_type);

                RegisIsoDoc::where('_id',$request->id)
                            ->where('del_indicator','<>','X')
                            ->update(['trn_type' => $trn_type,'stat' => $stat]);

                
                return redirect()->back()->with(['message_success' => 'Berhasil Reject Dokumen ISO.']);
              
        }
    }

    public function delete_act(Request $request)
    {

        RegisIsoDoc::where(['_id' => $request->id])
                            ->update(['del_indicator' => "X"]);

        IsoLog::create(['trn_id',
                         'doc_year' => $request->doc_year,
                         'id_user' => auth()->user()->id_user,
                         'trn_type' => $request->doc_year,
                         'trn_date' =>  $request->trn_date,
                         'trn_time' =>  $request->trn_time,
                         'ip_address' => $request->ip(),
                         'trn_detail' =>  $request->trn_detail]);
         return redirect()->back()->with(['message_success' => 'Data has been deleted']);
    }
    public function change_act(Request $request)
    {
        // $request->validate([
        //     // 'username' => 'required|string|unique:users,username,'.$id.',_id',
        //     //'email' => 'required|string',
        //     // 'full_name' => 'required|string',
        // ]);
 // dd(strtotime( $request->exp_date));
       if (strtotime( $request->exp_date) > strtotime(date('Y-m-d'))) {
                $stat = 'W';
            }else{
                $stat = 'E';
            }
        
        $regis_iso_doc = RegisIsoDoc::findOrFail($request->id);
        //$regis_iso_doc->vendor_code = $request->vendor_code;
        $regis_iso_doc->trn_id = $request->trn_id;
        // $regis_iso_doc->id_vendor = $request->id_vendor;
        $regis_iso_doc->doc_year = $request->doc_year;
        $regis_iso_doc->mat_supply = $request->mat_supply;
        $regis_iso_doc->simply = $request->simply ? "X" : "";
        $regis_iso_doc->cert_num = $request->cert_num;
        $regis_iso_doc->cert_date = $request->cert_date;
        $regis_iso_doc->cert_name = $request->cert_name;
        $regis_iso_doc->iso_type_name = $request->iso_type_name;
        $regis_iso_doc->exp_date = $request->exp_date;
        $regis_iso_doc->stat =  $stat;
         if ($request->has("file")){
            $file = $request->file("file");
            $path = public_path('files/regis_iso/');
            $nameFile = date("Ymdhis")."_".$this->remove_illegal_filename($request->cert_num)."_".$request->id_vendor."." . $file->getClientOriginalExtension();

            $regis_iso_doc->doc_path = $nameFile;
        }
        $regis_iso_doc->remark = $request->remark;
        $regis_iso_doc->trn_type = "U";
        $regis_iso_doc->ref_doc = $request->ref_doc;
        $regis_iso_doc->ref_doc_year = $request->ref_doc_year;
        //$regis_iso_doc->created_by = auth()->user()->full_name;
        $regis_iso_doc->changed_by = auth()->user()->id_user;
        $regis_iso_doc->save();
         if ($nameFile ?? false){
            if(!File::isDirectory($path)) File::makeDirectory($path, 0777, true, true);

            $file->move($path, $nameFile);
        }

        return redirect()->route('doc-iso.report-iso')->with(['message_success' => 'Berhasil memperbaharui ISO.']);
    
    }

    public function renewal(Request $request)
    {
        // $request->validate([
        //     // 'username' => 'required|string|unique:users,username,'.$id.',_id',
        //     //'email' => 'required|string',
        //     // 'full_name' => 'required|string',
        // ]);

       
         if (strtotime( $request->exp_date) > strtotime(date('Y-m-d'))) {
                $stat = 'N';
            }else{
                $stat = 'E';
            }
         $doc_type = 'iso';
        $doc_year = date('Y');
        $numRange =  \IsoHelper::get_number_range($doc_type, $doc_year);
        if(empty($numRange))
        {
             return redirect()->back()->with(['message_fail' => 'Please maintain Document Number!']);
        }
        // dd($numRange);

      


        $regis_iso_doc = RegisIsoDoc::findOrFail($request->id);
   
        // $regis_iso_doc->mat_supply = $request->mat_supply;
        // $regis_iso_doc->simply = $request->simply ? "X" : "";
        // $regis_iso_doc->cert_num = $request->cert_num;
        // $regis_iso_doc->cert_date = $request->cert_date;
        // $regis_iso_doc->cert_name = $request->cert_name;
        // $regis_iso_doc->iso_type_name = $request->iso_type_name;
        // $regis_iso_doc->exp_date = $request->exp_date;
        $regis_iso_doc->stat = $stat;
        // $regis_iso_doc->remark = $request->remark;
        $regis_iso_doc->trn_type = "S";
        $regis_iso_doc->ref_doc = str_pad($numRange, 8, 0, STR_PAD_LEFT);
        $regis_iso_doc->ref_doc_year = intval($doc_year);
        //$regis_iso_doc->created_by = auth()->user()->full_name;
        $regis_iso_doc->changed_by = auth()->user()->id_user;
        $regis_iso_doc->save();
        
        
        if (strtotime( $request->exp_date) > strtotime(date('Y-m-d'))) {
                $stat2 = 'W';
            }else{
                $stat2 = 'E';
            }
      
        $regisdata =  RegisIsoDoc::where('_id',$request->id)->first();
      
        $create = new RegisIsoDoc();
        $create->doc_year = intval($doc_year);
        $create->trn_id = str_pad($numRange, 8, 0, STR_PAD_LEFT);
        // $create->vendor_code = $regisdata->vendor_code;
        $create->id_vendor = $regisdata->id_vendor;
        $create->mat_supply = $request->mat_supply;
        $create->simply = $request->simply ? "X" : "";
        $create->cert_num = $request->cert_num;
        $create->cert_date = $request->cert_date;
        $create->cert_name = $request->cert_name;
        $create->iso_type_name = $request->iso_type_name;
        $create->exp_date = $request->exp_date;
        $create->stat = $stat2;
         if ($request->has("file")){
            $file = $request->file("file");
            $path = public_path('files/regis_iso/');
            $nameFile = date("Ymdhis")."_".$this->remove_illegal_filename($request->cert_num)."_".$request->id_vendor."." . $file->getClientOriginalExtension();

            $create->doc_path = $nameFile;
        }
        $create->remark = $request->remark;
        $create->trn_type = "S";
        $create->ref_doc = '';
        $create->last_ref_doc = $regisdata->trn_id;
        $create->last_doc_year = $regisdata->doc_year;
        $create->ref_doc_year = '';
        //$create->created_by = auth()->user()->full_name;
        $create->changed_by = auth()->user()->id_user;
        $create->save();
         \IsoHelper::update_number_range($doc_type, $doc_year);
         if ($nameFile ?? false){
            if(!File::isDirectory($path)) File::makeDirectory($path, 0777, true, true);

            $file->move($path, $nameFile);
        }

        return redirect()->route('doc-iso.report-iso')->with(['message_success' => 'Berhasil memperbaharui data.']);
    
    }

    public function store(Request $request)
    {
        // dd($request->id_vendor, $request);
        // $request->validate([
        //     // 'username' => 'required|string|unique:users,username,'.$id.',_id',
        //     //'email' => 'required|string',
        //     // 'full_name' => 'required|string',
        // ]);
        $doc_type = 'iso';
        $doc_year = date('Y');
        $numRange =  \IsoHelper::get_number_range($doc_type, $doc_year);
        if(empty($numRange))
        {
             return redirect()->back()->with(['message_fail' => 'Please maintain Document Number!']);
        }
        $regis_iso_doc = new RegisIsoDoc;

        if ($request->has("file")){
            $file = $request->file("file");
            $path = public_path('files/regis_iso/');
            $nameFile = date("Ymdhis")."_".$this->remove_illegal_filename($request->cert_num)."_".$request->id_vendor."." . $file->getClientOriginalExtension();

            $regis_iso_doc->doc_path = $nameFile;
        }


        $regis_iso_doc->doc_year =  intval(date('Y'));
        $regis_iso_doc->trn_id = str_pad($numRange, 8, 0, STR_PAD_LEFT);
        $regis_iso_doc->id_vendor = $request->id_vendor;
        $regis_iso_doc->mat_supply = $request->mat_supply;
        $regis_iso_doc->simply = $request->simply ? "X" : "";
        $regis_iso_doc->cert_name = $request->cert_name;
        $regis_iso_doc->iso_type_name = $request->iso_type_name;
        $regis_iso_doc->cert_num = $request->cert_num;
        $regis_iso_doc->cert_date = $request->cert_date;
        $regis_iso_doc->exp_date = $request->exp_date;
        $regis_iso_doc->remark = $request->remark;

        $regis_iso_doc->stat = 'W';
        $regis_iso_doc->trn_type = 'S';
        $regis_iso_doc->ref_doc = '';
        $regis_iso_doc->ref_doc_year = '';
        $regis_iso_doc->cr_by = Auth::user()->id_user;
        $regis_iso_doc->cr_dat = date('Y-m-d h:i:s');
        $regis_iso_doc->save();
        \IsoHelper::update_number_range($doc_type, $doc_year);
        if ($nameFile ?? false){
            if(!File::isDirectory($path)) File::makeDirectory($path, 0777, true, true);

            $file->move($path, $nameFile);
        }
        

        return redirect()->route('doc-iso.report-iso')->with(['message_success' => 'Berhasil menambah data.']);
    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     // 'username' => 'required|string|unique:users,username,'.$id.',_id',
        //     //'email' => 'required|string',
        //     // 'full_name' => 'required|string',
        // ]);

          if (strtotime( $request->exp_date) > strtotime(date('Y-m-d'))) {
                $stat = 'W';
            }else{
                $stat = 'E';
            }
        $regis_iso_doc = RegisIsoDoc::findOrFail($id);
        //$regis_iso_doc->vendor_code = $request->vendor_code;
        // $regis_iso_doc->trn_id = $request->trn_id;
        $regis_iso_doc->id_vendor = $request->id_vendor;
        // $regis_iso_doc->doc_year = $request->doc_year;
        $regis_iso_doc->mat_supply = $request->mat_supply;
        $regis_iso_doc->simply = $request->simply;
        $regis_iso_doc->cert_num = $request->cert_num;
        $regis_iso_doc->cert_date = $request->cert_date;
        $regis_iso_doc->cert_name = $request->cert_name;
        $regis_iso_doc->iso_type_name = $request->iso_type_name;
        $regis_iso_doc->exp_date = $request->exp_date;
        $regis_iso_doc->stat = $request->stat;
        $regis_iso_doc->doc_path = $request->doc_path;
        $regis_iso_doc->remark = $request->remark;
        $regis_iso_doc->trn_type = "U";
         if ($request->has("file")){
            $file = $request->file("file");
            $path = public_path('files/regis_iso/');
            $nameFile = date("Ymdhis")."_".$this->remove_illegal_filename($request->cert_num)."_".$request->id_vendor."." . $file->getClientOriginalExtension();

            $regis_iso_doc->doc_path = $nameFile;
        }

        // $regis_iso_doc->ref_doc = $request->ref_doc;
        // $regis_iso_doc->ref_doc_year = $request->ref_doc_year;
        //$regis_iso_doc->created_by = auth()->user()->full_name;
        $regis_iso_doc->changed_by = auth()->user()->full_name;
        $regis_iso_doc->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Data updated successfully!'
        ], 201);
    }

    public function destroy($id)
    {
        $regis_iso_doc = RegisIsoDoc::findOrFail($id);
        $regis_iso_doc->delete();

        return response()->json([
            'type' => 'success',
            'message' => 'Data Deleted Successfully!'
        ], 201);
    }

    private function remove_illegal_filename($str)
    {
        $res = str_replace(array('\\','/',':','*','?','"','<','>','|'),'-',$str);

        return $res;
    }
}
