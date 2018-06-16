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
     * The default from phone number.
     * 
     * @var mixed
     */
    protected $from;

    /**
     * Create a new Clockwork SMS channel instance.
     * 
     * @param \mediaburst\ClockworkSMS\Clockwork $clockwork
     * @param mixed $from
     */
    public function __construct(Clockwork $clockwork, $from = null)
    {
        $this->clockwork = $clockwork;
        $this->from = $from;
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

        $message = $notification->toClockworkSms($notifiable);

        if (is_string($message)) {
            $message = new ClockworkSmsMessage($message);
        }

        return $this->clockwork->send([
            'to' => $to,
            'from' => $message->from ?: $this->from,
            'message' => $message->content,
            'long' => $message->long
        ]);
    }
}