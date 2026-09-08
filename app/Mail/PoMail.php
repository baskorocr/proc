<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $po;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($po, $user)
    {
        $this->po = $po;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $date = date("d-m-Y H:i:s");
        return $this->subject('PO from PT Dharma Polimetal ('.$date.') [NO REPLY]')->view('mails.pomailnew', ['po' => $this->po, 'user' => $this->user]);
    }
}
