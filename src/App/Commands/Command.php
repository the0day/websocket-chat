<?php

namespace App\Commands;


use App\Chat;
use Ratchet\ConnectionInterface;

abstract class Command implements CommandInterface
{

    protected Chat $chat;
    protected ConnectionInterface $from;
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function execute(Chat $chat, ConnectionInterface $from)
    {
        $this->chat = $chat;
        $this->from = $from;
        $this->run();
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getFrom()
    {
        return $this->from;
    }
}