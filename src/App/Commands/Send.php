<?php

namespace App\Commands;

/**
 * Класс для отправки сообщений всем участникам
 *
 * Class Send
 * @package App\Commands
 */
class Send extends Command {

    public function run()
    {
        $user = $this->chat->getOnline()->getUser($this->from);

        $this->chat->sendAll($this->message, $user);
    }
}