<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterVendor;

class MasterVendorController extends Controller
{

    public function editVendor($id)
    {
        $data = MasterVendor::findOrFail($id);
        return view('regis_user/master-vendor/edit')->with(['vendor' => $data]);
    } 

    public function getMasterVendor()
    {
        $data = MasterVendor::all();
        return view('regis_user/master-vendor/index')->with(['vendor' => $data]);
    }

    public function getDataMasterVendor()
    {
        $data = MasterVendor::get();

        return \DataTables::of($data)
            ->editColumn('uom', function ($data) {
                if (@$data->uom === "D") {
                    return "Days";
                } else {

                    return 'Months';
                }
            })
            ->editColumn('cr_by', function ($data) {
                return @$data->users->nm_user;
            })
            ->editColumn('action', function ($data) {
                return  view('regis_user/master-vendor/buttons')->with(['data' => $data]);
            })
            ->editColumn('number', function ($data) {
                return 1;
            })
            ->editColumn('status_vendor', function ($data) {
                 if($data->status_vendor == "A")
                {
                   
                    $status = "<small><span class=\"badge bg-success\">Active</span></small>";
                } elseif($data->status_vendor=='N') {
                    $status = "<small><span class=\"badge bg-warning\"> Non-Active</span></small>";
                } else{
                    $status = "<small><span class=\"badge bg-secondary\"> N/A</span></small>";
                }

                return $status;
            })
            ->editColumn('last_changed', function ($data) {                    
                return date('d.m.Y H:i:s',strtotime($data->last_changed));
            })->rawColumns(['action','status_vendor'])->addIndexColumn()->make(true);
    }


    public function index(Request $request){
        $skip = $request->perpage * ($request->page - 1);
        $index = MasterVendor::when(!empty($request->order_by), function($query) use ($request){
            foreach($request->order_by as $order_by) {
                $json = json_decode($order_by);
                $query->orderBy($json->field, $json->order === 'ascend' ? 'asc' : 'desc');
            }
        })
        ->where(function($query) use ($request){
            if (!empty($request->search)) {
                foreach ($request->search as $search) {
                    $json = json_decode($search);
                    $query->where($json->columns, 'like', '%'.$json->searchText.'%');
                    $query->where($json->columns, 'like', '%'.$json->searchText.'%');
                }
            }
        })
        ->where(function($where) use ($request){
            if (!empty($request->keyword)) {
                foreach ($request->columns as $index => $column) {
                    if ($index == 0) {
                        $where->where($column, 'like', '%'.$request->keyword.'%');
                    } else {
                        $where->orWhere($column, 'like', '%'.$request->keyword.'%');
                    }
                }
            }
        });

        $master_vendor = (clone $index)->take((int)$request->perpage)
            ->skip((int)$skip)
            ->get();

        $total = (clone $index)->count();

        return response()->json([
            'type' => 'success',
            'data' => $master_vendor,
            'total' => $total
        ], 200);

    }

    public function store(Request $request){
        $master_vendor = new MasterVendor;
        $master_vendor->id_vendor = $request->id_vendor;
        $master_vendor->nm_vendor = $request->nm_vendor;
        $master_vendor->alias = $request->alias;
        $master_vendor->street = $request->street;
        $master_vendor->district = $request->district;
        $master_vendor->postal_code = $request->postal_code;
        $master_vendor->city = $request->city;
        $master_vendor->country = $request->country;
        $master_vendor->region = $request->region;
        $master_vendor->phone_1 = $request->phone_1;
        $master_vendor->vat_reg = $request->vat_reg;
        $master_vendor->order_curr = $request->order_curr;
        $master_vendor->pay_term = $request->pay_term;
        $master_vendor->sales_person = $request->sales_person;
        $master_vendor->phone_2 = $request->phone_2;
        $master_vendor->status_vendor = $request->status_vendor;
        $master_vendor->created_by = auth()->user()->full_name;
        $master_vendor->save();

        return response()->json([
            'message' => 'data created has been successfully',
            'type' => 'success'
        ], 201);
    }

    public function show($id){
        $master_vendor = MasterVendor::find($id);
        return response()->json([
            'type' => 'success',
            'data' => $master_vendor
        ], 200);
    }

    public function updateVendor(Request $request){
        
        $master_vendor = MasterVendor::find($request->id);
        // dd($master_vendor, $request);
        $master_vendor->id_vendor = $request->id_vendor;
        $master_vendor->nm_vendor = $request->nm_vendor;
        $master_vendor->alias = $request->alias;
        $master_vendor->street = $request->street;
        $master_vendor->district = $request->district;
        $master_vendor->postal_code = $request->postal_code;
        $master_vendor->city = $request->city;
        $master_vendor->country = $request->country;
        $master_vendor->region = $request->region;
        $master_vendor->phone_1 = $request->phone_1;
        $master_vendor->vat_reg = $request->vat_reg;
        $master_vendor->order_curr = $request->order_curr;
        $master_vendor->pay_term = $request->pay_term;
        $master_vendor->sales_person = $request->sales_person;
        $master_vendor->phone_2 = $request->phone_2;
        $master_vendor->status_vendor = $request->status_vendor;
        $master_vendor->role = $request->role;
        $master_vendor->save();

        return redirect()->route('regis-user.master-vendor')->with(['message_success' => 'Berhasil mengubah data.']);
    }

    public function deleteVendor($id){
        $master_vendor = MasterVendor::find($id);
        $master_vendor->delete();

        return redirect()->route('regis-user.master-vendor')->with(['message_success' => 'Berhasil menghapus data.']);
    }
}