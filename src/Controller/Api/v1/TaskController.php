<?php

declare(strict_types=1);


namespace App\Controller\Api\v1;

use DateTime;
use Exception;
use InvalidArgumentException;
use App\Builder\TaskBuilder;
use App\Services\TaskService;
use App\Repository\UserRepository;
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

        parent::__construct($service, $builder);
    }

    /**
     *
     * @Route("/task", name="tasks", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function getTasksAction(Request $request): JsonResponse
    {
        try {
            $userId = $request->get('user_id', null);
            $dateStart = $request->get('date_start', new DateTime(date('Y-m-01 00:00:00', time())));
            $dateEnd = $request->get('date_end', (new DateTime())->format('Y-m-d H:i:s'));
            $offset = $request->get('offset', 0);
            $limit = $request->get('limit', 100);
            $tasks = $this->service->findByUserId($userId, $dateStart, $dateEnd, $offset, $limit);
            #TODO сделать возвращение разных ответов в зависимости от операции(коды, сообщения и тд)
            return $this->response($tasks);
        } catch (InvalidArgumentException $e) {
            return $this->response([], $e->getMessage(), $e->getCode());
        } catch (Exception $e) {
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
}