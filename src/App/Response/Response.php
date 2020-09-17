<?php

namespace App\Response;

/**
 * Class Response
 * Класс отвечает за формирование запроса:
 * {
    code => 200
    status => тип ответа (new|auth)
    data => тело ответа
 * }
 * @package App\Response
 */
class Response
{
    protected int $code = 200;
    protected string $method;
    protected $data;

    public function __construct($method, $data = null)
    {
        $this->method = $method;
        $this->data = $data;
    }

    public function getOutput() {
        return [
            'code' => $this->code,
            'status' => $this->method,
            'data' => $this->data
        ];
    }

    public function toJson()
    {
        return json_encode($this->getOutput());
    }

    public function __toString()
    {
        return $this->toJson();
    }
}