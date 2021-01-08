<?php

namespace App\Controller\Api\v1;


use App\Builder\UserBuilder;
use App\Services\UserService;
use Exception;
use InvalidArgumentException;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends BaseController
{
    /**
     * UserController constructor.
     * @param UserService $service
     * @param UserBuilder $builder
     */
    public function __construct(UserService $service, UserBuilder $builder)
    {
        $this->service = $service;
        $this->builder = $builder;
    }

    /**
     *
     * @Route("/user", name="user", methods={"PUT"})
     * @param Request $request
     * @return JsonResponse
     */
    public function createUser(Request $request): JsonResponse
    {
        try {
            $phone = $request->get('phone', null);
            if (!$phone) {
                throw new InvalidArgumentException('Неверно указан номер пользователя', Response::HTTP_BAD_REQUEST);
            }
            $name = $request->get('name', null);
            if (!$name) {
                throw new InvalidArgumentException('Неверно указано имя пользователя', Response::HTTP_BAD_REQUEST);
            }
            $user = $this->service->createUser($phone, $name);
            return $this->response($user);
        } catch (Exception $e) {
            return $this->response([], $this::SERVER_ERROR_MESSAGE, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
