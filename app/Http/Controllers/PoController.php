<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Po;
use App\Models\User;
use App\Models\EmailGroup;
use Mail;
use App\Mail\PoMail;
use Exception;
use Carbon\Carbon;

class PoController extends Controller
{
    public function sendPo(Request $request)
    {
        $user = User::where('id_user', $request->id_user)->first();
        $msg_mail = '';
        $msg_data = '';

        $cekPo = Po::where('po_num', $request->po_num)->where('revno', $request->revno)->get();
        
        $po = new Po;
        
        if(count($cekPo) > 0) {
            $msg_data = 'PO send to eproc failed, cannot insert duplicate data po with same revno.';
        } else {
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
            $po->file_nm = $request->file_name;
            $po->sent = $request->sent;
            $po->downloaded = $request->downloaded;
            $po->accepted = $request->accepted;
            $po->id_user = $request->id_user;
            $po->last_change = $request->last_change;
            $po->revno = $request->revno;
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
        
        if($user){
            if($user->status_user === 'A'){

                try {
                    $this->mailer_send($po, $user);
                    // Mail::to($user->username)->send(new PoMail($po, $user));
                    $msg_mail = 'PO send mailed to vendor successfully.';
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
                    'msg_mail' => 'PO send to vendor failed. 1',
                    //'data' => $po
                ], 422);
            }
        } else {
            return response()->json([
                'msg_data' => $msg_data,
                'msg_mail' => 'PO send to vendor failed. 2',
                    //'data' => $po
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
        $po = Po::where('po_num', $request->po_num)->first();
        $user = User::where('id_user', $po->id_user)->first();

        if($user){
            if($user->status_user === 'A'){

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
        $nameGroupMail  = $this->split_creator($po->creator);

        $emaillist = EmailGroup::where('abrev',$nameGroupMail)->first()->mailgroup;
        //TO USER
        //TO Listed Group DEPT
        $cc = [];
        foreach ($emaillist as $e) {
            if (filter_var($e->mail, FILTER_VALIDATE_EMAIL)) {
             $cc[] =$e->mail;
            }
        
        }
        Mail::to($user->username)->cc($cc)->send(new PoMail($po, $user));
        //set sent datetime
        Po::where('_id',$po->id)->update(['sent' => date('Y-m-d H:i:s')]);
    }

    private function split_creator($creator)
    {
        //PISAHKAN TEXT dan Spesial Karakter
        $get_group = preg_split('/(\w+)/', $creator, -1, PREG_SPLIT_DELIM_CAPTURE);
        // Pisahkan numeric dan alpha
        $get_name = sscanf($get_group[3], "%[A-Z]%d");
        //Get PUR
        return $get_name[0];
    }
}
