<?php

namespace App\Response;

/**
 * Class Error
 * Класс для ответа в случае ошибки
 * @package App\Response
 */
class Error extends Response
{
    protected int $code = 400;

    public function __construct($message)
    {
        parent::__construct("error", $message);
    }
}