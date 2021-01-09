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
     * @ORM\Column(type="datetime", name="created_at", nullable=TRUE)
     */
    protected $created_at;

    /**
     * @var DateTime|null
     * @ORM\Column(type="datetime", name="deleted_at", nullable=TRUE)
     */
    protected $deleted_at;

    /**
     * @var DateTime|null
     * @ORM\Column(type="datetime", name="updated_at", nullable=TRUE)
     */
    protected $updated_at;

    public function __construct()
    {
        $this->created_at = new DateTime();
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
        return $this->created_at;
    }

    /**
     * Получить время последнего обновления сущности
     *
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updated_at;
    }

    /**
     * Получить время удаления сущности
     *
     * @return DateTime|null
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