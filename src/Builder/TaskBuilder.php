<?php


namespace App\Builder;


use App\Entity\BaseEntity;
use App\Entity\EntityInterface;

/**
 * Class TaskBuilder
 * @package App\Builder
 */
class TaskBuilder implements BuilderInterface
{
    public function build(array $params): EntityInterface
    {
        return new Task($params['id'], $params['description'], $params['name']);
    }
}