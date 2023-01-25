<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccessGroupList;

class AccessGroupListController extends Controller
{
    public function index(Request $request)
    {
        $skip = $request->perpage * ($request->page - 1);
        $access_group_list = AccessGroupList::where(function($where) use ($request){
            
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

        $total = AccessGroupList::where(function($where) use ($request){
            
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
            'data' => $access_group_list,
            'total' => $total
        ], 200);
    }

    public function show(Request $request, $id)
    {
        $access_group_list = AccessGroupList::findOrFail($id);

        return response()->json([
            'type' => 'success',
            'data' =>  $access_group_list
        ]);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     // 'username' => 'required|string|unique:users,username,'.$id.',_id',
        //     //'email' => 'required|string',
        //     // 'full_name' => 'required|string',
        // ]);

        $access_group_list = new AccessGroupList;
        $access_group_list->id_menu = $request->id_menu;
        $access_group_list->access_group_name = $request->access_group_name;
        $access_group_list->status = $request->status;
        $access_group_list->assigned = $request->assigned;
        $access_group_list->created_by = auth()->user()->full_name;
        //$access_group_list->changed_by = auth()->user()->full_name;
        $access_group_list->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Data created successfully!'
        ], 201);
    }

    public function update(Request $request)
    {
        // $request->validate([
        //     // 'username' => 'required|string|unique:users,username,'.$id.',_id',
        //     //'email' => 'required|string',
        //     // 'full_name' => 'required|string',
        // ]);

        $access_group_list = AccessGroupList::findOrFail($id);
        $access_group_list->id_menu = $request->id_menu;
        $access_group_list->access_group_name = $request->access_group_name;
        $access_group_list->status = $request->status;
        $access_group_list->assigned = $request->assigned;
        $access_group_list->changed_by = auth()->user()->full_name;
        $access_group_list->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Data updated successfully!'
        ], 201);
    }

    public function destroy($id)
    {
        $access_group_list = AccessGroupList::findOrFail($id);
        $access_group_list->delete();

        return response()->json([
            'type' => 'success',
            'message' => 'Data Deleted Successfully!'
        ], 201);
    }
}
