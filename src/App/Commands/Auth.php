<?php

namespace App\Commands;


use App\Response\Response;
use Exception;

/**
 * Class Auth
 * Команда для авторизации пользователя
 * @package App\Commands
 */
class Auth extends Command {

    /**
     * @throws Exception
     */
    protected function validate()
    {
        if (empty($this->getMessage())) {
            throw new Exception("Имя не должно быть пустым");
        }
        return true;
    }


    public function run()
    {
        try {
            $this->validate();

            $user = $this->chat->getOnline()->getUser($this->from);

            $user->setName($this->message);
            $this->chat->sendOnline();
            $user->send(new Response('auth'));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}