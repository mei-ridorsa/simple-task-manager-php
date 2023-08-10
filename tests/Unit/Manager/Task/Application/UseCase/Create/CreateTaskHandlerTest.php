<?php

declare(strict_types=1);

namespace TaskManager\Tests\Unit\Manager\Task\Application\UseCase\Create;

use PHPUnit\Framework\TestCase;
use TaskManager\Manager\Task\Application\UseCase\Create\CreateTaskHandler;
use TaskManager\Manager\Task\Domain\Exception\InvalidTaskDueDateValue;
use TaskManager\Manager\Task\Infrastructure\Persistence\TaskCsvRepository;

final class CreateTaskHandlerTest extends TestCase
{
    private CreateTaskHandler $handler;
    private TaskCsvRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        //This would be more correctly done with a mocked repository
        $this->repository = new TaskCsvRepository();

        $this->handler = new CreateTaskHandler($this->repository);
    }


    public function testTaskCreationIsSuccessful(): void
    {

        $countBefore = count(iterator_to_array($this->repository->getAll(), false));

        $this->handler->handle('title', 'description', '21-02-2024');

        $countAfter = count(iterator_to_array($this->repository->getAll(), false));

        $this->assertGreaterThan($countBefore, $countAfter);
    }

    public function testTaskCreationFailsIfDateFormatIsInvalid(): void
    {
        $this->expectException(InvalidTaskDueDateValue::class);

        $this->handler->handle('title', 'description', '21.02.24');
    }
}
