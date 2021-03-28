<?php


namespace App\Repository;


use DateTimeInterface;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;


class UserRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Создать пользователя в БД
     *
     * @param User $user Сущность создаваемого пользователя
     * @return User
     */
    public function createUser(User $user): User
    {
        $this->createEntity($user);
        return $user;
    }
}