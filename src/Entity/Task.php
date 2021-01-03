<?php


namespace App\Entity;


use DateTime;
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
class Task implements JsonSerializable
{

    /**
     * ID сущности задачи
     *
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     * Дата создания задачи
     *
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private $created_at;


    /**
     * Получить ID задачи
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * Получить дату создания задачи
     *
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
    }

    public function beforeSave()
    {
        $this->created_at = new DateTime();
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
}