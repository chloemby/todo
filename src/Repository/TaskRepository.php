<?php


namespace App\Repository;


use DateTime;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * Class TaskRepository
 * @package App\Repository
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * Получить задачи по фильтрам
     *
     * @param int $userId
     * @param DateTime|null $dateStart
     * @param DateTime|null $dateEnd
     * @param int|null $limit
     * @param int|null $offset
     * @return mixed
     */
    public function findByFilter(
        int $userId,
        DateTime $dateStart = null,
        DateTime $dateEnd = null,
        int $limit = null,
        int $offset = null)
    {
        $queryBuilder = $this->createQueryBuilder('t');
        if ($dateStart) {
            $queryBuilder->where('t.created_at >= :date_start')
                ->setParameter('date_start', $dateStart->format('Y-m-d H:i:s'));
        }
        if ($dateEnd) {
            $queryBuilder->where('t.created_at <= :date_end')
                ->setParameter('date_end', $dateEnd->format('Y-m-d H:i:s'));
        }
        if ($userId) {
            $queryBuilder->where('t.user_id = :user_id')
                ->setParameter('user_id', $userId);
        }
        if ($offset) {
            $queryBuilder->setFirstResult($offset);
        }
        if ($limit) {
            $queryBuilder->setMaxResults($limit);
        }
        return $queryBuilder->getQuery()->getResult();
    }
}