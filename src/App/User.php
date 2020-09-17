<?php

namespace App;


use Ratchet\ConnectionInterface;

/**
 * Class User
 * @package App
 */
class User
{
    /**
     * @var string имя пользователя
     */
    private string $name;

    private ConnectionInterface $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
        $this->name = 'Гость';
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function send($text)
    {
        return $this->connection->send($text);
    }
}