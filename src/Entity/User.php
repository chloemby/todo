<?php

declare(strict_types=1);


namespace App\Entity;


use App\Entity\Task;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class User
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends Entity
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

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    /**
     * Получить номер телефона пользователя
     *
     * @return mixed
     */
    public function getPhone()
    {
        return $this->getPhone();
    }

    /**
     * Установить телефон пользователя
     *
     * @param string $phone
     * @return User
     */
    public function setPhone(string $phone): User
    {
        $this->phone = $phone;
        return $this;
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
     * Установить имя пользователя
     *
     * @param string $name
     * @return User
     */
    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setUsers($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getUsers() === $this) {
                $task->setUsers(null);
            }
        }

        return $this;
    }
}