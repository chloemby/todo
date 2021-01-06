<?php


namespace App\Builder;


use App\Entity\BaseEntity;
use App\Entity\EntityInterface;

/**
 * Interface BuilderInterface
 * @package App\Builder
 */
interface BuilderInterface
{
    public function build(array $params): EntityInterface;
}