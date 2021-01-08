<?php

declare(strict_types=1);


namespace App\Entity;

use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class Task
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="tasks")
 * @ORM\HasLifecycleCallbacks()
 */
class Task extends BaseEntity implements EntityInterface
{
    /**
     * Описание задачи
     *
     * @var string
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * Название задачи
     *
     * @var string
     * @ORM\Column(type="string", length=250)
     */
    private $name;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * Task constructor.
     * @param string $description
     * @param string $name
     * @param User|null $user
     */
    public function __construct(string $description, string $name, User $user = null)
    {
        $this->name = $name;
        $this->description = $description;
        $this->user = $user;
    }

    /**
     * Получить описание задачи
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Установить описание задачи
     *
     * @param string $description Описание задачи
     * @return Task
     */
    public function setDescription(string $description): Task
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Получить название задачи
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Установить название задачи
     *
     * @param string $name Название задачи
     * @return Task
     */
    public function setName(string $name): Task
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'created_at' => $this->getCreatedAt()->format('Y-m-d H:i:s')
        ];
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}