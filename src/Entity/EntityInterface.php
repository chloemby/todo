<?php


namespace App\Entity;


use DateTime;

interface EntityInterface
{
    public function getId(): ?int;

    public function getCreatedAt(): DateTime;

    public function getUpdatedAt(): ?DateTime;

    public function getDeletedAt(): ?DateTime;
}