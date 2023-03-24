<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterUser;
use App\Models\AccessGroup;
use App\Models\Role;

class MasterUserController extends Controller
{

    public function editUser($id)
    {
        $data = MasterUser::findOrFail($id);
        $accessgrp = AccessGroup::get();
        $roles = Role::get();
        return view('regis_user/master-user/edit')->with(['user' => $data,'accessgrp'=>$accessgrp,'roles'=>$roles]);
    }   

    public function create()
    {
    
        $accessgrp = AccessGroup::get();
        $roles = Role::get();
        return view('regis_user/master-user/create')->with(['accessgrp'=>$accessgrp,'roles'=>$roles]);
    } 


    private function sendmail($data,$newpassword){

        //$data="hidrian.suharman@dp.dharmap.com";
        //$email="hidrian.suharman@dp.dharmap.com";
        $email = @$data['email'];
        $date = date("d-m-Y H:i:s");
        $subject="User Password Reset - eProc PT Dharma Polimetal (".$date.") [NO REPLY]";
        $to=$email;

        //$id_vendor = $data['id_vendor'];
        $nm_vendor = @$data['nm_vendor'];
        $passwd    = $newpassword;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

        // More headers
        $headers .= 'From: Eproc Center <eproc.center@dac.dharmap.com>'."\r\n"; //'Reply-To: '.$data.' <'.$email.'>'."\r\n"; //silahkan diganti dengan email pengirim
        $headers .= 'Bcc: eProc <eproc.center@dac.dharmap.com>'."\r\n";

        $message = ' Dear <b>'.$nm_vendor.'</b>, <br><br>
                        
                    Your credential to eProc Dharma Polimetal portal
                    has been changed with following detail:
                    <br>
                    
                    Username : <b>'.$email.'</b>
                    Password : <b>'.$passwd.'</b>
                    <br><br>

                    Please change password as soon as you reach our website. <br>
                
                    ';


        $message .= '<br>
                    <a href="http://eproc.dharmap.com:7777/eprocurement/" target="_blank" style="background-color: #4CAF50;
                        border: none;
                        color: white;
                        padding: 13px 30px;
                        text-align: center;
                        text-decoration: none;
                        display: inline-block;
                        font-size: 14px;
                        margin: 4px 2px;
                        cursor: pointer;"
                    >
                    Click here to Login
                    </a>
                ';

        $message .= '<br><br>Use your user access to login. If you can\'t, please contact our adminstrator to activate your account.';

        $message .= '<br><br><b>This message is sent by system, please don\'t reply.</b>';

        $message .= '   <br>
                        <br>Thanks,
                        <br>    
                        <br>Best regards,
                        <br>
                        <br><b><u>eProc Center</u></b>
                        <br>Procurement Division
                        <br>PT. Dharma Polimetal
                        <br><label>Kawasan Delta Silikon 1, Jalan Angsana Raya Blok A9 No 8</label>
                        <br>Lippo Cikarang, 17550
                        <br>Tlp.  : (021) 8974559
                        <br>Ext.  : 811/812
                        <br>Email : eproc.center@dac.dharmap.com
                        <br>Web   : http://eproc.dharmap.com:7777/eprocurement/
        ';

        @mail($to,$subject,$message,$headers);
        if(@mail) {
            $msg = 'success';
        } else {
            $msg = 'failed';
        }

        return $msg;
    }
    public function reset($id)
    {
        $data = MasterUser::findOrFail($id);
        $pwd = bcrypt(\Str::random(8));

        MasterUser::where('_id',$id)->update(['password' => $pwd]);
        $this->sendmail(json_decode(json_encode($data), true),$pwd);
        return redirect()->back()->with(['message_success' => "Password Reset Success"]);
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
            ->editColumn('username', function ($data) {
                return $data->username."<br><small><i>".(empty($data->vendor->name) ? "-":$data->vendor->name)."</i></small>";
            })
            ->editColumn('action', function ($data) {
                return  view('regis_user/master-user/buttons')->with(['data' => $data]);
            })
            ->editColumn('number', function ($data) {
                return 1;
            })
            ->editColumn('status_user', function ($data) {
                 if($data->status_user == "A")
                {
                   
                    $status = "<small><span class=\"badge bg-success\">Active</span></small>";
                } elseif($data->status_user=='N') {
                    $status = "<small><span class=\"badge bg-warning\"> Non-Active</span></small>";
                } else{
                    $status = "<small><span class=\"badge bg-secondary\"> N/A</span></small>";
                }

                return $status;
            })
            ->editColumn('last_changed', function ($data) {                    
                return date('d.m.Y H:i:s',strtotime($data->last_changed));
            })->rawColumns(['action','username','status_user'])->addIndexColumn()->make(true);
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
        $role = Role::where('_id',$request->role)->first();
        $master_user->id_user = $request->id_user;
        $master_user->nm_user = $request->nm_user;
        $master_user->id_tipe_user = $request->id_tipe_user;
        $master_user->status_user = $request->status_user;
        $master_user->username = $request->username;
        $master_user->role = $role->name;
        $master_user->role_id = $request->role;
        $master_user->created_by = auth()->user()->full_name;
        $master_user->save();

        return redirect()->route('regis-user.master-user')->with(['message_success' => 'Berhasil mendaftarkan user.']);
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
        $role = Role::where('_id',$request->role)->first();
        if(empty($role))
        {
            return redirect()->route('regis-user.master-user')->with(['message_fail' => 'Role Tidak Ditemukan.']);
        }
        $master_user->id_user = $request->id_user;
        $master_user->nm_user = $request->nm_user;
        $master_user->id_tipe_user = $request->id_tipe_user;
        $master_user->status_user = $request->status_user;
        $master_user->id_access_group = $request->access_group_name;
        $master_user->username = $request->username;
        $master_user->role = $role->name;
        $master_user->role_id = $request->role;
        $master_user->save();

        return redirect()->route('regis-user.master-user')->with(['message_success' => 'Berhasil mengubah data.']);
    }

    public function deleteUser($id){
        $master_user = MasterUser::find($id);
        $master_user->delete();

        return redirect()->route('regis-user.master-user')->with(['message_success' => 'Berhasil menghapus data.']);
    }
}