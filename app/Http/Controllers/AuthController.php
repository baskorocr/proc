<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Permission;
use App\Models\Role;
use Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'username' => 'required',
                'password' => 'required|min:6'
            ]
        );

        if ($validator->fails()) {

            return response()->json([
                'type' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);

        } else {

            $token = Str::random(25);
            $user = User::where('username', $request->username)->first();

            if ($user == null){

                return response()->json([
                    'type' => 'error',
                    'message' => 'Account not found',
                    'user' => $user,
                    'request' => $request->all(),
                    //'user' => User::all()
                ], 422);

            } else if (!Hash::check($request->password, $user->password)){

                return response()->json([
                    'type' => 'error',
                    'message' => 'Please check username or password!'
                ], 422);

            } else {

                $user->forceFill([
                    'api_token' => hash('sha256', $token)
                ])->save();

                $permissions = Permission::whereNull('parent_id')->orderBy('order_number')->get();
                $permission_allowed = $permissions->map(function($permission) use ($user){

                    $permission_allowed = collect($user->role->permissions)->where('allow', true);

                    if ($permission_allowed->pluck('permission_id')->contains($permission->id)) {

                        return [
                            '_id' => $permission->id,
                            'name' => $permission->name,
                            'url' => $permission->url,
                            'icon' => $permission->icon,
                            'children' => $permission->children->map(function($child) use ($user){
                                $permission_allowed = collect($user->role->permissions)->where('allow', true);
                                if ($permission_allowed->pluck('permission_id')->contains($child->id)) {
                                    return [
                                        '_id' => $child->id,
                                        'name' => $child->name,
                                        'url' => $child->url
                                    ];
                                }
                            })
                        ];
                    }
                });

                return response()->json([
                    'type' => 'success',
                    'message' => 'Login successfully!',
                    'token' => $token,
                    'data' => $user,
                    'permissions' => $permission_allowed->toArray(),
                    'redirect' => Permission::find($user->role->permissions->where('allow', true)->first()->permission_id)->url
                ], 200);

            }

        }
    }
}
