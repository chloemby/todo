<?php


namespace App\Services\Helpers;



/**
 * Класс для создания и сериализации стандартизированного ответа API
 *
 * Class ApiResponse
 * @package App\Service
 */
class ApiResponse
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * Сообщение ответа
     */
    private string $message;

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