<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailGroup;

class EmailGroupController extends Controller
{

    public function editEmail($id)
    {
        $data = EmailGroup::findOrFail($id);
        return view('regis_user/email-group/edit')->with(['email' => $data]);
    } 

    public function getEmailGroup()
    {
        $data = EmailGroup::all();
        return view('regis_user/email-group/index')->with(['email' => $data]);
    }

    public function getDataEmailGroup()
    {
        $data = EmailGroup::get();

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
                return  view('regis_user/email-group/buttons')->with(['data' => $data]);
            })
            ->editColumn('number', function ($data) {
                return 1;
            }) ->editColumn('last_changed_by', function ($data) {
              return @$data->users->nm_user;
                
            })
              ->addColumn('status', function ($data) {
             
                if($data->active == "A")
                {
                   
                    $status = "<small><span class=\"badge bg-success\">Active</span></small>";
                } elseif($data->active=='N') {
                    $status = "<small><span class=\"badge bg-warning\"> Non-Active</span></small>";
                } else{
                    $status = "<small><span class=\"badge bg-secondary\"> N/A</span></small>";
                }

                return $status;
                
            })
            ->editColumn('last_changed', function ($data) {                    
                return date('d.m.Y H:i:s',strtotime($data->last_changed));
            })->rawColumns(['action','status','assigned'])->addIndexColumn()->make(true);
    }


    public function index(Request $request){
        $skip = $request->perpage * ($request->page - 1);
        $index = EmailGroup::when(!empty($request->order_by), function($query) use ($request){
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

        $email_group = (clone $index)->take((int)$request->perpage)
            ->skip((int)$skip)
            ->get();

        $total = (clone $index)->count();

        return response()->json([
            'type' => 'success',
            'data' => $email_group,
            'total' => $total
        ], 200);

    }

    public function store(Request $request){
        $email_group = new EmailGroup;
        $email_group->dept_code = $request->dept_code;
        $email_group->abrev = $request->abrev;
        $email_group->dept_desc = $request->dept_desc;
        $email_group->created_by = auth()->user()->full_name;
        $email_group->save();

        return response()->json([
            'message' => 'data created has been successfully',
            'type' => 'success'
        ], 201);
    }

    public function show($id){
        $email_group = EmailGroup::find($id);
        return response()->json([
            'type' => 'success',
            'data' => $email_group
        ], 200);
    }

    public function updateEmail(Request $request){
        
        $email_group = EmailGroup::find($request->id);
        // dd($email_group, $request);
        $email_group->dept_code = $request->dept_code;
        $email_group->abrev = $request->abrev;
        $email_group->dept_desc = $request->dept_desc;
        $email_group->active = $request->active;
        $email_group->save();

        return redirect()->route('regis-user.email-group')->with(['message_success' => 'Berhasil mengubah data.']);
    }

    public function deleteEmail($id){
        $email_group = EmailGroup::find($id);
        $email_group->delete();

        return redirect()->route('regis-user.email-group')->with(['message_success' => 'Berhasil menghapus data.']);
    }
}
