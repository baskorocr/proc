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
    public $vendor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($po, $vendor)
    {
        $this->po = $po;
        $this->vendor = $vendor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.pomail', ['po' => $this->po, 'vendor' => $this->vendor]);
    }
}
