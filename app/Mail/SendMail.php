<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        /*$data = [
            'title' => 'Gibs Testing Send Email',
            'body' => 'This is for testing email using smtp'
        ];

        return $this->view('utilities.send-mail', ['data'=>$data]);*/
        
        return $this->view('utilities.send-mail');
    }
}
