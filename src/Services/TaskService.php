<?php


namespace App\Services;


use DateTime;
use App\Entity\Task;
use App\Builder\TaskBuilder;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use App\Services\Validators\TaskValidator;
use App\Services\Exceptions\TaskServiceException;
use http\Env\Response;


/**
 * Сервис с бизнес-логикой связанной с задачами
 *
 * Class TaskService
 * @package App\Services
 */
class TaskService extends AbstractService
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(TaskBuilder $builder,
                                TaskRepository $repository,
                                TaskValidator $validator,
                                UserRepository $userRepository)
    {
        $this->builder = $builder;
        $this->repository = $repository;
        $this->validator = $validator;
        $this->userRepository = $userRepository;

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
    public function findByUserId(
        int $userId,
        DateTime $dateStart,
        DateTime $dateEnd,
        int $offset,
        int $limit)
    {
        return $this->repository->findByFilter($userId, $dateStart, $dateEnd, $offset, $limit);
    }

    /**
     * Создать задачу
     *
     * @param int $userId ID пользователя
     * @param DateTime $startDate Дата начала действия задачи
     * @param DateTime $endDate Дата конца дествия задачи
     * @param string $name Название задачи
     * @param string $description Описание задачи
     * @return Task Созданная задача
     * @throws TaskServiceException
     * @throws \Doctrine\ORM\ORMException
     */
    public function createTask(
        int $userId,
        DateTime $startDate,
        DateTime $endDate = null,
        string $name = null,
        string $description = null): Task
    {
        if (!$user = $this->userRepository->find($userId)) {
            throw new TaskServiceException(sprintf('Пользователя с ID %s не существует', $userId), 400);
        }

        $params = [
            'user' => $user,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'name' => $name,
            'description' => $description
        ];
        $task = $this->createEntity($params);
        $this->repository->createTask($task);
        return $task;
    }
}