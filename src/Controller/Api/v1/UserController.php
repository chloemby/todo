<?php

namespace App\Controller\Api\v1;


use App\Repository\UserRepository;
use Exception;
use InvalidArgumentException;
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
     *
     * @Route("/user", name="users", methods={"PUT"})
     * @param Request $request
     * @param UserRepository $userRepository
     * @return Response
     */
    public function createUser(Request $request, UserRepository $userRepository): Response
    {
        try {
            $phone = $request->get('phone', null);
            if (!$phone || is_null($phone)) {
                throw new InvalidArgumentException('Неверно указан номер пользователя', Response::HTTP_BAD_REQUEST);
            }
        } catch (Exception $e) {
            return $this->response([], $this::SERVER_ERROR_MESSAGE, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
