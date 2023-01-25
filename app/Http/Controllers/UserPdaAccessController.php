<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPdaAccess;

class UserPdaAccessController extends Controller
{
    public function index(Request $request)
    {
        $skip = $request->perpage * ($request->page - 1);
        $user_pda_access = UserPdaAccess::where(function($where) use ($request){
            
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

        $total = UserPdaAccess::where(function($where) use ($request){
            
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
            'data' => $user_pda_access,
            'total' => $total
        ], 200);
    }

    public function show(Request $request, $id)
    {
        $user_pda_access = UserPdaAccess::findOrFail($id);

        return response()->json([
            'type' => 'success',
            'data' =>  $user_pda_access
        ]);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     // 'username' => 'required|string|unique:users,username,'.$id.',_id',
        //     //'email' => 'required|string',
        //     // 'full_name' => 'required|string',
        // ]);

        $user_pda_access = new UserPdaAccess;
        $user_pda_access->username = $request->username;
        $user_pda_access->id_user = $request->id_user;
        $user_pda_access->pin = $request->pin;
        $user_pda_access->full_name = $request->full_name;
        $user_pda_access->created_by = auth()->user()->full_name;
        //$user_pda_access->changed_by = auth()->user()->full_name;
        $user_pda_access->save();

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

        $user_pda_access = UserPdaAccess::findOrFail($id);
        $user_pda_access->username = $request->username;
        $user_pda_access->id_user = $request->id_user;
        $user_pda_access->pin = $request->pin;
        $user_pda_access->full_name = $request->full_name;
        //$user_pda_access->created_by = auth()->user()->full_name;
        $user_pda_access->changed_by = auth()->user()->full_name;
        $user_pda_access->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Data created successfully!'
        ], 201);
    }

    public function destroy($id)
    {
        $user_pda_access = UserPdaAccess::findOrFail($id);
        $user_pda_access->delete();

        return response()->json([
            'type' => 'success',
            'message' => 'Data deleted Successfully!'
        ], 201);
    }
}
