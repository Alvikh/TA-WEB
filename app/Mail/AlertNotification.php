<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AlertNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $type;
    public $message;
    public $severity;

    public function __construct($type, $message, $severity)
    {
        $this->type = $type;
        $this->message = $message;
        $this->severity = $severity;
    }

    public function build()
    {
        return $this->subject('Alert Notification: ' . ucfirst($this->type))
                   ->view('emails.alert')
                   ->with([
                       'type' => $this->type,
                       'messageContent' => $this->message,
                       'severity' => $this->severity
                   ]);
    }
}   