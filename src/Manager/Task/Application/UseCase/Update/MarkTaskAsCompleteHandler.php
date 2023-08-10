<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Application\UseCase\Update;

use TaskManager\Manager\Task\Domain\Exception\TaskNotFoundException;
use TaskManager\Manager\Task\Domain\TaskId;
use TaskManager\Manager\Task\Domain\TaskStatus;
use TaskManager\Manager\Task\Infrastructure\Persistence\TaskCsvRepository;

final class MarkTaskAsCompleteHandler
{
    private TaskCsvRepository $repository;

    public function __construct(TaskCsvRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws TaskNotFoundException
     */
    public function handle(string $id): void
    {
        $task = $this->repository->getById(new TaskId($id));

        if (!$task) {
            throw TaskNotFoundException::fromId($id);
        }

        $task->setTaskStatus(new TaskStatus('Completed'));

        $this->repository->save($task);
    }
}
