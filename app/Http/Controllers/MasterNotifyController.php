<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterNotify;

class MasterNotifyController extends Controller
{

    public function editNotify($id)
    {
        $data = MasterNotify::find($id);
        return view('doc_iso/master-notify/edit')->with(['notify' => $data]);
    } 

    public function getMasterNotify()
    {
        $data = MasterNotify::all();
        return view('doc_iso/master-notify/index')->with(['notify' => $data]);
    }

    public function getDataMasterNotify()
    {
        $data = MasterNotify::get();

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
                return  view('doc_iso/master-notify/buttons')->with(['data' => $data]);
            })
            ->editColumn('number', function ($data) {
                return 1;
            })->rawColumns(['action'])->addIndexColumn()->make(true);
    }


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

    public function updateNotify(Request $request){
        
        $master_notify = MasterNotify::find($request->id);
        // dd($master_notify, $request);
        $master_notify->notify_id = $request->notify_id;
        $master_notify->notif_before = $request->notif_before;
        $master_notify->uom = $request->uom;
        $master_notify->save();

        return redirect()->route('doc-iso.master-notify')->with(['message_success' => 'Berhasil mengubah data.']);
    }

    public function deleteNotify($id){
        $master_notify = MasterNotify::find($id);
        $master_notify->delete();

        return redirect()->route('doc-iso.master-notify')->with(['message_success' => 'Berhasil menghapus data.']);
    }
}