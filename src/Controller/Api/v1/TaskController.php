<?php

declare(strict_types=1);


namespace App\Controller\Api\v1;

use App\Services\Exceptions\TaskServiceException;
use DateTime;
use Throwable;
use InvalidArgumentException;
use App\Builder\TaskBuilder;
use App\Services\TaskService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class TaskController
 * @package App\Controller\Api\v1
 */
class TaskController extends BaseController
{
    public function __construct(TaskService $service, TaskBuilder $builder)
    {
        $this->service = $service;
        $this->builder = $builder;
    }

    /**
     * Получить задачи пользователя за период
     *
     * @Route("/task", name="tasks", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function getTasksAction(Request $request): JsonResponse
    {
        try {
            $userId = intval($request->get('user_id', null));
            if (!$userId) {
                throw new InvalidArgumentException('Такого пользователя не существует', Response::HTTP_BAD_REQUEST);
            }
            $dateStart = $request->get('date_start', date('Y-m-01 00:00:00'));
            if (!$dateStart) {
                throw new InvalidArgumentException('Неверно передана дата начала действия задач', Response::HTTP_BAD_REQUEST);
            }
            $dateStart = DateTime::createFromFormat('Y-m-d H:i:s', $dateStart);
            $dateEnd = $request->get('date_end', date('Y-m-t 23:59:59'));
            $dateEnd = DateTime::createFromFormat('Y-m-d H:i:s', $dateEnd);
            $offset = $request->get('offset', 0);
            $limit = $request->get('limit', 100);
            $tasks = $this->service->findByUserId($userId, $dateStart, $dateEnd, $offset, $limit);
            return $this->response($tasks);
        } catch (InvalidArgumentException $e) {
            return $this->response([], $e->getMessage(), $e->getCode());
        } catch (Throwable $e) {
            return $this->response([], $this::SERVER_ERROR_MESSAGE, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Получить задачу по ID
     *
     * @Route("/tasks/{id}", name="task_by_id", methods={"GET"})
     * @param int $id ID задачи
     * @return JsonResponse
     */
    public function getTaskAction(int $id): JsonResponse
    {
        $task = $this->service->find($id);
        #TODO сделать возвращение разных ответов в зависимости от операции(коды, сообщения и тд)
        return $this->response($task);
    }

    /**
     * Создать задачу
     *
     * @Route("/task", name="create_task", methods={"PUT"})
     * @param Request $request
     * @return JsonResponse
     */
    public function createTaskAction(Request $request): JsonResponse
    {
        try {
            $userId = $request->get('user_id', null);
            if (is_null($userId)) {
                throw new InvalidArgumentException('Такого пользователя не существует', Response::HTTP_BAD_REQUEST);
            }
            $userId = intval($userId);
            $startDate = $request->get('start_date', date('Y-m-d H:i:s'));
            if (!$startDate || !$startDate = DateTime::createFromFormat('Y-m-d H:i:s', $startDate)) {
                throw new InvalidArgumentException('Неверно передана дата начала действия задачи', Response::HTTP_BAD_REQUEST);
            }
            $endDate = $request->get('end_date', date('Y-m-d H:i:s', strtotime('+1 days')));
            if (!$endDate || !$endDate = DateTime::createFromFormat('Y-m-d H:i:s', $endDate)) {
                throw new InvalidArgumentException('Неверно передана дата конца действия задачи', Response::HTTP_BAD_REQUEST);
            }
            $name = $request->get('name', null);
            if (!$name) {
                throw new InvalidArgumentException('Название задачи не может быть пустым', Response::HTTP_BAD_REQUEST);
            }
            $description = $request->get('description', '');
            $task = $this->service->createTask($userId, $startDate, $endDate, $name, $description);
            return $this->response($task);
        } catch (InvalidArgumentException $e) {
            return $this->response([], $e->getMessage(), $e->getCode());
        } catch (TaskServiceException $e) {
            return $this->response([], $e->getMessage(), $e->getCode());
        } catch (Throwable $e) {
            return $this->response([], $this::SERVER_ERROR_MESSAGE, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}