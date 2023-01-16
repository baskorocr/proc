<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegisIsoDoc;

class RegisIsoDocController extends Controller
{
    public function index(Request $request)
    {
        $skip = $request->perpage * ($request->page - 1);
        $regis_iso_doc = RegisIsoDoc::where(function($where) use ($request){
            
                        if (!empty($request->keyword)) {
                            foreach ($request->columns as $index => $column) {
                                if ($index == 0) {
                                    $where->where($column, 'like', '%'.$request->keyword.'%');
                                } else {
                                    $where->orWhere($column, 'like', '%'.$request->keyword.'%');
                                }
                            }
                                
                        }

                    })
                    ->when(!empty($request->sort), function($query) use ($request){
                        $query->orderBy($request->sort, $request->order == 'ascend' ? 'asc' : 'desc');
                    })
                    ->take((int)$request->perpage)
                    ->skip((int)$skip)
                    ->get();

        $total = RegisIsoDoc::where(function($where) use ($request){
            
            if (!empty($request->keyword)) {
                foreach ($request->columns as $index => $column) {
                    if ($index == 0) {
                        $where->where($column, 'like', '%'.$request->keyword.'%');
                    } else {
                        $where->orWhere($column, 'like', '%'.$request->keyword.'%');
                    }
                }
                    
            }

        })
        ->count();

        return response()->json([
            'type' => 'success',
            'data' => $regis_iso_doc,
            'total' => $total
        ], 200);
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
        // $request->validate([
        //     // 'username' => 'required|string|unique:users,username,'.$id.',_id',
        //     //'email' => 'required|string',
        //     // 'full_name' => 'required|string',
        // ]);

        $regis_iso_doc = new RegisIsoDoc;
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
        $regis_iso_doc->created_by = auth()->user()->full_name;
        //$regis_iso_doc->changed_by = auth()->user()->full_name;
        $regis_iso_doc->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Data created successfully!'
        ], 201);
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
