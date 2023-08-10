<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Application\UseCase\Create;

use TaskManager\Manager\Task\Domain\Exception\InvalidTaskDueDateValue;
use TaskManager\Manager\Task\Domain\Task;
use TaskManager\Manager\Task\Domain\TaskDescription;
use TaskManager\Manager\Task\Domain\TaskDueDate;
use TaskManager\Manager\Task\Domain\TaskId;
use TaskManager\Manager\Task\Domain\TaskStatus;
use TaskManager\Manager\Task\Domain\TaskTitle;
use TaskManager\Manager\Task\Infrastructure\Persistence\TaskCsvRepository;

final class CreateTaskHandler
{
    private TaskCsvRepository $repository;

    public function __construct(TaskCsvRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws InvalidTaskDueDateValue
     */
    public function handle(
        string $title,
        string $description,
        string $dueDate,
    ): void {
        $task = new Task(
            TaskId::generate(),
            new TaskTitle($title),
            new TaskDescription($description),
            TaskDueDate::createFromString($dueDate),
            new TaskStatus('Pending'),
        );

        $this->repository->add($task);
    }
}
