<?php


namespace App\TestsController\Api\v1;


use Mockery;
use Exception;
use App\Entity\Task;
use App\Builder\TaskBuilder;
use App\Service\TaskService;
use App\Controller\Api\v1\TaskController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


/**
 * Class TaskControllerTest
 * @package App\Tests\Api\v1
 */
class TaskControllerTest extends WebTestCase
{
    public function testFailCreateTaskBadRequest()
    {
        $taskBuilder = Mockery::mock(TaskBuilder::class);
        $taskService = Mockery::mock(TaskService::class);
        $taskService->shouldReceive('create')->andThrow(new BadRequestHttpException('', null, Response::HTTP_BAD_REQUEST));
        $request = new Request();

        $response = (new TaskController($taskService, $taskBuilder))->createTaskAction($request);

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testFailCreateUnknownError()
    {
        $taskBuilder = Mockery::mock(TaskBuilder::class);
        $taskService = Mockery::mock(TaskService::class);
        $taskService->shouldReceive('create')->andThrow(new Exception());
        $request = new Request();

        $response = (new TaskController($taskService, $taskBuilder))->createTaskAction($request);

        $this->assertEquals(500, $response->getStatusCode());
    }

    public function testSuccessCreateTask()
    {
        $taskBuilder = Mockery::mock(TaskBuilder::class);
        $taskService = Mockery::mock(TaskService::class);
        $task = new Task('', '', 1);
        $taskService->shouldReceive('create')->andReturn($task);
        $request = new Request();

        $response = (new TaskController($taskService, $taskBuilder))->createTaskAction($request);

        $this->assertEquals(201, $response->getStatusCode());
    }
}