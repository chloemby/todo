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
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected ?int $id;

    /**
     * Дата создания сущности
     *
     * @ORM\Column(type="datetime", name="created_at", nullable=TRUE)
     */
    protected DateTime $created_at;

    /**
     * @ORM\Column(type="datetime", name="deleted_at", nullable=TRUE)
     */
    protected ?DateTime $deleted_at;

    /**
     * @ORM\Column(type="datetime", name="updated_at", nullable=TRUE)
     */
    protected ?DateTime $updated_at;

    public function __construct()
    {
        $this->created_at = new DateTime();
    }

    /**
     * Получить ID сущности
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Получить дату создания сущности
     */
    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    /**
     * Получить время последнего обновления сущности
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updated_at;
    }

    /**
     * Получить время удаления сущности
     */
    public function getDeletedAt(): ?DateTime
    {
        return $this->deleted_at;
    }

    /**
     * @throws Exception
     * @ORM\PrePersist()
     */
    public function beforeSave()
    {
        $this->created_at = new DateTime();
    }
}