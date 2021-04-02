<?php


namespace App\Service\Validators;


use App\Service\Helpers\DateHelper;
use App\Service\TaskService;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class TaskValidator extends AbstractValidator
{
    private UserService $user;

    public function __construct(UserService $userService)
    {
        $this->user = $userService;
    }

    public function validateCreation(array $params): array
    {
        if (!$userId = $params['user_id']) {
            throw new BadRequestHttpException('Bad request. Required user_id.',
                null, Response::HTTP_BAD_REQUEST);
        }
        if ($this->entityExist($this->user, $params['user_id']) == false) {
            throw new BadRequestHttpException("Bad request. User with ID {$params['user_id']} does not exist",
                null, Response::HTTP_BAD_REQUEST);
        }
        if (!$startDate = $params['start_date']) {
            throw new BadRequestHttpException('Bad request. Required start_date.',
                null, Response::HTTP_BAD_REQUEST);
        }
        if (DateHelper::isDateStringValidFormat($startDate) == false) {
            throw new BadRequestHttpException('Bad request. Invalid start_date format.',
                null, Response::HTTP_BAD_REQUEST);
        }
    }
}