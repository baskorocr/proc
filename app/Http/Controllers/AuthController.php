<?php

namespace App\Http\Controllers;

use session;
use Validator;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required|min:6'
        ]);
 
        if (Auth::attempt($credentials)) {
            $token = Str::random(25);
            $user = User::where('username', $request->username)->first();

            if ($user == null){

                return response()->json([
                    'type' => 'error',
                    'message' => 'Account not found',
                    'user' => $user,
                    'request' => $request->all(),
                    'user' => User::all()
                ], 200);

            } else if (!Hash::check($request->password, $user->password)){

                return response()->json([
                    'type' => 'error',
                    'message' => 'Please check username or password!'
                ], 422);

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
                
                
                return response()->json([
                    'type' => 'success',
                    'message' => 'Login successfully!',
                    'token' => $token,
                    'data' => $user,
                    'permissions' => $permission_allowed->toArray()
                ], 200);
            }
        }else {
            return response()->json([
                'type' => 'error',
                'response' => $validator->errors()->first(),
                'message' => "Please check username or password!",
            ], 200);

        } 
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
     }
}
