<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLogRecord;
use App\Models\MasterUser;
use Cache;

class UserLogRecordController extends Controller
{

    public function editLogRecord($id)
    {
        $data = UserLogRecord::findOrFail($id);
        return view('regis_user/user-logrecord/edit')->with(['user' => $data]);
    } 

    public function getUserLogRecord()
    {
        $data = UserLogRecord::all();
        return view('regis_user/user-logrecord/index')->with(['user' => $data]);
    }

    public function getDataUserLogRecord()
    {
        set_time_limit(800);
        $data = UserLogRecord::orderBy('datetime_log','DESC')->limit(11235)->get();

        return \DataTables::of($data)
            ->editColumn('uom', function ($data) {
                if (@$data->uom === "D") {
                    return "Days";
                } else {

                    return 'Months';
                }
            })
            ->editColumn('id_user', function ($data) {
                return @$data->user->nm_user."<br><small><i>".(empty($data->user->vendor) ? "Dharma Polimetal":$data->user->vendor->nm_vendor)."</i></small>";
            }) 
            ->editColumn('cr_by', function ($data) {
                return @$data->users->nm_user;
            })
            ->editColumn('action', function ($data) {
                return  view('regis_user/user-logrecord/buttons')->with(['data' => $data]);
            })
            ->editColumn('number', function ($data) {
                return 1;
            })
            ->editColumn('attempt', function ($data) {
                 if($data->attempt == "S")
                {
                   
                    $status = "<span class=\"badge bg-success\">Success</span>";
                } elseif($data->attempt=='F') {
                    $status = "<span class=\"badge bg-danger\">Failed</span>";
                } else{
                    $status = "<span class=\"badge bg-secondary\"> Unknown</span>";
                }

                return $status;
            }) ->editColumn('status', function ($data) {
                 if(@$data->user->status_user == "A")
                {
                   
                    $status = "<span class=\"badge bg-success\"><i class='fas fa-check-circle'></i> Active</span>";
                } elseif(@$data->user->status_user=='N') {
                    $status = "<span class=\"badge bg-danger\"><i class='fas fa-times'></i> Non-active</span>";
                } else{
                    $status = "<span class=\"badge bg-secondary\">Undentified</span>";
                }

                return $status;
            })
            ->editColumn('activity', function ($data) {
                 if(@$data->activity == "in")
                {
                   
                    $status = "<span class=\"badge bg-info\"><i class=\"fas fa-arrow-circle-right\"></i> IN</span>";
                } elseif(@$data->activity=='out') {
                    $status = "<span class=\"badge bg-warning\"><i class=\"fas fa-arrow-circle-left\"></i> OUT</span>";
                } else{
                    $status = "<span class=\"badge bg-secondary\">Undetified</span>";
                }

                return $status;
            })
            ->editColumn('user_type', function ($data) {
                return  empty(@$data->user->tipeUser) ? "<i>Unknown</i>":@$data->user->tipeUser->nm_tipe_user;
            })
            ->editColumn('datetime_log', function ($data) {                    
                return date('D, d.m.Y H:i A',strtotime($data->datetime_log));
            })->rawColumns(['action','id_user','activity','attempt','status','user_type'])->addIndexColumn()->make(true);
    }


    public function index(Request $request){
        $skip = $request->perpage * ($request->page - 1);
        $index = UserLogRecord::when(!empty($request->order_by), function($query) use ($request){
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

        $user_logrecord = (clone $index)->take((int)$request->perpage)
            ->skip((int)$skip)
            ->get();

        $total = (clone $index)->count();

        return response()->json([
            'type' => 'success',
            'data' => $user_logrecord,
            'total' => $total
        ], 200);

    }

    public function store(Request $request){
        $user_logrecord = new UserLogRecord;
        $user_logrecord->id_user = $request->id_user;
        $user_logrecord->ip_address = $request->ip_address;
        $user_logrecord->datetime_log = $request->datetime_log; 
        $user_logrecord->attempt = $request->attempt;
        $user_logrecord->activity = $request->activity;
        $user_logrecord->role = $request->role;
        $user_logrecord->created_by = auth()->user()->full_name;
        $user_logrecord->save();

        return response()->json([
            'message' => 'data created has been successfully',
            'type' => 'success'
        ], 201);
    }

    public function show($id){
        $user_logrecord = UserLogRecord::find($id);
        return response()->json([
            'type' => 'success',
            'data' => $user_logrecord
        ], 200);
    }

    public function updateLogrecord(Request $request){
        
        $user_logrecord = UserLogRecord::find($request->id);
        // dd($user_logrecord, $request);
        $user_logrecord->id_user = $request->id_user;
        $user_logrecord->ip_address = $request->ip_address;
        $user_logrecord->datetime_log = $request->datetime_log;
        $user_logrecord->attempt = $request->attempt;
        $user_logrecord->activity = $request->activity;
        $user_logrecord->role = $request->role;
        $user_logrecord->save();

        return redirect()->route('regis-user.user-logrecord')->with(['message_success' => 'Berhasil mengubah data.']);
    }

    public function deleteLogrecord($id){
        $user_logrecord = UserLogRecord::find($id);
        MasterUser::where('id_user',$user_logrecord->id_user)->update(['status_user' => 'N']);

        return redirect()->route('regis-user.user-logrecord')->with(['message_success' => 'User Blocked.']);
    }
}