<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Cache;
use App\Models\Permission;
use Log;
class RoutePermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
       $cekPath =  Permission::where('url',request()->path())->count();
       if($cekPath < 1)
       {
            return $next($request);
       }

        $permissions = [];
        $dd = auth()->user()->roles->permissions;
        // dd($dd);
        foreach($dd as $d)
        {
            $permissions[]=$d['permission_id'];
        }
          $r = Permission::whereIn('_id',$permissions)->orderBy('_id','ASC')->get();
          $urlList = [];
        foreach($r as $p)
        {
            $urlList[] = url($p->url);
        }


        if(in_array(request()->url(),$urlList))
        {
            return $next($request);
        }

        Log::notice(['message' => "[PERMISSION] ".auth()->user()->id_user." (".auth()->user()->username.") try to access \"".request()->path()."\"",'status' => 'ACCESS DENIED', 'time' => date("Y-m-d H:i:s"),'ip' => $request->ip()]);
        return abort(403);
        
    }
}
