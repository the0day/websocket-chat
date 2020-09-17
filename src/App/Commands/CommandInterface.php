<?php

namespace App\Commands;

use App\Chat;
use Ratchet\ConnectionInterface;

/**
 * Интерфейс Команды
 */
interface CommandInterface
{
    /**
     * Метод выполнения команды
     */
    public function run();
}