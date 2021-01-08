<?php


namespace App\Services;


use Exception;
use App\Builder\BuilderInterface;
use App\Entity\EntityInterface;
use App\Services\Validators\AbstractValidator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;


/**
 * Класс абстрактного сервиса с бизнес-логикой
 *
 * Class AbstractService
 * @package App\Services
 */
abstract class AbstractService
{
    /**
     * @var ServiceEntityRepository
     */
    protected $repository;

    /**
     * @var BuilderInterface
     */
    protected $builder;

    /**
     * @var AbstractValidator
     */
    protected $validator;

    /**
     * @param BuilderInterface $builder
     * @param ServiceEntityRepository $repository
     * @param AbstractValidator $validator
     */
    public function __construct(BuilderInterface $builder,
                                ServiceEntityRepository $repository,
                                AbstractValidator $validator)
    {
        $this->repository = $repository;
        $this->builder = $builder;
        $this->validator = $validator;
    }

    /**
     * Найти все сущности
     *
     * @return array
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * Найти сущность по ID
     *
     * @param int $id ID сущности
     * @return object|null
     */
    public function find(int $id)
    {
        try {
            $entity = $this->repository->find($id);
        } catch (Exception $e) {
            $entity = null;
        } finally {
            return $entity;
        }
    }

    /**
     * Создать сущность на основе параметров
     *
     * @param array $params Параметры для создания сущности
     * @return EntityInterface
     */
    public function createEntity(array $params): EntityInterface
    {
        return $this->builder->build($params);
    }

}