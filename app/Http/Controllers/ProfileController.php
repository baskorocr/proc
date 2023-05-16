<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\MasterUser;
use UserLogging;

class ProfileController extends Controller
{
    
    public function changePwdLink()
    {
        return redirect()->route('change.pwd');
    }  

    public function changePwd()
    {
        return view('change_password');
    }  


    public function changePwdAct(Request $request)
    {
        if(strlen($request->password) < 5)
        {
             return redirect()->back()->with(['message_fail' => 'New Password minimum 5 character!']);
        } 

        if(md5($request->password) == md5($request->curr_pass))
        {
             return redirect()->back()->with(['message_fail' => 'Please input brand new password.']);
        }
        
        $user = MasterUser::where('_id',auth()->user()->_id)->first();
        if(Hash::check($request->curr_pass, $user->password))
        {
            if(md5($request->password) == md5($request->password_confirmed))
            {
                 $new_hashed_password = Hash::make($request->password);
                 MasterUser::where('_id',auth()->user()->_id)->update(['password' => $new_hashed_password]);
                    try{
                        UserLogging::trace(auth()->user()->id_user,$request->ip(),now(),"S","out",auth()->user()->username);
                        \Auth::logout();
                        return redirect('/')->with(['title_msg'=>"Logged out!",'message' => "You've logged out from eProc Dharma Polimetal!"]);
                    } catch(\Exception $e)
                    {
                        UserLogging::trace(auth()->user()->id_user,$request->ip(),now(),"F","out",auth()->user()->username);
                    }
                 return redirect()->back()->with(['message_success' => 'Password updated succesfully.']);
                 
            }
           return redirect()->back()->with(['message_fail' => 'Password Confirmation is incorrect.']);
        }

        return redirect()->back()->with(['message_fail' => 'Current Password invalid.']);
    }
}
