<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegisIsoDoc;
use App\Models\Vendor;
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
        $regis_iso_doc = RegisIsoDoc::findOrFail($id);

        return response()->json([
            'type' => 'success',
            'data' =>  $regis_iso_doc
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->id_vendor, $request);
        // $request->validate([
        //     // 'username' => 'required|string|unique:users,username,'.$id.',_id',
        //     //'email' => 'required|string',
        //     // 'full_name' => 'required|string',
        // ]);

        $regis_iso_doc = new RegisIsoDoc;

        if ($request->has("file")){
            $file = $request->file("file");
            $path = 'files/regis_iso/';
            $nameFile = md5($file->getClientOriginalName(). rand(rand(231, 992), 123882)). "." . $file->getClientOriginalExtension();

            $regis_iso_doc->doc_path = $path.$nameFile;
        }
    

        $regis_iso_doc->doc_year = date('Y');
        $regis_iso_doc->id_vendor = $request->id_vendor;
        $regis_iso_doc->mat_supply = $request->mat_supply;
        $regis_iso_doc->simply = $request->simply ? true : false;
        $regis_iso_doc->cert_name = $request->cert_name;
        $regis_iso_doc->iso_type_name = $request->iso_type_name;
        $regis_iso_doc->cert_num = $request->cert_num;
        $regis_iso_doc->cert_date = $request->cert_date;
        $regis_iso_doc->exp_date = $request->exp_date;
        $regis_iso_doc->remark = $request->remark;

        $regis_iso_doc->stat = 'v';
        $regis_iso_doc->trn_type = '';
        $regis_iso_doc->ref_doc = '';
        $regis_iso_doc->ref_doc_year = '';
        $regis_iso_doc->cr_by = Auth::user()->nm_user;
        $regis_iso_doc->cr_dat = date('Y-m-d h:i:s');
        $regis_iso_doc->save();

        if ($nameFile ?? false){
            if(!File::isDirectory($path)) File::makeDirectory($path, 0755, true, true);

            $file->move($path, $nameFile);
        }
        

        return redirect()->back()->with(['message_success' => 'Berhasil menambah data.']);
    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     // 'username' => 'required|string|unique:users,username,'.$id.',_id',
        //     //'email' => 'required|string',
        //     // 'full_name' => 'required|string',
        // ]);

        $regis_iso_doc = RegisIsoDoc::findOrFail($id);
        //$regis_iso_doc->vendor_code = $request->vendor_code;
        $regis_iso_doc->trn_id = $request->trn_id;
        $regis_iso_doc->id_vendor = $request->id_vendor;
        $regis_iso_doc->doc_year = $request->doc_year;
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
        $regis_iso_doc->trn_type = $request->trn_type;
        $regis_iso_doc->ref_doc = $request->ref_doc;
        $regis_iso_doc->ref_doc_year = $request->ref_doc_year;
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
}
