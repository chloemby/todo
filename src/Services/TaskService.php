<?php


namespace App\Services;

use DateTime;


/**
 * Сервис с бизнес-логикой связанной с задачами
 *
 * Class TaskService
 * @package App\Services
 */
class TaskService extends AbstractService
{
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
}