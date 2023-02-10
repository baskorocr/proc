<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailGroup;

class EmailGroupController extends Controller
{
    public function index(Request $request)
    {
        $skip = $request->perpage * ($request->page - 1);
        $email_group = EmailGroup::where(function($where) use ($request){
            
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

        $total = EmailGroup::where(function($where) use ($request){
            
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
            'data' => $email_group,
            'total' => $total
        ], 200);
    }

    public function show(Request $request, $id)
    {
        $email_group = EmailGroup::findOrFail($id);

        return response()->json([
            'type' => 'success',
            'data' =>  $email_group
        ]);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     // 'username' => 'required|string|unique:users,username,'.$id.',_id',
        //     //'email' => 'required|string',
        //     // 'full_name' => 'required|string',
        // ]);

        $email_group = new EmailGroup;
        $email_group->dept_code = $request->dept_code;
        $email_group->abbreviation = $request->abbreviation;
        $email_group->description = $request->description;
        $email_group->created_by = auth()->user()->full_name;
        //$email_group->changed_by = auth()->user()->full_name;
        $email_group->save();

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

        $email_group = EmailGroup::findOrFail($id);
        $email_group->dept_code = $request->dept_code;
        $email_group->abbreviation = $request->abbreviation;
        $email_group->description = $request->description;
        $email_group->changed_by = auth()->user()->full_name;
        $email_group->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Data updated successfully!'
        ], 201);
    }

    public function destroy($id)
    {
        $email_group = EmailGroup::findOrFail($id);
        $email_group->delete();

        return response()->json([
            'type' => 'success',
            'message' => 'Data Deleted Successfully!'
        ], 201);
    }
}
