<?php


namespace App\Repository;


use DateTimeInterface;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getUserTasks(User $user, DateTimeInterface $date_start, DateTimeInterface $date_end): array
    {

    }
}