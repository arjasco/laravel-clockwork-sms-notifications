<?php

namespace Arjasco\ClockworkSms;

class ClockworkSmsMessage
{
    /**
     * Message content.
     * 
     * @var string
     */
    public $content;

    /**
     * The phone number the message should be sent from.
     * 
     * @var string
     */
    public $from;

    /**
     * The long message parameter.
     * 
     * @var bool
     */
    public $long = false;

    /**
     * Create a new Clockwork SMS mesage instance.
     * 
     * @param string $content
     */
    public function __construct($content = '')
    {
        $this->content = $content;
    }

    /**
     * Set the phone number the message should be sent from.
     * 
     * @param  string $number
     * @return $this
     */
    public function from($number)
    {
        $this->from = $number;

        return $this;
    }

    /**
     * Set the message content.
     * 
     * @param  string $message
     * @return $this
     */
    public function content($message)
    {
        $this->content = $message;

        return $this;
    }

    /**
     * Set the long message parameter.
     * 
     * @param  string $message
     * @return $this
     */
    public function long($active = true)
    {
        $this->long = $active;

        return $this;
    }
}