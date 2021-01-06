<?php

declare(strict_types=1);


namespace App\Controller\Api\v1;


use App\Repository\UserRepository;
use DateTime;
use Exception;
use App\Repository\TaskRepository;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TaskController extends BaseController
{
    /**
     *
     * @Route("/task", name="tasks", methods={"GET"})
     * @param Request $request
     * @param UserRepository $userRepository
     * @return Response
     */
    public function getTasks(Request $request, UserRepository $userRepository): Response
    {
        try {
            $userId = $request->get('user_id', null);
            if (!$userId || is_null($userId)) {
                throw new InvalidArgumentException('Такого пользователя не существует', Response::HTTP_BAD_REQUEST);
            }
            $dateStart = $request->get('date_start', null);
            if (!$dateStart || is_null($dateStart)) {
                $dateStart = new DateTime(date('Y-m-01 00:00:00', time()));
            } else {
                $dateStart = DateTime::createFromFormat('Y-m-d H:i:s', $dateStart);
            }
            $dateEnd = $request->get('date_end', (new DateTime())->format('Y-m-d H:i:s'));
            if (!$dateEnd || is_null($dateEnd)) {
                $dateEnd = new DateTime(date('Y-m-t H:i:s', time()));
            } else {
                $dateEnd = DateTime::createFromFormat('Y-m-d H:i:s', $dateEnd);
            }
            $user = $userRepository->find($userId);
            if (!$user) {
                throw new InvalidArgumentException('Такого пользователя не существует', Response::HTTP_BAD_REQUEST);
            }
            $tasks = $userRepository->getUserTasks($user, $dateStart, $dateEnd);
            return $this->response($tasks);
        } catch (InvalidArgumentException $e) {
            return $this->response([], $e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            return $this->response([], $this::SERVER_ERROR_MESSAGE, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}