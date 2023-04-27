<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailListGroup;
use App\Models\EmailGroup;

class EmailListGroupController extends Controller
{

    public function editListEmail($id)
    {
        $data = EmailListGroup::findOrFail($id);
        $dept = EmailGroup::get();
        return view('regis_user/email-list-group/edit')->with(['listemail' => $data,'dept' => $dept]);
    } 

    public function getEmailListGroup()
    {
         $dept = EmailGroup::get();
        $data = EmailListGroup::all();
        return view('regis_user/email-list-group/index')->with(['listemail' => $data,'dept' => $dept]);
    }

    public function getDataEmailListGroup()
    {
        $data = EmailListGroup::get();

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
            ->editColumn('dept_code', function ($data) {
                if (@$data->deptMaster->abrev == null) {
                        $abrev = "";
                    } else {
                         $abrev = "<small>[".$data->dept_code."] [".@$data->deptMaster->abrev."]</small>";
                }
                return @@$data->deptMaster->dept_desc."<br>".$abrev;
            })
            ->editColumn('action', function ($data) {
                return  view('regis_user/email-list-group/buttons')->with(['data' => $data]);
            })
            ->editColumn('number', function ($data) {
                return 1;
            })->editColumn('last_changed_by', function ($data) {
              return @$data->users->nm_user;
                
            }) ->addColumn('status', function ($data) {
             
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
            })->rawColumns(['action','status','dept_code'])->addIndexColumn()->make(true);
    }


    public function index(Request $request){
        $skip = $request->perpage * ($request->page - 1);
        $index = EmailListGroup::when(!empty($request->order_by), function($query) use ($request){
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

        $email_list_group = (clone $index)->take((int)$request->perpage)
            ->skip((int)$skip)
            ->get();

        $total = (clone $index)->count();

        return response()->json([
            'type' => 'success',
            'data' => $email_list_group,
            'total' => $total
        ], 200);

    }

    public function listemailAdd(Request $request){
        $email_list_group = new EmailListGroup;
        $email_list_group->mail = $request->mail;
        $email_list_group->dept_code = $request->dept_code;
        $email_list_group->name = $request->name;
        $email_list_group->last_changed_by = auth()->user()->id_user;
        $email_list_group->save();

        return redirect()->route('regis-user.email-listemail')->with(['message_success' => 'Berhasil menambah data.']);
    }

    public function show($id){
        $email_list_group = EmailListGroup::find($id);
        return response()->json([
            'type' => 'success',
            'data' => $email_list_group
        ], 200);
    }

    public function updateListEmail(Request $request){
        
        $email_list_group = EmailListGroup::find($request->id);
        $email_list_group->mail = $request->mail;
        $email_list_group->dept_code = $request->dept_code;
        $email_list_group->name = $request->name;
        $email_list_group->active = $request->active;
         $email_list_group->last_changed_by = auth()->user()->id_user;
        $email_list_group->save();

        return redirect()->route('regis-user.email-listemail')->with(['message_success' => 'Berhasil mengubah data.']);
    }

    public function deleteListEmail($id){
        $email_list_group = EmailListGroup::find($id);
        $email_list_group->delete();

        return redirect()->route('regis-user.email-listemail')->with(['message_success' => 'Berhasil menghapus data.']);
    }
}
