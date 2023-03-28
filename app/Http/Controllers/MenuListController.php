<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuList;

class MenuListController extends Controller
{

    public function editList($id)
    {
        $data = MenuList::findOrFail($id);
        return view('regis_user/menu-list/edit')->with(['list' => $data]);
    } 

    public function getMenuList()
    {
        $data = MenuList::all();
        return view('regis_user/menu-list/index')->with(['list' => $data]);
    }

    public function getDataMenuList()
    {
        $data = MenuList::get();

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
                return  view('regis_user/menu-list/buttons')->with(['data' => $data]);
            }) 
            ->addColumn('status', function ($data) {
             
                if($data->mn_status == "A")
                {
                   
                    $status = "<small><span class=\"badge bg-success\">Active</span></small>";
                } elseif($data->mn_status=='N') {
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
            
            ->editColumn('last_changed_by', function ($data) {
              return @$data->users->nm_user;
                
            })
            ->editColumn('last_changed', function ($data) {                    
                return date('d.m.Y H:i:s',strtotime($data->last_changed));
            })->rawColumns(['action','status','assigned'])->addIndexColumn()->make(true);
    }


    public function index(Request $request){
        $skip = $request->perpage * ($request->page - 1);
        $index = MenuList::when(!empty($request->order_by), function($query) use ($request){
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

        $menu_list = (clone $index)->take((int)$request->perpage)
            ->skip((int)$skip)
            ->get();

        $total = (clone $index)->count();

        return response()->json([
            'type' => 'success',
            'data' => $menu_list,
            'total' => $total
        ], 200);

    }

    public function listAdd(Request $request){
        $menu_list = new MenuList;
        $menu_list->menu_name = $request->menu_name;
        $menu_list->menu_object = $request->menu_object;
        $menu_list->object_path = $request->object_path;
        $menu_list->created_by = auth()->user()->full_name;
        $menu_list->save();

        return response()->json([
            'message' => 'data created has been successfully',
            'type' => 'success'
        ], 201);
    }

    public function show($id){
        $menu_list = MenuList::find($id);
        return response()->json([
            'type' => 'success',
            'data' => $menu_list
        ], 200);
    }

    public function updateList(Request $request){
        
        $menu_list = MenuList::find($request->id);
        // dd($menu_list, $request);
        $menu_list->menu_name = $request->menu_name;
        $menu_list->menu_object = $request->menu_object;
        $menu_list->object_path = $request->object_path;
        $menu_list->save();

        return redirect()->route('regis-user.menu-list')->with(['message_success' => 'Berhasil mengubah data.']);
    }

    public function deleteList($id){
        $menu_list = MenuList::find($id);
        $menu_list->delete();

        return redirect()->route('regis-user.menu-list')->with(['message_success' => 'Berhasil menghapus data.']);
    }
}
