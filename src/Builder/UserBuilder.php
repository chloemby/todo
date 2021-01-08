<?php


namespace App\Builder;


use App\Entity\EntityInterface;
use App\Entity\User;


/**
 * Class UserBuilder
 * @package App\Builder
 */
class UserBuilder implements BuilderInterface
{
    /**
     * @param array $params
     * @return EntityInterface
     */
    public function build(array $params): EntityInterface
    {
        return new User($params['phone'], $params['name']);
    }
}