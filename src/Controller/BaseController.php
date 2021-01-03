<?php


namespace App\Controller;


use App\Service\ApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class BaseController extends AbstractController
{
    /**
     * Сообщение для ответа при неизвестной ошибке
     */
    const SERVER_ERROR_MESSAGE = 'Произошла неизвестная ошибка, обратитесь в поддержку';

    /**
     * Сообщение при успешном ответе
     */
    const OK_MESSAGE = 'OK';

    public function response($data, string $message = self::OK_MESSAGE, int $status = Response::HTTP_OK): JsonResponse
    {
        $response = new ApiResponse($data, $message);
        return new JsonResponse($response->arraySerialize(), $status);
    }
}