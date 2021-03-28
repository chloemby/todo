<?php

declare(strict_types=1);


namespace App\Entity;


use App\Entity\Task;
use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\PersistentCollection;


/**
 * Class User
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseEntity implements EntityInterface, JsonSerializable
{
    /**
     * Номер телефона пользователя
     *
     * @ORM\Column(type="text")
     */
    private string $phone = '';

    /**
     * Имя пользователя
     *
     * @ORM\Column(type="text")
     */
    private string $name = '';

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="user")
     */
    private PersistentCollection $tasks;

    public function __construct(string $phone, string $name)
    {
        $this->name = $name;
        $this->phone = $phone;

        parent::__construct();
    }

    /**
     * Получить номер телефона пользователя
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * Получить имя пользователя
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Task[]
     */
    public function getTasks(): PersistentCollection
    {
        return $this->tasks;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'phone' => $this->getPhone(),
            'created_at' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $this->getUpdatedAt() ? $this->getUpdatedAt()->format('Y-m-d H:i:s') : null,
            'deleted_at' => $this->getDeletedAt() ? $this->getDeletedAt()->format('Y-m-d H:i:s') : null
        ];
    }
}