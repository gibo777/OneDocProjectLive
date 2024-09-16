<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveApplicationSubmitted extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $newLeave;
    public $approveUrl;
    public $denyUrl;

    /**
     * Create a new message instance.
     *
     * @param  mixed  $newLeave
     * @param  string  $approveUrl
     * @param  string  $denyUrl
     * @return void
     */
    public function __construct($newLeave, $approveUrl, $denyUrl)
    {
        $this->newLeave   = $newLeave;
        $this->approveUrl = $approveUrl;
        $this->denyUrl    = $denyUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.leave-application-submitted')
                    ->subject('Leave Application Submitted')
                    ->with([
                        'newLeave'  => $this->newLeave,
                        'approveUrl'=> $this->approveUrl,
                        'denyUrl'   => $this->denyUrl,
                    ]);
    }
}
