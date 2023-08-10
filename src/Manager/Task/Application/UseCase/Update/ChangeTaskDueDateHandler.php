<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Application\UseCase\Update;

use TaskManager\Manager\Task\Domain\Exception\InvalidTaskDueDateValue;
use TaskManager\Manager\Task\Domain\Exception\TaskNotFoundException;
use TaskManager\Manager\Task\Domain\TaskId;
use TaskManager\Manager\Task\Domain\TaskDueDate;
use TaskManager\Manager\Task\Infrastructure\Persistence\TaskCsvRepository;

final class ChangeTaskDueDateHandler
{
    private TaskCsvRepository $repository;

    public function __construct(TaskCsvRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * @throws TaskNotFoundException
     * @throws InvalidTaskDueDateValue
     */
    public function handle(
        string $id,
        string $dueDate,
    ): void {
        $task = $this->repository->getById(new TaskId($id));

        if (!$task) {
            throw TaskNotFoundException::fromId($id);
        }

        $task->setTaskDueDate(TaskDueDate::createFromString($dueDate));

        $this->repository->save($task);
    }
}
