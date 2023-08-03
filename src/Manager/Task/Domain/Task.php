<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Domain;

final class Task
{
    public function __construct(
        private TaskId $id,
        private TaskTitle $taskTitle,
        private TaskDescription $taskDescription,
        private TaskDueDate $taskDueDate,
        private TaskStatus $taskStatus,
    ) {
    }
}
