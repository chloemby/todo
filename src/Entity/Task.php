<?php

declare(strict_types=1);


namespace App\Entity;


use App\Entity\User;
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
class Task extends BaseEntity implements EntityInterface, JsonSerializable
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
     * @var int
     * @ORM\Column(type="integer")
     */
    private $user_id;

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

        parent::__construct();
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
            'created_at' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $this->getUpdatedAt() ? $this->getUpdatedAt()->format('Y-m-d H:i:s') : null,
            'deleted_at' => $this->getDeletedAt() ? $this->getDeletedAt()->format('Y-m-d H:i:s') : null,
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'user_id' => $this->getUserId()
        ];
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }
}