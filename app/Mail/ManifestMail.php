<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ManifestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $manifest;
    public $vendor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($manifest, $vendor)
    {
        $this->manifest = $manifest;
        $this->vendor = $vendor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $date = date("d-m-Y H:i:s");
        return $this->subject('Manifest Order from PT Dharma Polimetal ('.$date.') [NO REPLY]')->markdown('mails.manifestmailnew', ['manifest' => $this->manifest, 'vendor' => $this->vendor]);
    }
}
