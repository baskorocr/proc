<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuList;

class MenuListController extends Controller
{
    public function index(Request $request)
    {
        $skip = $request->perpage * ($request->page - 1);
        $menu_list = MenuList::where(function($where) use ($request){
            
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

        $total = MenuList::where(function($where) use ($request){
            
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
            'data' => $menu_list,
            'total' => $total
        ], 200);
    }

    public function show(Request $request, $id)
    {
        $menu_list = MenuList::findOrFail($id);

        return response()->json([
            'type' => 'success',
            'data' =>  $menu_list
        ]);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     // 'username' => 'required|string|unique:users,username,'.$id.',_id',
        //     //'email' => 'required|string',
        //     // 'full_name' => 'required|string',
        // ]);

        $menu_list = new MenuList;
        $menu_list->id_menu = $request->id_menu;
        $menu_list->menu_name = $request->menu_name;
        $menu_list->menu_object = $request->menu_object;
        $menu_list->object_path = $request->object_path;
        $menu_list->status = $request->status;
        $menu_list->assigned = $request->assigned;
        $menu_list->created_by = auth()->user()->full_name;
        //$menu_list->changed_by = auth()->user()->full_name;
        $menu_list->save();

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

        $menu_list = MenuList::findOrFail($id);
        $menu_list->id_menu = $request->id_menu;
        $menu_list->menu_name = $request->menu_name;
        $menu_list->menu_object = $request->menu_object;
        $menu_list->object_path = $request->object_path;
        $menu_list->status = $request->status;
        $menu_list->assigned = $request->assigned;
        $menu_list->changed_by = auth()->user()->full_name;
        $menu_list->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Data updated successfully!'
        ], 201);
    }

    public function destroy($id)
    {
        $menu_list = MenuList::findOrFail($id);
        $menu_list->delete();

        return response()->json([
            'type' => 'success',
            'message' => 'Data Deleted Successfully!'
        ], 201);
    }
}
