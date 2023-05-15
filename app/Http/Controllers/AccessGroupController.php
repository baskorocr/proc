<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccessGroup;

class AccessGroupController extends Controller
{

    public function editAccess($id)
    {
        $data = AccessGroup::findOrFail($id);
        return view('regis_user/access-group/edit')->with(['access' => $data]);
    } 

    public function getAccessGroup()
    {
        $data = AccessGroup::all();
        return view('regis_user/access-group/index')->with(['access' => $data]);
    }

    public function getDataAccessGroup()
    {
        $data = AccessGroup::get();

        return \DataTables::of($data)
            ->editColumn('uom', function ($data) {
                if (@$data->uom === "D") {
                    return "Days";
                } else {

                    return 'Months';
                }
            })
            ->editColumn('last_changed_by', function ($data) {
                return @$data->users->nm_user;
            })
            ->editColumn('action', function ($data) {
                return  view('regis_user/access-group/buttons')->with(['data' => $data]);
            })

             ->addColumn('status', function ($data) {
             
                if($data->ag_status == "A")
                {
                   
                    $status = "<small><span class=\"badge bg-success\">Active</span></small>";
                } elseif($data->ag_status=='N') {
                    $status = "<small><span class=\"badge bg-primary\"> Non-Active</span></small>";
                } else{
                    $status = "<small><span class=\"badge bg-secondary\"> N/A</span></small>";
                }

                return $status;
                
            })
            ->editColumn('assigned', function ($data) {
              if ($data->assigned == 'Y'){
                        $status = "<small class='badge bg-success'> Assigned</small>";
                    }elseif ($data->assigned == 'N') {
                        $status = "<small class='badge bg-warning'> Not-Assigned</small>";
                    }else{
                    $status = "<small><span class=\"badge bg-secondary\"> N/A</span></small>";
                }

                return $status;
                
            })
            ->editColumn('number', function ($data) {
                return 1;
            })
            ->editColumn('last_changed', function ($data) {                    
                return date('d.m.Y H:i:s',strtotime($data->last_changed));
            })->rawColumns(['action','status','assigned'])->addIndexColumn()->make(true);
    }


    public function index(Request $request){
        $skip = $request->perpage * ($request->page - 1);
        $index = AccessGroup::when(!empty($request->order_by), function($query) use ($request){
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

        $access_group = (clone $index)->take((int)$request->perpage)
            ->skip((int)$skip)
            ->get();

        $total = (clone $index)->count();

        return response()->json([
            'type' => 'success',
            'data' => $access_group,
            'total' => $total
        ], 200);

    }

    public function store(Request $request){
        $access_group = new AccessGroup;
        $access_group_name->access_group_name = $request->access_group_name;
        $access_group->created_by = auth()->user()->full_name;
        $access_group->save();

        return response()->json([
            'message' => 'data created has been successfully',
            'type' => 'success'
        ], 201);
    }

    public function show($id){
        $access_group = AccessGroup::find($id);
        return response()->json([
            'type' => 'success',
            'data' => $access_group
        ], 200);
    }

    public function updateAccess(Request $request){
        
        $access_group = AccessGroup::find($request->id);
        // dd($access_group, $request);
        $access_group->access_group_name = $request->access_group_name;
        $access_group->save();

        return redirect()->route('regis-user.access-group')->with(['message_success' => 'Berhasil mengubah data.']);
    }

    public function deleteAccess($id){
        $access_group = AccessGroup::find($id);
        $access_group->delete();

        return redirect()->route('regis-user.access-group')->with(['message_success' => 'Berhasil menghapus data.']);
    }
}