<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPOMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($vendor,$po)
    {
        $this->vendor = $vendor;
        $this->po = $po;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $vendor = $this->vendor;
        $po = $this->po;
        $date = date("d-m-Y H:i:s");
        return $this->subject('PO from PT Dharma Polimetal ('.$date.') [NO REPLY]')
                   ->view('mails/po_mail')->with(['po' => $po,'vendor' => $vendor]);
    }
}
