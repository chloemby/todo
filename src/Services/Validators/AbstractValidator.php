<?php


namespace App\Services\Validators;


use App\Services\AbstractService;

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