<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterPDAUser;

class MasterPDAUserController extends Controller
{

    public function editPdauser($id)
    {
        $data = MasterPDAUser::findOrFail($id);
        return view('regis_user/master-pdauser/edit')->with(['pdauser' => $data]);
    } 

    public function getMasterPDAUser()
    {
        $data = MasterPDAUser::all();
        return view('regis_user/master-pdauser/index')->with(['pdauser' => $data]);
    }

    public function getDataMasterPDAUser()
    {
        $data = MasterPDAUser::get();

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

            ->editColumn('user_stat', function ($data) {
               if($data->user_stat == "A")
               {
                 return "<span class='badge bg-success'>Active</span>";
               } else{
                return "<span class='badge bg-warning'>Non-active</span>";
               }
            })
            ->editColumn('action', function ($data) {
                return  view('regis_user/master-pdauser/buttons')->with(['data' => $data]);
            })
            ->editColumn('number', function ($data) {
                return 1;
            })
            ->editColumn('last_changed', function ($data) {                    
                return date('d/m/Y',strtotime($data->last_changed));
            })->rawColumns(['action','user_stat'])->addIndexColumn()->make(true);
    }


    public function index(Request $request){
        $skip = $request->perpage * ($request->page - 1);
        $index = MasterPDAUser::when(!empty($request->order_by), function($query) use ($request){
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

        $master_pdauser = (clone $index)->take((int)$request->perpage)
            ->skip((int)$skip)
            ->get();

        $total = (clone $index)->count();

        return response()->json([
            'type' => 'success',
            'data' => $master_pdauser,
            'total' => $total
        ], 200);

    }


    public function store(Request $request){
        if(!empty($request->pin))
        {
             if(md5($request->pin) != md5($request->pin_confirm))
             {
                return redirect()->back()->with(['message_fail' => 'PIN Confirmation is Invalid']);
             }
        }
        $master_pdauser = new MasterPDAUser;
        $master_pdauser->id = $request->id;
        $master_pdauser->username = $request->username;
        $master_pdauser->full_name = $request->full_name;
        $master_pdauser->user_stat = "A";
        $master_pdauser->pin = $request->pin;
        $master_pdauser->created_by = auth()->user()->id_user;
        $master_pdauser->save();

         return redirect()->back()->with(['message_success' => 'Data created has been successfully']);
       
    }

    public function show($id){
        $master_pdauser = MasterPDAUser::find($id);
        return response()->json([
            'type' => 'success',
            'data' => $master_pdauser
        ], 200);
    }

    public function updatePdauser(Request $request){
        if(!empty($request->pin))
        {
             if(md5($request->pin) != md5($request->pin_confirm))
             {
                return redirect()->back()->with(['message_fail' => 'PIN Confirmation is Invalid']);
             }
        }
        $master_pdauser = MasterPDAUser::findOrFail($request->_id);
        // dd($master_pdauser, $request);
        $master_pdauser->id = $request->id;
        $master_pdauser->username = $request->username;
        $master_pdauser->full_name = $request->full_name;
        $master_pdauser->user_stat = $request->user_stat;
       
        if(!empty($request->pin))
        {
             $master_pdauser->pin = $request->pin;
        }
        $master_pdauser->created_by = auth()->user()->id_user;
        $master_pdauser->save();

        return redirect()->route('regis-user.master-pdauser')->with(['message_success' => 'Berhasil mengubah data.']);
    }

    public function deletePdauser($id){
        $master_pdauser = MasterPDAUser::find($id);
        $master_pdauser->delete();

        return redirect()->route('regis-user.master-pdauser')->with(['message_success' => 'Berhasil menghapus data.']);
    }
}