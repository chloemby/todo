<?php

declare(strict_types=1);


namespace App\Controller\Api\v1;


use DateTime;
use Throwable;
use InvalidArgumentException;
use App\Builder\TaskBuilder;
use App\Services\TaskService;
use App\Services\Helpers\DateHelper;
use App\Services\Exceptions\TaskServiceException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


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
     * @Route("/tasks", name="tasks", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function getTasksAction(Request $request): JsonResponse
    {
        try {
            $userId = $request->get('user_id');
            if (!$userId) {
                throw new InvalidArgumentException('Такого пользователя не существует', Response::HTTP_BAD_REQUEST);
            }
            $userId = intval($userId);
            $dateStart = $request->get('date_start', date('Y-m-01 00:00:00'));
            if (!$dateStart || DateHelper::isDateStringValidFormat($dateStart) == false) {
                throw new InvalidArgumentException('Неверно передана дата начала действия задач', Response::HTTP_BAD_REQUEST);
            }
            $dateStart = DateTime::createFromFormat('Y-m-d H:i:s', $dateStart);
            $dateEnd = $request->get('date_end', date('Y-m-t 23:59:59'));
            if (!$dateEnd || DateHelper::isDateStringValidFormat($dateEnd) == false) {
                throw new InvalidArgumentException('Неверно передана дата конца действия задач', Response::HTTP_BAD_REQUEST);
            }
            $dateEnd = DateTime::createFromFormat('Y-m-d H:i:s', $dateEnd);
            $offset = $request->get('offset', 0);
            $limit = $request->get('limit', 100);
            $tasks = $this->service->findByUserId($userId, $dateStart, $dateEnd, $offset, $limit);
            $response = $this->response($tasks);
            if (is_null($tasks) === false && count($tasks) === 0) {
                $response = $this->response($tasks, self::OK_MESSAGE, Response::HTTP_NO_CONTENT);
            }
            return $response;
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
        try {
            $task = $this->service->find($id);
            return $this->response($task);
        } catch (TaskServiceException | InvalidArgumentException $e) {
            return $this->response([], $e->getMessage(), $e->getCode());
        } catch (Throwable $e) {
            return $this->response([], 'Произошла ошибка, обратитесь в поддержку', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Создать задачу
     *
     * @Route("/tasks", name="create_task", methods={"PUT"})
     * @param Request $request
     * @return JsonResponse
     */
    public function createTaskAction(Request $request): JsonResponse
    {
        try {
            $params = [
                'user_id' => $request->get('user_id'),
                'start_date' => $request->get('start_date', date('Y-m-d H:i:s')),
                'end_date' => $request->get('end_date', date('Y-m-d H:i:s')),
                'name' => $request->get('name'),
                'description' => $request->get('description'),
            ];
            $task = $this->service->create($params);
            return $this->response($task, self::OK_MESSAGE, Response::HTTP_CREATED);
        } catch (InvalidArgumentException$e) {
            return $this->response([], $e->getMessage(), $e->getCode());
        } catch (Throwable $e) {
            return $this->response([], $this::SERVER_ERROR_MESSAGE, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}