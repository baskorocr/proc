<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Po;
use App\Models\User;
use App\Models\EmailGroup;
use Mail;
use App\Mail\PoMail;
use Carbon\Carbon;

class PoController extends Controller
{
    public function sendPo(Request $request)
    {
        $user = User::where('id_user', $request->id_user)->first();
        $msg_mail = '';

        if($user){
            if($user->status_user === 'A'){
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
                $po->pgr = $request->pgr;
                $po->porg = $request->porg;
                $po->creator = $request->creator;
                $po->file_nm = $request->file_nm;
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

                //Mail::to($vendor->vend_email)->send(new PoMail($po, $vendor));
                
                
                try {
                    $this->mailer_send($po, $user);
                    // Mail::to($user->username)->send(new PoMail($po, $user));
                    $msg_mail = 'PO send mailed to vendor successfully.';
                } catch (Exception $e) {
                    $msg_mail = $e->getMessage();
                }

                return response()->json([
                    'msg_data' => 'PO send to eproc saved successfully.',
                    'msg_mail' => $msg_mail,
                    'data' => $po
                ], 200);
            } else {
                return response()->json([
                    'msg_data' => 'PO send to eproc failed, Mail user not active!',
                    'msg_mail' => 'PO send to vendor failed.',
                    //'data' => $po
                ], 422);
            }
        } else {
            return response()->json([
                'msg_data' => 'PO send to eproc failed, ID User Not Found!',
                'msg_mail' => 'PO send to vendor failed.',
                    //'data' => $po
            ], 422);
        }
    }

    public function resendEmailPo(Request $request)
    {
        //$vendor = Vendor::where('id_vendor', $request->id_vendor)->first();
        $po = Po::where('po_num', $request->po_num)->first();
        $user = User::where('id_user', $po->id_user)->first();
        $msg_mail = '';

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
                    'msg_data' => 'PO send to eproc saved successfully.',
                    'msg_mail' => $msg_mail,
                    'data' => $po
                ], 200);
            } else {
                return response()->json([
                    'msg_data' => 'PO send to eproc failed, Mail user not active!',
                    'msg_mail' => 'PO send to vendor failed.',
                    //'data' => $po
                ], 422);
            }
        } else {
            return response()->json([
                'msg_data' => 'PO send to eproc failed, ID User Not Found!',
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
        Mail::to($user->username)->send(new PoMail($po, $user));
        //TO Listed Group DEPT
        foreach ($emaillist as $e) {
             Mail::to($e->mail)->send(new PoMail($po, $user));
        }
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
