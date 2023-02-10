<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterUser;

class MasterUserController extends Controller
{

    public function editUser($id)
    {
        $data = MasterUser::findOrFail($id);
        return view('regis_user/master-user/edit')->with(['user' => $data]);
    } 

    public function getMasterUser()
    {
        $data = MasterUser::all();
        return view('regis_user/master-user/index')->with(['user' => $data]);
    }

    public function getDataMasterUser()
    {
        $data = MasterUser::get();

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
                return  view('regis_user/master-user/buttons')->with(['data' => $data]);
            })
            ->editColumn('number', function ($data) {
                return 1;
            })
            ->editColumn('last_changed', function ($data) {                    
                return date('d/m/Y',strtotime($data->last_changed));
            })->rawColumns(['action'])->addIndexColumn()->make(true);
    }


    public function index(Request $request){
        $skip = $request->perpage * ($request->page - 1);
        $index = MasterUser::when(!empty($request->order_by), function($query) use ($request){
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

        $master_user = (clone $index)->take((int)$request->perpage)
            ->skip((int)$skip)
            ->get();

        $total = (clone $index)->count();

        return response()->json([
            'type' => 'success',
            'data' => $master_user,
            'total' => $total
        ], 200);

    }

    public function store(Request $request){
        $master_user = new MasterUser;
        $master_user->id_user = $request->id_user;
        $master_user->nm_user = $request->nm_user;
        $master_user->id_tipe_user = $request->id_tipe_user;
        $master_user->status_user = $request->status_user;
        $master_user->username = $request->username;
        $master_user->role = $request->role;
        $master_user->created_by = auth()->user()->full_name;
        $master_user->save();

        return response()->json([
            'message' => 'data created has been successfully',
            'type' => 'success'
        ], 201);
    }

    public function show($id){
        $master_user = MasterUser::find($id);
        return response()->json([
            'type' => 'success',
            'data' => $master_user
        ], 200);
    }

    public function updateUser(Request $request){
        
        $master_user = MasterUser::find($request->id);
        // dd($master_user, $request);
        $master_user->id_user = $request->id_user;
        $master_user->nm_user = $request->nm_user;
        $master_user->id_tipe_user = $request->id_tipe_user;
        $master_user->status_user = $request->status_user;
        $master_user->username = $request->username;
        $master_user->role = $request->role;
        $master_user->save();

        return redirect()->route('regis-user.master-user')->with(['message_success' => 'Berhasil mengubah data.']);
    }

    public function deleteUser($id){
        $master_user = MasterUser::find($id);
        $master_user->delete();

        return redirect()->route('regis-user.master-user')->with(['message_success' => 'Berhasil menghapus data.']);
    }
}