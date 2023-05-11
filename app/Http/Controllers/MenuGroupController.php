<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuGroup;

class MenuGroupController extends Controller
{
    public function editGroup($id)
    {
        $data = MenuGroup::findOrFail($id);
        return view('regis_user/menu-group/edit')->with(['group' => $data]);
    } 

    public function getMenuGroup()
    {
        $data = MenuGroup::all();
        return view('regis_user/menu-group/index')->with(['group' => $data]);
    }

    public function getDataMenuGroup()
    {
        $data = MenuGroup::get();

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
                return  view('regis_user/menu-group/buttons')->with(['data' => $data]);
            })
            ->editColumn('number', function ($data) {
                return 1;
            })
             ->addColumn('status', function ($data) {
             
                if($data->mg_status == "A")
                {
                   
                    $status = "<small><span class=\"badge bg-success\">Active</span></small>";
                } elseif($data->mg_status=='N') {
                    $status = "<small><span class=\"badge bg-warning\"> Non-Active</span></small>";
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
            ->editColumn('last_changed_by', function ($data) {
              return @$data->users->nm_user;
                
            })
            ->editColumn('last_changed', function ($data) {                    
                return date('d.m.Y H:i:s',strtotime($data->last_changed));
            })->rawColumns(['action','status','assigned'])->addIndexColumn()->make(true);
    }


    public function index(Request $request){
        $skip = $request->perpage * ($request->page - 1);
        $index = MenuGroup::when(!empty($request->order_by), function($query) use ($request){
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

        $menu_group = (clone $index)->take((int)$request->perpage)
            ->skip((int)$skip)
            ->get();

        $total = (clone $index)->count();

        return response()->json([
            'type' => 'success',
            'data' => $menu_group,
            'total' => $total
        ], 200);

    }

    public function store(Request $request){
        $menu_group = new MenuGroup;
        $menu_group->menu_group_name = $request->menu_group_name;
        $menu_group->menu_group_object = $request->menu_group_object;
        $menu_group->created_by = auth()->user()->full_name;
        $menu_group->save();

        return response()->json([
            'message' => 'data created has been successfully',
            'type' => 'success'
        ], 201);
    }

    public function show($id){
        $menu_group = MenuGroup::find($id);
        return response()->json([
            'type' => 'success',
            'data' => $menu_group
        ], 200);
    }

    public function updateGroup(Request $request){
        
        $menu_group = MenuGroup::find($request->id);
        // dd($menu_group, $request);
        $menu_group->menu_group_name = $request->menu_group_name;
        $menu_group->menu_group_object = $request->menu_group_object;
        $menu_group->save();

        return redirect()->route('regis-user.menu-group')->with(['message_success' => 'Berhasil mengubah data.']);
    }

    public function deleteGroup($id){
        $menu_group = MenuGroup::find($id);
        $menu_group->delete();

        return redirect()->route('regis-user.menu-group')->with(['message_success' => 'Berhasil menghapus data.']);
    }
}
