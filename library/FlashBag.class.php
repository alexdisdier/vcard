<?php

class FlashBag
{
    public function __construct()
    {
        if(session_status() == PHP_SESSION_NONE)
        {
            session_start();
        }

        // Do we have already a flash bag ?
        if(array_key_exists('flash-bag', $_SESSION) == false)
        {
            // No, create it.
            $_SESSION['flash-bag'] = array();
        }
    }

    public function add($message)
    {
        // Add the specified message at the end of the flash bag.
        array_push($_SESSION['flash-bag'], $message);
    }

    public function fetchMessage()
    {
        // Consume the oldest flash bag message.
        return array_shift($_SESSION['flash-bag']);
    }

    public function fetchMessages()
    {
        // Consume all the flash bag messages.
        $messages = $_SESSION['flash-bag'];

        // The flash bag is now empty.
        $_SESSION['flash-bag'] = array();

        return $messages;
    }

    public function hasMessages()
    {
        // Do we have some messages in the flash bag ?
        return empty($_SESSION['flash-bag']) == false;
    }
}