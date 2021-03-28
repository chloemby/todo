<?php


namespace App\Services;


use App\Builder\BuilderInterface;
use App\Builder\UserBuilder;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\Validators\AbstractValidator;
use App\Services\Validators\UserValidator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * Class UserService
 * @package App\Services
 */
class UserService extends AbstractService
{
    /**
     * UserService constructor.
     * @param UserBuilder $builder
     * @param UserRepository $repository
     * @param UserValidator $validator
     */
    public function __construct(UserBuilder $builder, UserRepository $repository, UserValidator $validator)
    {
        parent::__construct($builder, $repository, $validator);
    }

    /**
     * Создать пользователя
     *
     * @param string $phone Номер телефона
     * @param string $name Имя пользователя
     * @return User
     */
    public function createUser(string $phone, string $name): User
    {
        $params = [
            'name' => $name,
            'phone' => $phone
        ];
        $user = $this->createEntity($params);
        $this->repository->createUser($user);
        return $user;
    }

    public function get($id): User
    {
        return $this->repository->get($id);
    }
}