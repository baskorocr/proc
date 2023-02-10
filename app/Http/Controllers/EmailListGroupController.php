<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailListGroup;

class EmailListGroupController extends Controller
{
    public function index(Request $request)
    {
        $skip = $request->perpage * ($request->page - 1);
        $email_list_group = EmailListGroup::where(function($where) use ($request){
            
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

        $total = EmailListGroup::where(function($where) use ($request){
            
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
            'data' => $email_list_group,
            'total' => $total
        ], 200);
    }

    public function show(Request $request, $id)
    {
        $email_list_group = EmailListGroup::findOrFail($id);

        return response()->json([
            'type' => 'success',
            'data' =>  $email_list_group
        ]);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     // 'username' => 'required|string|unique:users,username,'.$id.',_id',
        //     //'email' => 'required|string',
        //     // 'full_name' => 'required|string',
        // ]);

        $email_list_group = new EmailListGroup;
        $email_list_group->email = $request->email;
        $email_list_group->departement = $request->departement;
        $email_list_group->name = $request->name;
        $email_list_group->created_by = auth()->user()->full_name;
        //$email_list_group->changed_by = auth()->user()->full_name;
        $email_list_group->save();

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

        $email_list_group = EmailListGroup::findOrFail($id);
        $email_list_group->email = $request->email;
        $email_list_group->departement = $request->departement;
        $email_list_group->name = $request->name;
        $email_list_group->changed_by = auth()->user()->full_name;
        $email_list_group->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Data updated successfully!'
        ], 201);
    }

    public function destroy($id)
    {
        $email_list_group = EmailListGroup::findOrFail($id);
        $email_list_group->delete();

        return response()->json([
            'type' => 'success',
            'message' => 'Data Deleted Successfully!'
        ], 201);
    }
}
