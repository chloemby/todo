<?php


namespace App\TestsController\Api\v1;


use App\Builder\TaskBuilder;
use App\Entity\Task;
use App\Services\TaskService;
use Mockery;
use App\Controller\Api\v1\TaskController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class TaskControllerTest
 * @package App\Tests\Api\v1
 */
class TaskControllerTest extends WebTestCase
{
    public function testFailCreateTaskWithoutParams()
    {
        $taskService = Mockery::mock('App\Services\TaskService');
        $taskBuilder = Mockery::mock('App\Builder\TaskBuilder');
        $request = new Request();
        $response = (new TaskController($taskService, $taskBuilder))->createTaskAction($request);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testFailCreateTaskWithoutUserId()
    {
        $params = [
            'start_date' => date('Y-m-d H:i:s'),
            'end_date' => date('Y-m-d H:i:s'),
            'name' => 'Test name'
        ];
        $taskService = Mockery::mock('App\Services\TaskService');
        $taskBuilder = Mockery::mock('App\Builder\TaskBuilder');
        $request = new Request();
        $request->request->add($params);
        $response = (new TaskController($taskService, $taskBuilder))->createTaskAction($request);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testFailCreateTaskWithoutName()
    {
        $params = [
            'user_id' => 1,
            'start_date' => date('Y-m-d H:i:s'),
            'end_date' => date('Y-m-d H:i:s')
        ];
        $taskService = Mockery::mock('App\Services\TaskService');
        $taskBuilder = Mockery::mock('App\Builder\TaskBuilder');
        $request = new Request();
        $request->request->add($params);
        $response = (new TaskController($taskService, $taskBuilder))->createTaskAction($request);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testFailCreateTaskWithEmptyDateStart()
    {
        $params = [
            'user_id' => 1,
            'start_date' => null,
            'end_date' => date('Y-m-d H:i:s'),
            'name' => 'Test name'
        ];
        $taskService = Mockery::mock('App\Services\TaskService');
        $taskBuilder = Mockery::mock('App\Builder\TaskBuilder');
        $request = new Request();
        $request->request->add($params);
        $response = (new TaskController($taskService, $taskBuilder))->createTaskAction($request);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testFailCreateTaskWithoutDateEnd()
    {
        $params = [
            'user_id' => 1,
            'end_date' => null,
            'start_date' => date('Y-m-d H:i:s'),
            'name' => 'Test name'
        ];
        $taskService = Mockery::mock('App\Services\TaskService');
        $taskBuilder = Mockery::mock('App\Builder\TaskBuilder');
        $request = new Request();
        $request->request->add($params);
        $response = (new TaskController($taskService, $taskBuilder))->createTaskAction($request);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testFailCreateTaskWithInvalidDates()
    {
        $params = [
            'user_id' => 1,
            'end_date' => date('Y-m-d H:i:s'),
            'start_date' => date('d.m.Y H:i:s'),
            'name' => 'Test name'
        ];
        $taskService = Mockery::mock('App\Services\TaskService');
        $taskBuilder = Mockery::mock('App\Builder\TaskBuilder');
        $request = new Request();
        $request->request->add($params);
        $response = (new TaskController($taskService, $taskBuilder))->createTaskAction($request);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testSuccessCreateTask()
    {
        $params = [
            'user_id' => 1,
            'end_date' => date('Y-m-d H:i:s'),
            'start_date' => date('Y-m-d H:i:s'),
            'name' => 'Test name',
            'description' => 'Test description'
        ];
        $taskService = Mockery::mock('App\Services\TaskService');
        $task = new Task('', '');
        $taskService->shouldReceive('createTask')->andReturn($task);
        $taskBuilder = Mockery::mock('App\Builder\TaskBuilder');
        $request = new Request();
        $request->request->add($params);
        $response = (new TaskController($taskService, $taskBuilder))->createTaskAction($request);
        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testFailGetTasksWithoutParams()
    {
        $taskService = Mockery::mock(TaskService::class);
        $taskBuilder = Mockery::mock(TaskBuilder::class);
        $request = new Request();
        $response = (new TaskController($taskService, $taskBuilder))->getTasksAction($request);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testFailGetTasksWitEmptyDates()
    {
        $taskService = Mockery::mock(TaskService::class);
        $taskBuilder = Mockery::mock(TaskBuilder::class);
        $request = new Request();
        $params = [
            'user_id' => 1,
            'date_start' => null,
            'date_end' => null
        ];
        $request->request->add($params);
        $response = (new TaskController($taskService, $taskBuilder))->getTasksAction($request);
        $this->assertEquals(400, $response->getStatusCode());

        $params = [
            'user_id' => 1,
            'date_start' => null,
            'date_end' => date('Y-m-d H:i:s')
        ];
        $request->request->add($params);
        $response = (new TaskController($taskService, $taskBuilder))->getTasksAction($request);
        $this->assertEquals(400, $response->getStatusCode());

        $params = [
            'user_id' => 1,
            'date_start' => date('Y-m-d H:i:s'),
            'date_end' => null
        ];
        $request->request->add($params);
        $response = (new TaskController($taskService, $taskBuilder))->getTasksAction($request);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testFailGetTasksWithInvalidDatesFormat()
    {
        $taskService = Mockery::mock(TaskService::class);
        $taskBuilder = Mockery::mock(TaskBuilder::class);
        $request = new Request();
        $params = [
            'user_id' => 1,
            'date_start' => date('d.m.Y H:i:s'),
            'date_end' => date('Y-m-d H:i:s')
        ];
        $request->request->add($params);
        $response = (new TaskController($taskService, $taskBuilder))->getTasksAction($request);
        $this->assertEquals(400, $response->getStatusCode());

        $request = new Request();
        $params = [
            'user_id' => 1,
            'date_start' => date('Y-m-d H:i:s'),
            'date_end' => date('d.m.Y H:i:s')
        ];
        $request->request->add($params);
        $response = (new TaskController($taskService, $taskBuilder))->getTasksAction($request);
        $this->assertEquals(400, $response->getStatusCode());
    }

}