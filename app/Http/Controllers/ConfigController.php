<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManifestHeader;
use Config;
use Storage;
use MongoDB\BSON\UTCDateTime;
use App\Models\Permission;
use App\Models\Role;

class ConfigController extends Controller
{
    public function permission()
    {
        return view('config/permission/index');
    }  

    public function role()
    {
        return view('config/role/index');
    } 
    
    public function createPermission()
    {
        $ret['parent'] = Permission::orderBy('name','ASC')->get();
        return view('config/permission/add')->with($ret);
    }  

    public function createRole()
    {
        $ret['role'] = Role::orderBy('name','ASC')->get();
        $ret['parent'] = Permission::whereNull('parent_id')->orderBy('name','ASC')->get();
        return view('config/role/add')->with($ret);
    } 
    
    public function editRole($id)
    {
        $arrPermisssion=[];
        $role = Role::where('_id',$id)->first();
        $ret['data'] = $role;
        foreach ($role->permissions as  $p) {
           $arrPermisssion[] = $p->permission_id;
        }
        // dd($arrPermisssion);
        $ret['arrPermisssion'] = $arrPermisssion;
        $ret['parent'] = Permission::whereNull('parent_id')->orderBy('name','ASC')->get();
        return view('config/role/edit')->with($ret);
    } 

     public function saveRole(Request $request)
    {
        $arrPermisssion = [];
        foreach ($request->permissions as $key => $p) {
           $arrPermisssion[] = ['permission_id' => $p,'allow' => true];
        }

        $d = Role::create($this->paramsRole($request,$arrPermisssion));

         return redirect()->route('config.role')->with(['message_success' => 'Role Added']);

       
    } 

     public function updateRole(Request $request)
    {
        $arrPermisssion = [];
        foreach ($request->permissions as $key => $p) {
           $arrPermisssion[] = ['permission_id' => $p,'allow' => true];
        }

        $d = Role::where('_id',$request->id)->update($this->paramsRole($request,$arrPermisssion,true));

         return redirect()->route('config.role')->with(['message_success' => 'Role Updated']);

       
    } 

    public function editPermission($id)
    {
        $ret['parent'] = Permission::orderBy('name','ASC')->get();
        $ret['data'] = Permission::where('_id',$id)->firstOrFail();
        return view('config/permission/edit')->with($ret);
    } 

    public function insertPermission(Request $request)
    {
         $validate = [
                            'name' => "required|unique:\App\Models\Permission,name",
                            'description' => "nullable|string",
                            'url' => ['required'],
                            'parent_id' => ['nullable','exists:\App\Models\Permission,_id'],
                            'order_number' => ['nullable'],
                            'permission_type' => ['required|in:page,button'],

                      ];
        $this->validate($request, $validate);


        $permission = Permission::create($this->paramsPermission($request));

        return redirect()->route('config.permission')->with(['message_success' => 'Permission Added']);

    }  
    public function updatePermission(Request $request)
    {
         if(Permission::where('_id',$request->id)->count() >= 1){

            $permission = Permission::where('_id',$request->id)->update($this->paramsPermission($request,true));
            return redirect()->route('config.permission')->with(['message_success' => 'Permission Updated']);
         }
        
            return redirect()->route('config.permission')->with(['message_fail' => 'Permission not Found']);


    } 

    public function deletePermission($id)
    {
        
        $permission = Permission::where('_id',$id)->delete();

        return redirect()->route('config.permission')->with(['message_success' => 'Permission Deleted']);

    }  


    public function deleteRole($id)
    {
        
        $permission = Role::where('_id',$id)->delete();

        return redirect()->route('config.role')->with(['message_success' => 'Role Deleted']);

    } 

    public function getDatatablePermission()
    {

       $data = Permission::get();
       return \DataTables::of($data)
          
            ->editColumn('created_at', function ($data) {
                
               return  date('Y-m-d, H:i:s',strtotime($data->created_at));
            })
            ->editColumn('updated_at', function ($data) {
                
               return  date('Y-m-d, H:i:s',strtotime($data->updated_at));
            })
            ->addColumn('action', function ($data) {
                
               return  view('config/permission/partials/action_permission')->with(['data' => $data]);
            })
            ->rawColumns(['download_check','mail_stat','downloaded','file_stat','action'])
            ->make(true);
    
    }

    public function getDatatableRole()
    {

       $data = Role::get();
       return \DataTables::of($data)
          
            ->editColumn('created_at', function ($data) {
                
               return  date('Y-m-d, H:i:s',strtotime($data->created_at));
            })
            ->editColumn('updated_at', function ($data) {
                
               return  date('Y-m-d, H:i:s',strtotime($data->updated_at));
            })
            ->addColumn('action', function ($data) {
                
               return  view('config/role/action')->with(['data' => $data]);
            })
            ->rawColumns(['download_check','mail_stat','downloaded','file_stat','action'])
            ->make(true);
    
    }

    private function paramsPermission($request,$update=false)
    {
        $params['name'] = $request->name;
        $params['description'] = $request->description;
        $params['url'] = $request->url;
        $params['icon'] = $request->icon;
        $params['parent_id'] = $request->parent_id;
        $params['parent_name'] = @Permission::where('_id',$request->parent_id)->first()->name;
        $params['order_number'] = $request->order_number;
        $params['permission_type'] = $request->type;
        if($update)
        {
            $params['changed_by'] = auth()->user()->nm_user;
        } else{
            $params['created_by'] = auth()->user()->nm_user;
            $params['changed_by'] = auth()->user()->nm_user;
        }


        return $params;
    } 

    private function paramsRole($request,$permissions,$update=false)
    {
        $params['name'] = $request->name;
        $params['description'] = $request->description;
        $params['permissions'] = $permissions;
        if($update)
        {
            $params['changed_by'] = auth()->user()->nm_user;
            // $params['updated_at'] = now();
        } else{
            // $params['created_at'] = now();
            $params['created_by'] = auth()->user()->nm_user;
            $params['changed_by'] = auth()->user()->nm_user;
        }


        return $params;
    }

}
