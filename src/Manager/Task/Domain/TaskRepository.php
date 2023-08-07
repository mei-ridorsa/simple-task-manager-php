<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Domain;

use Generator;

interface TaskRepository
{
    public function getAll(): Generator;

    public function getById(TaskId $id): ?Task;

    public function add(Task $aggregateRoot): void;

    public function remove(Task $aggregateRoot): void;
}
