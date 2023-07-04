<?php

namespace App\Http\Controllers;

use session;
use Validator;
use UserLogging;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Cache;

class AuthController extends Controller
{
    public function set_idle(Request $request)
    {
        if(\Auth::check())
        {
            Cache::forget('active_'.auth()->user()->_id);
            Cache::forever('redirect_lockscreen_'.auth()->user()->_id, $request->redirect_lockscreen);
            // $log = [];
            // $log['status'] = "lockscr";
            // $log['user'] = auth()->user()->_id;
            // $log['time'] = date("Y-m-d H:i:s");
            // \Log::info($log);

            return response()->json(['status' => true,'message'=>'Set To Idle.'],200);
        }

        return response()->json(['status' => false,'message'=>'Unauthenticated.'],403);
    }

    public function unlockScreen(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        if(empty($user))
        {
            $log = [];
            $log['status'] = "unlockscr-failed";
            $log['user'] = auth()->user()->_id;
            $log['time'] = date("Y-m-d H:i:s");
            $log['reason'] ="User is empty";
            $log['params'] = json_encode(['csrf_token' => $request->_token,'username' => $request->username,'password' => empty($request->password) ? "NO":"YES",'ip_address' => $request->ip()]);
            \Log::warning($log);

            return redirect()->back()->with(['message_fail' => "User is invalid, please refresh this page."]);
        }
        if (Hash::check($request->password, $user->password)){
            Cache::forever('active_'.auth()->user()->_id,true); //30 Jam default
            if(Cache::has('redirect_lockscreen_'.auth()->user()->_id))
            {
                $redirect = Cache::get('redirect_lockscreen_'.auth()->user()->_id);
                Cache::forget('redirect_lockscreen_'.auth()->user()->_id);
            }else{
                $redirect = '/';
            }
            // $log = [];
            // $log['status'] = "unlockscr";
            // $log['user'] = auth()->user()->_id;
            // $log['time'] = date("Y-m-d H:i:s");
            // \Log::info($log);
            return redirect($redirect);
        } else{
            return redirect()->back()->with(['message_fail' => "Password is incorrect."]);
        }

    }
    
    public function login(Request $request)
    {
        session()->regenerate(); 
        $usermd5 = User::where('username', $request->username)->first();
        if(empty($usermd5))
        {
            return response()->json([
                        'type' => 'error',
                        'message' =>'Please check username or password!'
                    ], 200);
        }
            if(empty($usermd5->role_id))
            {
                 return response()->json([
                        'type' => 'error',
                        'message' =>'This account does not have access yet, please contact administrator.'
                    ], 422);
            }

         if (Hash::needsRehash($usermd5->password))
         {
             if($usermd5->password ==  md5($request->password))
             {
                User::where('username', $request->username)->update(['password' => Hash::make($request->password)]);
             }
         }

        $usermd5 = null;
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
        'password.min' => 'Password of at least 6 characters.'
        ]);
        
         

        if (Auth::attempt($credentials)) {
            $token = Str::random(25);
            $user = User::where('username', $request->username)->first();
            // dd($request->password, $user->password);
            if ($user == null){

                return response()->json([
                    'type' => 'error',
                    'message' => 'Account not found',
                    'user' => $user,
                    'request' => $request->all(),
                    'user' => User::all()
                ], 200);

            } else if (!Hash::check($request->password, $user->password)){
                UserLogging::trace($user->id_user,$request->ip(),now(),"F","in",$user->username);
                return response()->json([
                    'type' => 'error',
                    'message' => 'Please check username or password!'
                ], 200);

            } else {

                $user->forceFill([
                    'api_token' => hash('sha256', $token)
                ])->save();

                
                // $role = Role::where('_id',$user->role_id)->first();
                // $permissions = Permission::whereNull('parent_id')->where('permission_type','page')->orderBy('order_number')->get();
              
                // $permission_allowed = $permissions->map(function($permission) use ($role){

                //     $permission_allowed = collect($role->permissions)->where('allow', true);

                //     if ($permission_allowed->pluck('permission_id')->contains($permission->id)) {
                //         $xx = Permission::where('parent_id',$permission->id)->where('permission_type','page')->orderBy('order_number')->get();
                //         return [
                //             '_id' => $permission->id,
                //             'name' => $permission->name,
                //             'url' => $permission->url,
                //             'icon' => $permission->parent_id,
                //             'children' => $xx->map(function($child) use ($role){
                //                 $permission_allowed2 = collect($role->permissions)->where('allow', true);
                //                 if ($permission_allowed2->pluck('permission_id')->contains($child->parent_id)) {
                //                     return [
                //                         '_id' => $child->id,
                //                         'name' => $child->name,
                //                         'url' => $child->url
                //                     ];
                //                 }
                //             })
                //         ];
                //     }
                // });

                $permissions = Permission::whereNull('parent_id')->orderBy('order_number')->get();
                // dd($permissions);
                $permission_allowed = $permissions->map(function ($permission) use ($user) {
                    $permission_allowed = collect($user->roles->permissions)->where('allow', true);

                    if ($permission_allowed->pluck('permission_id')->contains($permission->id)) {

                        return [
                            '_id' => $permission->id,
                            'name' => $permission->name,
                            'url' => $permission->url,
                            'icon' => $permission->icon,
                            'permission_type' => $permission->permission_type,
                            'children' => $permission->children->map(function ($child) use ($user) {
                                $permission_allowed = collect($user->roles->permissions)->where('allow', true);
                                if ($permission_allowed->pluck('permission_id')->contains($child->id)) {
                                    return [
                                        '_id' => $child->id,
                                        'name' => $child->name,
                                        'url' => $child->url,
                                        'permission_type' => $child->permission_type,
                                    ];
                                }
                            })->filter()->values()
                        ];
                    }
                })->filter()->values();
                
                // var_dump($permission_allowed->toArray()); 
               
                session(['id_user' =>  $user->id_user]);
                session(['nm_user' =>  $user->nm_user]);
                session(['role' =>  $user->role]);
                session(['id_tipe_user' =>  $user->id_tipe_user]);
                session(['status_user' =>  $user->status_user]);
                session(['username' =>  $user->username]);
                session(['permissions' =>  $permission_allowed->toArray()]);
                // dd(auth()->user()->_id);
                Cache::forever('active_'.auth()->user()->_id,true);

                UserLogging::trace($user->id_user,$request->ip(),now(),"S","in",$user->username);

                return response()->json([
                    'type' => 'success',
                    'message' => 'Login successfully!',
                    'token' => $token,
                    'data' => $user,
                    'permissions' => $permission_allowed->toArray()
                ], 200);
            }
        }else {
            $user = User::where('username', $request->username)->first();
            UserLogging::trace($user->id_user,$request->ip(),now(),"F","in",$user->username);
            return response()->json([
                'type' => 'error',
                //'response' => $validator->errors()->first(),
                'message' => "Please check username or password!",
            ], 200);

        } 
    }

    public function logout(Request $request){
        try{
            UserLogging::trace(auth()->user()->id_user,$request->ip(),now(),"S","out",auth()->user()->username);
            Auth::logout();
            return redirect('/');
        } catch(\Exception $e)
        {
            UserLogging::trace(auth()->user()->id_user,$request->ip(),now(),"F","out",auth()->user()->username);
        }
        
     }
}
