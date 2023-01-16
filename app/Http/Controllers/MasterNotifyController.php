<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterNotify;

class MasterNotifyController extends Controller
{
    public function index(Request $request){
        $skip = $request->perpage * ($request->page - 1);
        $index = MasterNotify::when(!empty($request->order_by), function($query) use ($request){
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

        $master_notify = (clone $index)->take((int)$request->perpage)
            ->skip((int)$skip)
            ->get();

        $total = (clone $index)->count();

        return response()->json([
            'type' => 'success',
            'data' => $master_notify,
            'total' => $total
        ], 200);

    }

    public function store(Request $request){
        // $request->validate([
        //     'notify_id' => 'required|string|unique:master_notify,notify_id',
        // ]);
        $master_notify = new MasterNotify;
        $master_notify->notify_id = $request->notify_id;
        $master_notify->notify_sequence = $request->notify_sequence;
        $master_notify->notify_before = $request->notify_before;
        $master_notify->measurement = $request->measurement;
        $master_notify->created_by = auth()->user()->full_name;
        $master_notify->save();

        return response()->json([
            'message' => 'data created has been successfully',
            'type' => 'success'
        ], 201);
    }

    public function show($id){
        $master_notify = MasterNotify::find($id);
        return response()->json([
            'type' => 'success',
            'data' => $master_notify
        ], 200);
    }

    public function update(Request $request, $id){
        $master_notify = MasterNotify::find($id);
        $master_notify->notify_id = $request->notify_id;
        $master_notify->notify_sequence = $request->notify_sequence;
        $master_notify->notify_before = $request->notify_before;
        $master_notify->measurement = $request->measurement;
        $master_notify->updated_by = auth()->user()->full_name;
        $master_notify->save();

        return response()->json([
            'type' => 'success',
            'message' => 'data updated has been successfully'
        ], 200);
    }

    public function destroy($id){
        $master_notify = MasterNotify::find($id);
        $master_notify->delete();

        return response()->json([
            'type' => 'success',
            'message' => 'data deleted has been successfully'
        ], 200);
    }
}
