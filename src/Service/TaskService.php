<?php


namespace App\Service;


use DateTime;
use App\Entity\Task;
use App\Builder\TaskBuilder;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use App\Service\Validators\TaskValidator;
use App\Service\Exceptions\TaskServiceException;
use http\Env\Response;


/**
 * Сервис с бизнес-логикой связанной с задачами
 *
 * Class TaskService
 * @package App\Services
 */
class TaskService extends AbstractService
{

    public function __construct(TaskBuilder $builder,
                                TaskRepository $repository,
                                TaskValidator $validator)
    {
        $this->builder = $builder;
        $this->repository = $repository;
        $this->validator = $validator;

        parent::__construct($builder, $repository, $validator);
    }

    /**
     * Получение задач пользователя за период
     *
     * @param int $userId
     * @param DateTime $dateStart
     * @param DateTime $dateEnd
     * @param int $offset
     * @param int $limit
     * @return mixed
     */
    public function findByFilter(array $params)
    {
        $this->validator->validateCreation($params);
        return $this->repository->findByFilter($userId, $dateStart, $dateEnd, $offset, $limit);
    }

    /**
     * Создать задачу
     * @param array $params
     * @return Task Созданная задача
     */
    public function create(array $params): Task
    {
        $this->validator->validateCreation($params);
        $task = $this->createEntity($params);
        return $this->repository->create($task);
    }
}