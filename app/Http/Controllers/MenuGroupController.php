<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuGroup;

class MenuGroupController extends Controller
{
    public function index(Request $request)
    {
        $skip = $request->perpage * ($request->page - 1);
        $menu_group = MenuGroup::where(function($where) use ($request){
            
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

        $total = MenuGroup::where(function($where) use ($request){
            
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
            'data' => $menu_group,
            'total' => $total
        ], 200);
    }

    public function show(Request $request, $id)
    {
        $menu_group = MenuGroup::findOrFail($id);

        return response()->json([
            'type' => 'success',
            'data' =>  $menu_group
        ]);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     // 'username' => 'required|string|unique:users,username,'.$id.',_id',
        //     //'email' => 'required|string',
        //     // 'full_name' => 'required|string',
        // ]);

        $menu_group = new MenuGroup;
        $menu_group->id_menu = $request->id_menu;
        $menu_group->menu_group_name = $request->menu_group_name;
        $menu_group->menu_group_object = $request->menu_group_object;
        $menu_group->object_path = $request->object_path;
        $menu_group->status = $request->status;
        $menu_group->assigned = $request->assigned;
        $menu_group->created_by = auth()->user()->full_name;
        //$menu_group->changed_by = auth()->user()->full_name;
        $menu_group->save();

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

        $menu_group = MenuGroup::findOrFail($id);
        $menu_group->id_menu = $request->id_menu;
        $menu_group->menu_group_name = $request->menu_group_name;
        $menu_group->menu_group_object = $request->menu_group_object;
        $menu_group->object_path = $request->object_path;
        $menu_group->status = $request->status;
        $menu_group->assigned = $request->assigned;
        $menu_group->created_by = auth()->user()->full_name;
        //$menu_group->changed_by = auth()->user()->full_name;
        $menu_group->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Data created successfully!'
        ], 201);
    }

    public function destroy($id)
    {
        $menu_group = MenuGroup::findOrFail($id);
        $menu_group->delete();

        return response()->json([
            'type' => 'success',
            'message' => 'Data Deleted Successfully!'
        ], 201);
    }
}
