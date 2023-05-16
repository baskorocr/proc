<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email,$newpassword,$nm_vendor)
    {
        $this->email = $email;
        $this->newpassword = $newpassword;
        $this->nm_vendor = $nm_vendor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         $email = $this->email;
        $newpassword = $this->newpassword;
        $nm_vendor = $this->nm_vendor;
        $date = date("d-m-Y H:i:s");
        return $this->subject('User Password Reset - eProc PT Dharma Polimetal ('.$date.') [NO REPLY]')
                   ->view('mails.reset_password')->with(['email' => $email,'password' => $newpassword,'nm_vendor' => $nm_vendor]);
    }
}
