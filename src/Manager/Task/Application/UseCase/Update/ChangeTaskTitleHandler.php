<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Application\UseCase\Update;

use TaskManager\Manager\Task\Domain\Exception\TaskNotFoundException;
use TaskManager\Manager\Task\Domain\TaskId;
use TaskManager\Manager\Task\Domain\TaskTitle;
use TaskManager\Manager\Task\Infrastructure\Persistence\TaskCsvRepository;

final class ChangeTaskTitleHandler
{
    private TaskCsvRepository $repository;

    public function __construct(TaskCsvRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * @throws TaskNotFoundException
     */
    public function handle(
        string $id,
        string $title,
    ): void {
        $task = $this->repository->getById(new TaskId($id));

        if (!$task) {
            throw TaskNotFoundException::fromId($id);
        }

        $task->setTaskTitle(new TaskTitle($title));

        $this->repository->save($task);
    }
}
