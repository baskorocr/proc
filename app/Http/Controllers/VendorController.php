<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use Maatwebsite\Excel\Facades\Excel;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $skip = $request->perpage * ($request->page - 1);
        $vendor = Vendor::where(function($where) use ($request){
            
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

        $total = Vendor::where(function($where) use ($request){
            
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
            'data' => $vendor,
            'total' => $total
        ], 200);
    }

    public function show(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);

        return response()->json([
            'type' => 'success',
            'data' =>  $vendor
        ]);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     // 'username' => 'required|string|unique:users,username,'.$id.',_id',
        //     //'email' => 'required|string',
        //     // 'full_name' => 'required|string',
        // ]);

        $vendor = new Vendor;
        //$vendor->vendor_code = $request->vendor_code;
        $vendor->id_vendor = $request->id_vendor;
        $vendor->purch_org = $request->purch_org;
        $vendor->nm_vendor = $request->nm_vendor;
        $vendor->vend_email = $request->vend_email;
        $vendor->allias = $request->allias;
        $vendor->street = $request->street;
        $vendor->district = $request->district;
        $vendor->postal_code = $request->postal_code;
        $vendor->city = $request->city;
        $vendor->country = $request->country;
        $vendor->region = $request->region;
        $vendor->phone_1 = $request->phone_1;
        $vendor->vat_reg = $request->vat_reg;
        $vendor->order_curr = $request->order_curr;
        $vendor->pay_term = $request->pay_term;
        $vendor->sales_person = $request->sales_person;
        $vendor->phone_2 = $request->phone_2;
        $vendor->status_vendor = $request->status_vendor;
        $vendor->created_by = auth()->user()->full_name;
        $vendor->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Data updated successfully!'
        ], 201);
    }

    // public function showGetVendor(Request $request, $vendor_code)
    // {
    //     $vendor = Vendor::where('vendor_code', $vendor_code)->first();

    //     return response()->json([
    //         'type' => 'success',
    //         'data' =>  $vendor
    //     ]);
    // }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     // 'username' => 'required|string|unique:users,username,'.$id.',_id',
        //     //'email' => 'required|string',
        //     // 'full_name' => 'required|string',
        // ]);

        $vendor = Vendor::findOrFail($id);
        //$vendor->vendor_code = $request->vendor_code;
        $vendor->id_vendor = $request->id_vendor;
        $vendor->purch_org = $request->purch_org;
        $vendor->nm_vendor = $request->nm_vendor;
        $vendor->vend_email = $request->vend_email;
        $vendor->allias = $request->allias;
        $vendor->street = $request->street;
        $vendor->district = $request->district;
        $vendor->postal_code = $request->postal_code;
        $vendor->city = $request->city;
        $vendor->country = $request->country;
        $vendor->region = $request->region;
        $vendor->phone_1 = $request->phone_1;
        $vendor->vat_reg = $request->vat_reg;
        $vendor->order_curr = $request->order_curr;
        $vendor->pay_term = $request->pay_term;
        $vendor->sales_person = $request->sales_person;
        $vendor->phone_2 = $request->phone_2;
        $vendor->status_vendor = $request->status_vendor;
        // $vendor->created_by = auth()->user()->full_name;
        $vendor->changed_by = auth()->user()->full_name;
        $vendor->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Data updated successfully!'
        ], 201);
    }

    public function list(Request $request)
    {
        $vendors = Vendor::when($request->keyword, function($query) use ($request) {
                        if (!empty($request->keyword)) {
                            $query->where('vendor_name', 'like', '%'.$request->keyword.'%');
                        }
                    })->take(10)
                    ->get();

        return response()->json([
        'type' => 'success',
        'data' => $vendors
        ], 200);
    }

    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();

        return response()->json([
            'type' => 'success',
            'message' => 'Data Deleted Successfully!'
        ], 201);
    }

    // public function import(Request $request)
    // {

    //     $file = $request->file('file');

    //     Excel::import(new VendorImport, $file, \Maatwebsite\Excel\Excel::XLSX);

    //     return response()->json([
    //         'type' => 'success',
    //         //'message' => trans('message.import_success')
    //         'message' => 'Data Import Successfully'
    //     ]);
    // }

    // public function download(Request $request)
    // {
    //     return Excel::download(new SupplierExport($request), 'data_vendor.xlsx',\Maatwebsite\Excel\Excel::XLSX);

    // }
}
