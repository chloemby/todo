<?php

namespace App\Controller\Api\v1;


use Throwable;
use App\Builder\UserBuilder;
use App\Service\UserService;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/users", name="create_user", methods={"PUT"})
     * @param Request $request
     * @return JsonResponse
     */
    public function createUserAction(Request $request): JsonResponse
    {
        try {
            $phone = $request->get('phone');
            if (!$phone) {
                throw new InvalidArgumentException('Неверно указан номер пользователя', Response::HTTP_BAD_REQUEST);
            }
            $name = $request->get('name');
            if (!$name) {
                throw new InvalidArgumentException('Неверно указано имя пользователя', Response::HTTP_BAD_REQUEST);
            }
            $user = $this->service->createUser($phone, $name);
            return $this->response($user);
        } catch (\Throwable $e) {
            return $this->response([], $this::SERVER_ERROR_MESSAGE, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @Route("/users/{id}", name="user_by_id", methods={"GET"})
     * @param int $id
     * @return JsonResponse
     */
    public function getUserAction(int $id): JsonResponse
    {
        try {
            return $this->response($this->service->find($id));
        } catch (Throwable $e) {
            return $this->response([], $this::SERVER_ERROR_MESSAGE, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
