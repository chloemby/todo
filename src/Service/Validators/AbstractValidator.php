<?php


namespace App\Service\Validators;


use App\Service\AbstractService;

class AbstractValidator
{
    public function entityExist(AbstractService $service, int $id): bool
    {
        if ($service->find($id)) {
            return true;
        }
        return false;
    }
}