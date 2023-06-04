<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Po;
use App\Models\User;
use App\Models\MasterUser;
use App\Models\Permission;
use App\Models\Role;
use App\Models\EmailGroup;
use Mail;
use App\Mail\PoMail;
use Exception;
use Carbon\Carbon;
use Storage;


class PoController extends Controller
{
    public function sendPo(Request $request)
    {

        $user = User::where('foreign_id', $request->id_vendor)->where('is_vendor',true)->where('status_user','A')->get();
       
        $msg_mail = '';
        $msg_data = '';

        $cekPo = Po::where('po_num', $request->po_num)->where('revno', $request->revno)->count();
        $resDuplicate = 0;
        
        if($cekPo > 0) {
            $msg_data = 'PO send to eproc failed, cannot insert duplicate data po with same revno.';
            $msg_mail = 'PO send to vendor failed. because send po duplicate / already exist.';
            $resDuplicate = 1;
        } else {
            $po = new Po;
            $po->po_num = $request->po_num;
            $po->mf_type = $request->mf_type;
            $po->comp_code = $request->comp_code;
            $po->doc_type = $request->doc_type;
            $po->doc_catg = $request->doc_catg;
            $po->plant = $request->plant;
            $po->id_vendor = $request->id_vendor;
            $po->doc_date = $request->doc_date;
            $po->relind = $request->relind;
            $po->pgr = $request->purch_grp;
            $po->porg = $request->purch_org;
            $po->creator = $request->creator;
            // NO_PO-TANGGAL APPROV-JAMMENITDETIK , contoh (5111010611-20230526-075945.pdf)
            $pdf_nm = $request->po_num."-".date('Ymd',strtotime($request->aprvdt))."-".date('His',strtotime($request->aprvtm)).".pdf";
            // $po->file_nm = empty($gf[0]) ? "":$gf[0];
            $po->file_nm = $pdf_nm;
            // $po->file_nm = $request->file_name;
            $po->sent = $request->sent;
            $po->downloaded = $request->downloaded;
            $po->accepted = $request->accepted;
            $po->id_user = $request->id_user;
            $po->last_change = $request->last_change;
            $po->revno = strval($request->revno);
            $po->revdt = $request->revdt;
            $po->revtm = $request->revtm;
            $po->rel_state = $request->rel_state;
            $po->po_val = $request->po_val;
            $po->tot_val = $request->tot_val;
            $po->curr = $request->curr;
            $po->pay_term = $request->pay_term;
            $po->aprvdt = $request->aprvdt;
            $po->aprvtm = $request->aprvtm;
            $po->approver = $request->approver;
            $po->batch = $request->batch;
            $po->stat = $request->stat;
            $po->save();
        
            $msg_data = 'PO send to eproc saved successfully.';
        }
        
        if($resDuplicate <= 0) {
            if(count($user) > 0){
                // $dataPo = Po::where('po_num', $request->po_num)->where('revno', $request->revno)->get();
                $dataPo = Po::where('_id', $po->_id)->first();
                
                try {
                    $this->mailer_send($dataPo, $user);
                    $msg_mail = 'PO send mailed to vendor successfully.';
                    //Set Sent Flag
                     PO::where('_id',$po->id)->update(['sent' => date('Y-m-d H:i:s')]);
                } catch (Exception $e) {
                    PO::where('_id',$po->id)->update(['sent' => "0000-00-00 00:00:00"]);
                    $msg_mail = $e->getMessage();
                }

                return response()->json([
                    'msg_data' => $msg_data,
                    'msg_mail' => $msg_mail,
                    'data' => $dataPo
                ], 200);
              
            } else {
                PO::where('_id',$po->id)->update(['sent' => "0000-00-00 00:00:00"]);
                return response()->json([
                    'msg_data' => $msg_data,
                    'msg_mail' => 'PO send to vendor failed, user email not found.',
                        //'data' => $po
                ], 422);
            }
        } else {
            return response()->json([
                'msg_data' => $msg_data,
                'msg_mail' => $msg_mail,
            ], 422);
        }
    }

    // public function resendEmailPo(Request $request)
    // {
    //     //$vendor = Vendor::where('id_vendor', $request->id_vendor)->first();
    //     $po = Po::where('po_num', $request->po_num)->first();
    //     $user = User::where('id_user', $po->id_user)->first();
    //     $msg_mail = '';
    //     $msg_data = 'PO send to eproc saved successfully.';

    //     if($user){
    //         if($user->status_user === 'A'){

                

    //             //Mail::to($vendor->vend_email)->send(new PoMail($po, $vendor));
    //             try {
    //                 Mail::to($user->username)->send(new PoMail($po, $user));
    //                 $message2 = 'PO mailed to vendor';
    //             } catch (Exception $e) {
    //                 $message2 = $e->getMessage();
    //             }
                
    //             return response()->json([
    //                 'message1' => 'PO Sent to Eproc',
    //                 'message2' => $message2,
    //                 'data' => $po
    //             ], 200);
    //         } else {
    //             return response()->json([
    //                 'message' => 'Mail user not active!',
    //                 //'data' => $po
    //             ], 422);
    //         }
    //     } else {
    //         return response()->json([
    //             'message' => 'ID User Not Found!',
    //             //'data' => $po
    //         ], 422);
    //     }
    // }

