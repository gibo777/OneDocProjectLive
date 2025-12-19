<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OvertimeRequested extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $dOvertime;
    public $action;
    public $approveUrl;
    public $denyUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dOvertime, $action, $approveUrl, $denyUrl)
    {
        $this->dOvertime    = $dOvertime;
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
        switch (strtolower($this->action)) {
            case 'approved':
                return $this->view('emails.overtime-decided')
                    ->subject('Overtime Request Approved')
                    ->with([
                        'dOvertime' => $this->dOvertime,
                        'action'    => $this->action,
                    ]);
                break;
            case 'denied':
            case 'cancelled':
                return $this->view('emails.overtime-decided')
                    ->subject('Overtime Request ' . $this->action)
                    ->with([
                        'dOvertime'     => $this->dOvertime,
                        'action'        => $this->action,
                        'approveUrl'    => $this->approveUrl,
                        'denyUrl'       => $this->denyUrl,
                    ]);
                break;
            default:
                return $this->view('emails.overtime-request')
                    ->subject('Overtime Request Submitted')
                    ->with([
                        'dOvertime'     => $this->dOvertime,
                        'action'        => $this->action,
                        'approveUrl'    => $this->approveUrl,
                        'denyUrl'       => $this->denyUrl,
                    ]);
                break;
        }
    }
}
