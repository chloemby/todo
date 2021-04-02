<?php


namespace App\Tests\Service;


use App\Builder\TaskBuilder;
use App\Repository\TaskRepository;
use App\Service\UserService;
use App\Service\Validators\TaskValidator;
use Mockery;
use App\Service\TaskService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class TaskServiceTest extends TestCase
{
    public function testFailCreateWithoutParams()
    {
        $builder = Mockery::mock(TaskBuilder::class);
        $repository = Mockery::mock(TaskRepository::class);
        $validator = Mockery::mock(TaskValidator::class);
        $validator->shouldReceive('validateCreation')->andThrow(new BadRequestHttpException());

        $this->expectException(BadRequestHttpException::class);

        $taskService = new TaskService($builder, $repository, $validator);
        $taskService->create([]);
    }
}