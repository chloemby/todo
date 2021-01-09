<?php


namespace App\Entity;


use DateTime;
use Exception;
use Doctrine\ORM\Mapping as ORM;


class BaseEntity
{
    /**
     * ID сущности задачи
     *
     * @var int|null
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Дата создания сущности
     *
     * @var DateTime
     * @ORM\Column(type="datetime", name="created_at")
     */
    protected $createdAt;

    /**
     * @var DateTime|null
     * @ORM\Column(type="datetime", name="deleted_at", nullable=TRUE)
     */
    protected $deletedAt;

    /**
     * @var DateTime|null
     * @ORM\Column(type="datetime", name="updated_at", nullable=TRUE)
     */
    protected $updatedAt;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    /**
     * Получить ID сущности
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Получить дату создания сущности
     *
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * Получить время последнего обновления сущности
     *
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Получить время удаления сущности
     *
     * @return DateTime|null
     */
    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }

    /**
     * @throws Exception
     * @ORM\PrePersist()
     */
    public function beforeSave()
    {
        $this->createdAt = new DateTime();
    }
}