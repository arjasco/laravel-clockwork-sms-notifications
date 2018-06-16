<?php

use Arjasco\ClockworkSms\ClockworkSmsChannel;
use Arjasco\ClockworkSms\ClockworkSmsMessage;
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
    public function testThatWeCanSendAnSmsMessageWithADefaultFromNumber()
    {
        $channel = new ClockworkSmsChannel(
            $clockwork = m::mock(Clockwork::class),
            'Test'
        );

        $clockwork->shouldReceive('send')->once()->with([
            'to' => '123456789',
            'from' => 'Test',
            'message' => 'Testing sms sending',
            'long' => false
        ]);

        $channel->send(new ClockworkTestNotifiable, new ClockworkTestNotification);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testThatWeCanSendAnSmsMessageWithAMessageInstance()
    {
        $channel = new ClockworkSmsChannel(
            $clockwork = m::mock(Clockwork::class),
            'Test'
        );

        $clockwork->shouldReceive('send')->once()->with([
            'to' => '123456789',
            'from' => '111222333444',
            'message' => 'Test content',
            'long' => true
        ]);

        $channel->send(new ClockworkTestNotifiable, new ClockworkTestNotificationWithMessage);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testThatWeDoNothingIfNoRouteIsProvided()
    {
        $channel = new ClockworkSmsChannel(
            $clockwork = m::mock(Clockwork::class),
            'Test'
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

class ClockworkTestNotificationWithMessage extends Notification {
    public function toClockworkSms($notifiable)
    {
        return (new ClockworkSmsMessage)
                    ->from('111222333444')
                    ->content('Test content')
                    ->long();
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