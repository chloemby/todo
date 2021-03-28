<?php


namespace App\Builder;


use App\Entity\Task;
use App\Entity\EntityInterface;

/**
 * Class TaskBuilder
 * @package App\Builder
 */
class TaskBuilder implements BuilderInterface
{
    public function build(array $params): EntityInterface
    {
        return new Task($params['description'], $params['name'], $params['user_id']);
    }
}