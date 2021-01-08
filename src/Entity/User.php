<?php

declare(strict_types=1);


namespace App\Entity;


use App\Entity\Task;
use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


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
     * @var string
     * @ORM\Column(type="text")
     */
    private $phone = '';

    /**
     * Имя пользователя
     *
     * @var string
     * @ORM\Column(type="text")
     */
    private $name = '';

    /**
     * @var array
     * @ORM\OneToMany(targetEntity="Task", mappedBy="users")
     */
    private $tasks;

    public function __construct(string $phone, string $name)
    {
//        $this->tasks = new ArrayCollection();
        $this->name = $name;
        $this->phone = $phone;
    }

    /**
     * Получить номер телефона пользователя
     *
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Получить имя пользователя
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function jsonSerialize()
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