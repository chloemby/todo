<?php


namespace App\Service;

use JsonSerializable;


/**
 * Класс для создания и сериализации стандартизированного ответа API
 *
 * Class ApiResponse
 * @package App\Service
 */
class ApiResponse
{
    /**
     * Данные ответа
     *
     * @var array
     */
    private $data = [];

    /**
     * Сообщение ответа
     *
     * @var string
     */
    private $message = '';

    public function __construct($data, string $message = '')
    {
        $this->data = $data;
        $this->message = $message;
    }

    /**
     * Сериализовать ответ в массив
     *
     * @return array
     */
    public function arraySerialize(): array
    {
        return [
            'data' => $this->data,
            'message' => $this->message
        ];
    }
}