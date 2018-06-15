<?php

use Arjasco\ClockworkSms\ClockworkSmsChannel;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Notifiable;
use mediaburst\ClockworkSMS\Clockwork;
use PHPUnit\Framework\TestCase;
use Mockery as m;

class ClockworkSmsChannelTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testThatWeCanSendAnSmsMessage()
    {
        $channel = new ClockworkSmsChannel(
            $clockwork = m::mock(Clockwork::class)
        );

        $clockwork->shouldReceive('send')->once()->with([
            'to' => '123456789',
            'message' => 'Testing sms sending'
        ]);

        $channel->send(new ClockworkTestNotifiable, new ClockworkTestNotification);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testThatWeDoNothingIfNoRouteIsProvided()
    {
        $channel = new ClockworkSmsChannel(
            $clockwork = m::mock(Clockwork::class)
        );

        $clockwork->shouldNotReceive('send');

        $channel->send(new ClockworkTestNotifiableNoRoute, new ClockworkTestNotification);
    }
}

class ClockworkTestNotification extends Notification {
    public function toClockworkSms($notifiable)
    {
        return 'Testing sms sending';
    }
}

class ClockworkTestNotifiable {
    use Notifiable;

    public function routeNotificationForClockworkSms($notification)
    {
        return '123456789';
    }
}

class ClockworkTestNotifiableNoRoute {
    use Notifiable;
}