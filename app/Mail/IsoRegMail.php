<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use IsoHelper;

class IsoRegMail extends Mailable
{
     use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($regisiso)
    {
        $this->regisiso = $regisiso;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $regisiso = $this->regisiso;
        $date = date("d-m-Y H:i:s");
        $trans = IsoHelper::get_transaction_type_id_first($regisiso->trn_type);
        
        return $this->subject('DOC ISO Notification ['.@$trans->trn_name.'] from PT Dharma Polimetal ('.$date.') [NO REPLY]')
                   ->view('mails/iso_reg_mail')->with(['regisiso' => $regisiso]);
    }
}