    public function resendEmailPo(Request $request)
    {
        //$vendor = Vendor::where('id_vendor', $request->id_vendor)->first();
        $po = Po::where('po_num', $request->po_num)->where('revno',$request->revno)->first();
        $user = User::where('foreign_id', $request->id_vendor)->where('is_vendor',true)->where('status_user','A')->get();

        if(count($user) > 0){
           

                //Mail::to($vendor->vend_email)->send(new PoMail($po, $vendor));
                try {
                    $this->mailer_send($po, $user);
                    // Mail::to($user->username)->send(new PoMail($po, $user));
                    $msg_mail = 'PO send mailed to vendor succesfully.';
                } catch (Exception $e) {
                    $msg_mail = $e->getMessage();
                }
                

                return response()->json([
                    'msg_data' => $msg_data,
                    'msg_mail' => $msg_mail,
                    'data' => $po
                ], 200);
           
        } else {
            return response()->json([
                'msg_data' => $msg_data,
                'msg_mail' => 'PO send to vendor failed.',
                //'data' => $po
            ], 422);
        }
    }

    private function mailer_send($po, $user)
    {

            $list_permission=[];
            foreach($user as $u)
            {   
                $list_permission[]=$u->role_id;
            }
            $lperm = array_unique($list_permission);
            $getMenu = Permission::where('name','Download PO')->first();
            $role =  Role::whereIn('_id',$list_permission)->get();
    
            $allowed = [];
            $sended = [];
            //Proses Pencarian Role mana saja yang diizinkan mengakses permission
            foreach($role as $r)
            {
                $permissions=[];
                foreach($r->permissions as $p){
                    $permissions[] = $p->permission_id; 
                    
                }
                
                if(in_array($getMenu->_id, $permissions))
                {
                    $allowed[] = $r->_id;
                }
    
            }


            //Ambil Data Vendor
            $user =  MasterUser::whereIn('role_id',$allowed)->get();
            $nameGroupMail  = $this->split_creator($po->creator);
            $emailgrp = EmailGroup::where('abrev',$nameGroupMail)->first();
             $cc = [];
            if(!empty($emailgrp))
            {
               $emaillist = $emailgrp->mailgroup;
                //TO USER
                //TO Listed Group DEPT
               
                foreach ($emaillist as $e) {
                    if (filter_var($e->mail, FILTER_VALIDATE_EMAIL)) {
                     $cc[] =$e->mail;
                    }
                
                }
            } else{
                throw new Exception('Email Group "'.$nameGroupMail.'"" is not registered in E-Proc.');
            }

            //Kirim Ke Akun Vendor
            $mailVendorUser = [];
            $user =  MasterUser::whereIn('role_id',$allowed)->where('status_user','A')->where('foreign_id', $po->id_vendor)->get();
            foreach($user as $vendor_user){
                if (filter_var($vendor_user->username, FILTER_VALIDATE_EMAIL)) {
                    
                    $mailVendorUser[]=$vendor_user->username;
                    
                }
            }
            
            Mail::to($mailVendorUser)->cc($cc)->send(new PoMail($po, $vendor_user));
            //Set field 'sent' untuk flag terkirim
           
            // $nameGroupMail  = $this->split_creator($po->creator);
            // $emailgrp = EmailGroup::where('abrev',$nameGroupMail)->first();

            // if(!empty($emailgrp))
            // {
            //    $emaillist = $emailgrp->mailgroup;
            //     //TO USER
            //     //TO Listed Group DEPT
            //     $cc = [];
            //     foreach ($emaillist as $e) {
            //         if (filter_var($e->mail, FILTER_VALIDATE_EMAIL)) {
            //          $cc[] =$e->mail;
            //         }
                
            //     }
            //     Mail::to($user->username)->cc($cc)->send(new PoMail($po, $user));
            //     //set sent datetime
            //     Po::where('_id',$po->id)->update(['sent' => date('Y-m-d H:i:s')]); 
            // } else{
            //     throw new Exception("Email Group ".$nameGroupMail." is not Found.");
            // }
            
        
    }

    private function split_creator($creator)
    {
        try{
             //PISAHKAN TEXT dan Spesial Karakter
            $get_group = array_filter(preg_split('/(\w+)/', $creator, -1, PREG_SPLIT_DELIM_CAPTURE));
            // Pisahkan numeric dan alpha
            // Pisahkan numeric dan alpha
            $res = [];
            foreach($get_group as $key => $gg)
            {
                $res[] = $gg;
            }
            // dd($res);
            $get_name = sscanf(isset($res[2]) ? $res[2]:$res[0], "%[A-Z]%d");
            //Get PUR
            return $get_name[0];
        } catch(\Exception $e)
        {
            throw new Exception("Creator format is invalid. Accept : DPM-{ex: PUR03 or INVMGR}");
        }
       
    }

    private function reIndexArray( $arr, $startAt=0 )
    {
        return ( 0 == $startAt )
            ? array_values( array_filter($arr) )
            : array_combine( array_filter(range( $startAt, count( $arr ) + ( $startAt - 1 ) ), array_values( $arr )) );
    }
}
