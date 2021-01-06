<?php


namespace App\Controller\Api\v1;


use App\Builder\BuilderInterface;
use App\Services\AbstractService;
use App\Services\Helpers\ApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Базовый контроллер
 *
 * Class BaseController
 * @package App\Controller
 */
class BaseController extends AbstractController
{
    /**
     * @var AbstractService
     */
    protected $service;

    /**
     * @var BuilderInterface
     */
    protected $builder;

    public function __construct(AbstractService $service, BuilderInterface $builder)
    {
        $this->service = $service;
        $this->builder = $builder;
    }

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