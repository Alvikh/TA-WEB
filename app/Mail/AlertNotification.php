<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Device;
use App\Models\User;
use Illuminate\Support\Str;

class AlertNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $type;
    public $message;
    public $severity;
    public $device;
    public $user;
    public $alertId;

    /**
     * Create a new message instance.
     *
     * @param string $type
     * @param string $message
     * @param string $severity
     * @param Device $device
     * @param User $user
     */
    public function __construct($type, $message, $severity, Device $device, User $user)
    {
        $this->type = $type;
        $this->message = $message;
        $this->severity = $severity;
        $this->device = $device;
        $this->user = $user;
        $this->alertId = Str::uuid();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('[Alert] ' . ucfirst($this->type) . ' - ' . ucfirst($this->severity) . ' Priority')
                   ->view('emails.alert')
                   ->with([
                       'userName' => $this->user->name,
                       'type' => $this->type,
                       'messageContent' => $this->message,
                       'severity' => $this->severity,
                       'deviceId' => $this->device->device_id,
                       'deviceName' => $this->device->name,
                       'deviceLocation' => $this->device->building,
                       'alertTime' => now()->format('d M Y, H:i'),
                       'alertId' => $this->alertId
                   ]);
    }
}