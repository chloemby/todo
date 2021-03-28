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
class TaskRepository extends AbstractRepository
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
     * @return Task[]
     */
    public function findByFilter(
        int $userId,
        DateTime $dateStart = null,
        DateTime $dateEnd = null,
        int $offset = null,
        int $limit = null): ?array
    {
        $queryBuilder = $this->createQueryBuilder('t');
        $queryBuilder->where('t.user_id = :user_id');
        if ($dateStart) {
            $queryBuilder->andWhere('t.created_at >= :date_start');
        }
        if ($dateEnd) {
            $queryBuilder->andWhere('t.created_at <= :date_end');
        }
        $params = [
            'user_id' => $userId
        ];
        if ($dateStart) {
            $params['date_start'] = $dateStart;
            $params['date_end'] = $dateEnd;
        }
        if (!is_null($offset)) {
            $queryBuilder->setFirstResult($offset);
        }
        if ($limit) {
            $queryBuilder->setMaxResults($limit);
        }
        return $queryBuilder->setParameters($params)->getQuery()->getResult();
    }

    /**
     * Создать задачу в БД
     *
     * @param Task $task
     * @return Task
     */
    public function createTask(Task $task)
    {
        $this->createEntity($task);
        return $task;
    }
}