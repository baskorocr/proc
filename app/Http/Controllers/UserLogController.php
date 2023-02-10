<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLog;

class UserLogController extends Controller
{
    public function index(Request $request)
    {
        $skip = $request->perpage * ($request->page - 1);
        $user_log = UserLog::where(function($where) use ($request){
            
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

        $total = UserLog::where(function($where) use ($request){
            
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
            'data' => $user_log,
            'total' => $total
        ], 200);
    }

    public function show(Request $request, $id)
    {
        $user_log = UserLog::findOrFail($id);

        return response()->json([
            'type' => 'success',
            'data' =>  $user_log
        ]);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     // 'username' => 'required|string|unique:users,username,'.$id.',_id',
        //     //'email' => 'required|string',
        //     // 'full_name' => 'required|string',
        // ]);

        $user_log = new UserLog;
        $user_log->username = $request->username;
        $user_log->ip_address = $request->ip_address;
        $user_log->activity = $request->activity;
        $user_log->last_activity = $request->last_activity;
        $user_log->attempt = $request->attempt;
        $user_log->user_type = $request->user_type;
        $user_log->status = $request->status;
        $user_log->created_by = auth()->user()->full_name;
        //$user_log->changed_by = auth()->user()->full_name;
        $user_log->save();

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

        $user_log = UserLog::findOrFail($id);
        $user_log->username = $request->username;
        $user_log->ip_address = $request->ip_address;
        $user_log->activity = $request->activity;
        $user_log->last_activity = $request->last_activity;
        $user_log->attempt = $request->attempt;
        $user_log->user_type = $request->user_type;
        $user_log->status = $request->status;
        //$user_log->created_by = auth()->user()->full_name;
        $user_log->changed_by = auth()->user()->full_name;
        $user_log->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Data created successfully!'
        ], 201);
    }
}
