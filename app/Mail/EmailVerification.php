<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    protected $act;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$act)
    {
        $this->user = $user;
        $this->act = $act;
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->act==0){
        return $this->view('email.email_subscribed')->with(['email_token' => $this->user->email_token,]);
    }
    else if($this->act==1){
        return $this->view('email.email_unsubscribed')->with(['email_token' => $this->user->email_token,]);
    }
    else if($this->act==2){
        return $this->view('email.email_restored')->with(['email_token' => $this->user->email_token,]);
    }
       
    }
}
