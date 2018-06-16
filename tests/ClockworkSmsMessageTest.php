<?php

use Arjasco\ClockworkSms\ClockworkSmsMessage;
use PHPUnit\Framework\TestCase;

class ClockworkSmsMessageTest extends TestCase
{
    public function testThatWeCanAddAFromNumber()
    {
        $message = new ClockworkSmsMessage;
        $message->from('123456789');

        $this->assertSame('123456789', $message->from);
    }

    public function testThatWeCanAddContentToTheMessage()
    {
        $message = new ClockworkSmsMessage('Constructor content');

        $this->assertSame('Constructor content', $message->content);

        $message->content('Content via the method');

        $this->assertSame('Content via the method', $message->content);
    }

    public function testThatWeCanSetTheLongFlag()
    {
        $message = new ClockworkSmsMessage;

        // Initial should be flase
        $this->assertFalse($message->long);

        $message->long();

        $this->assertTrue($message->long);

        // Explicitly set as false.
        $message->long(false);

        $this->assertFalse($message->long);
    }

    public function testthatWeCanChainMethods()
    {
        $message = (new ClockworkSmsMessage)
                    ->from('123456789')
                    ->content('Test content')
                    ->long();

        $this->assertSame('123456789', $message->from);
        $this->assertSame('Test content', $message->content);
        $this->assertTrue($message->long);
    }
}