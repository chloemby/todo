<?php


namespace App\Services;

use DateTime;


class TaskService extends AbstractService
{
    public function findByUserId(
        int $userId,
        DateTime $dateStart,
        DateTime $dateEnd,
        int $offset,
        int $limit)
    {

    }
}