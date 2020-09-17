<?php

namespace App;

use App\Response\Error;
use App\Response\Response;
use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;


class Chat implements MessageComponentInterface {

    /**
     * @var Online
     */
    protected Online $online;

    public function __construct()
    {
        $this->online = new Online;
    }

    /**
     * @inheritDoc
     */
    function onOpen(ConnectionInterface $conn)
    {
        $this->online->connect($conn);
        echo "New connection!\n";
    }

    /**
     * @inheritDoc
     */
    function onClose(ConnectionInterface $conn)
    {
        $this->online->disconnect($conn);
        $this->sendOnline();
        echo "Connection has disconnected!\n";
    }

    /**
     * @inheritDoc
     */
    function onError(ConnectionInterface $conn, Exception $e)
    {
        echo "Error:". $e->getMessage();
        $conn->close();
    }

    /**
     * @inheritDoc
     */
    function onMessage(ConnectionInterface $from, $income)
    {
        try {
            $receiver = new MessageReceiver($income);
            $receiver->command()->execute($this, $from);
        } catch (Exception $e) {
            $from->send(new Error("Произошла ошибка: ".$e->getMessage()));
        }
    }


    /**
     * Отправить сообщение всем клиентам
     * @param $message
     */
    public function sendAll($message, User $from): void
    {
        foreach ($this->online->getUsers() as $user) {
            $user->send(new Response("new", [
                'date' => date("Y-m-d H:i:s"),
                'sender' => $from->getName(),
                'text' => $message
            ]));
        }
    }

    /**
     * Отправить имена участников всем подключенным клиентам
     */
    public function sendOnline(): void
    {
        $userList = $this->online->getUserlist();

        foreach ($this->online->getUsers() as $user) {
            $user->send(new Response("online", $userList));
        }
    }

    /**
     * Вернуть экземпляр класса Online
     * @return Online
     */
    public function getOnline(): Online
    {
        return $this->online;
    }
}