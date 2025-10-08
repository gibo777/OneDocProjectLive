<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OvertimeRequested extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $newOT;
    public $action;
    public $approveUrl;
    public $denyUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($newOT, $action, $approveUrl, $denyUrl)
    {
        $this->newOT        = $newOT;
        $this->action       = $action;
        $this->approveUrl   = $approveUrl;
        $this->denyUrl      = $denyUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->markdown('emails.overtime-request')
        //     ->with([
        //         'newOT' => $this->newOT,
        //         'action' => $this->action,
        //         'approveUrl' => $this->approveUrl,
        //         'denyUrl' => $this->denyUrl,
        //     ]);


        return $this->view('emails.overtime-request')
            ->subject('Overtime Request Submitted')
            ->with([
                'newOT'         => $this->newOT,
                'action'        => $this->action,
                'approveUrl'    => $this->approveUrl,
                'denyUrl'       => $this->denyUrl,
            ]);

        // switch (strtolower($this->event)) {
        //     case 'approved':
        //         return $this->view('emails.leave-application-decided')
        //                     ->subject('Leave Application Approved')
        //                     ->with([
        //                         'dLeave' => $this->newLeave,
        //                         'decide' => $this->event,
        //                     ]);
        //         break;
        //     case 'denied':
        //     case 'cancelled':
        //         return $this->view('emails.leave-application-decided')
        //                     ->subject('Leave Application '.$this->event)
        //                     ->with([
        //                         'dLeave' => $this->newLeave,
        //                         'decide' => $this->event,
        //                     ]);
        //         break;

        //     default:
        //         return $this->view('emails.leave-application-submitted')
        //                     ->subject('Overtime Request Submitted')
        //                     ->with([
        //                         'newOT'  => $this->newOT,
        //                         'approveUrl'=> $this->approveUrl,
        //                         'denyUrl'   => $this->denyUrl,
        //                     ]);
        //         break;
        // }
    }
}
