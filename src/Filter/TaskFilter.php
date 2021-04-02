<?php


namespace App\Filter;

use DateTime;


class TaskFilter
{
    private ?int $userId;

    private ?DateTime $dateStart;

    private ?DateTime $dateEnd;

    private ?int $offset;

    private ?int $limit;
}