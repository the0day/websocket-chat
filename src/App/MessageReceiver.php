<?php

namespace App;

use App\Commands\Command;
use Exception;

/**
 * Класс отвечает за обработку запроса клиента
 * Пример входящего запроса:
 * {message: "{текст сообщения}", action: "{команда:send|auth}"}
 * Class MessageReceiver
 * @package App
 */
class MessageReceiver {
    protected array $input;
    protected $message;
    protected Command $action;

    public function __construct($input)
    {
        try {
            $this->input = $this->getInput($input);
            $this->message = isset($this->input['message']) ? $this->input['message'] : null;

            $this->action = $this->getCommandInstance();
            //$this->action = new $commandClass($this->message);
        } catch (Exception $e) {
            echo $e->getTraceAsString();
        }

    }

    /**
     * Метод возвращает экземпляр класса команды пользователя
     *
     * @return Command
     */
    public function command()
    {
        return $this->action;
    }

    /**
     * Метод декодирует полученный запрос из JSON в массив
     *
     * @param $input
     * @return mixed
     * @throws Exception
     */
    protected function getInput($input)
    {
        $input = json_decode($input, true);

        if (json_last_error() !== JSON_ERROR_NONE || !isset($input['action']))
            throw new Exception('Неверный формат сообщения');

        return $input;
    }

    /**
     * Метод возвращает имя класса
     * @return string
     * @throws Exception
     */
    protected function getCommandInstance()
    {
        $action = "App\Commands\\".ucfirst( (string) $this->input['action'] );

        if (!class_exists($action)) {
            throw new Exception('Класс '.$action.' не найден!');
        }
        
        return new $action($this->message);
    }
}