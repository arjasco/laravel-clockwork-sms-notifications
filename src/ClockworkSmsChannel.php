<?php

namespace Arjasco\ClockworkSms;

use mediaburst\ClockworkSMS\Clockwork;

class ClockworkSmsChannel
{
    /**
     * Clockwork SMS instance.
     * 
     * @var \mediaburst\ClockworkSMS\Clockwork
     */
    protected $clockwork;

    /**
     * Create a new Clockwork SMS channel instance.
     * 
     * @param \mediaburst\ClockworkSMS\Clockwork $clockwork
     */
    public function __construct(Clockwork $clockwork)
    {
        $this->clockwork = $clockwork;
    }

    /**
     * Send the notification.
     * 
     * @param  mixed $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @throws \mediaburst\ClockworkSMS\ClockworkException
     * @return array
     */
    public function send($notifiable, $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('clockworkSms', $notification)) {
            return;
        }

        return $this->clockwork->send([
            'to' => $to,
            'message' => (string) $notification->toClockworkSms($notifiable)
        ]);
    }
}