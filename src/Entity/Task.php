<?php

declare(strict_types=1);


namespace App\Entity;


use DateTime;
use App\Entity\User;
use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;


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
     * @ORM\Column(type="text")
     */
    private string $description;

    /**
     * Название задачи
     *
     * @ORM\Column(type="string", length=250)
     */
    private string $name;

    /**
     * @ORM\Column(type="integer")
     */
    private int $user_id;

    /**
     * @ORM\Column(type="datetime", name="expire_at", nullable=TRUE)
     */
    private ?DateTime $expire_at;

    /**
     * @var \App\Entity\User
     * @ManyToOne(targetEntity="User", inversedBy="tasks")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private User $user;

    /**
     * Task constructor.
     * @param string $description
     * @param string $name
     * @param int $userId
     */
    public function __construct(string $description, string $name, int $userId)
    {
        $this->name = $name;
        $this->user_id = $userId;
        $this->description = $description;

        parent::__construct();
    }

    /**
     * Получить описание задачи
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

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function getExpireAt(): ?DateTime
    {
        return $this->expire_at;
    }

    public function setExpireAt(?DateTime $expireAt): self
    {
        $this->expire_at = $expireAt;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
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
}