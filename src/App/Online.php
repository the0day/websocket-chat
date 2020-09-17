<?php

namespace App;

use Ratchet\ConnectionInterface;

/**
 * Class Online
 * Отвечает за хранение подключенных пользователей
 * А так же за поиск пользователя по ID подключения
 * @package App
 */
class Online {
    protected array $users;

    public function __construct()
    {
        $this->users = [];
    }

    /**
     * Количество подключенных пользователей
     * @return int
     */
    public function count(): int
    {
        return count($this->users);
    }

    /**
     * Метод возвращает экземпляр класса User по ID подключения
     * @param ConnectionInterface $conn
     * @return User
     */
    public function getUser(ConnectionInterface $conn): User
    {
        return isset($this->users[$conn->resourceId]) ? $this->users[$conn->resourceId] : null;
    }

    /**
     * Метод создает новый экземпляр User
     * и добавляем в массив подключенных пользователей - $this->users
     * @param ConnectionInterface $conn
     */
    public function connect(ConnectionInterface $conn): void
    {
        $this->users[$conn->resourceId] = new User($conn);
    }

    /**
     * Метод удаляет из массива подключенных пользователей
     * конкретное подключение
     * @param ConnectionInterface $conn
     */
    public function disconnect(ConnectionInterface $conn): void
    {
        unset($this->users[$conn->resourceId]);
    }

    /**
     * Метод возвращает список имен пользователей
     * @return array
     */
    public function getUserlist()
    {
        $users = [];

        /** @var User $user */
        foreach ($this->users as $user) {
            $users[] = $user->getName();
        }
        return $users;
    }

    /**
     * Массив возвращает массив User
     * @return array
     */
    public function getUsers(): array
    {
        return $this->users;
    }
}