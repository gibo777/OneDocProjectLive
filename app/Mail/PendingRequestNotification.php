<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PendingRequestNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $head_id;
    public $head_name;
    public $sex;
    public $pendingCount;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($head_id, $head_name, $sex, $pendingCount)
    {
        $this->head_id      = $head_id;
        $this->head_name    = $head_name;
        $this->sex          = $sex;
        $this->pendingCount = $pendingCount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.pending-leave-notification')
            ->subject('Pending Requests')
            ->with([
                'head_id'   => $this->head_id,
                'head_name' => $this->head_name,
                'head_sex'  => $this->sex,
                'pendingLeaveCount'  => $this->pendingCount['pendingLeaveCount'] ?? 0,
                'pendingOvertimes'   => $this->pendingCount['pendingOvertimes'] ?? 0,
            ]);
    }
}
