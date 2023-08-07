<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Domain;

use DateTime;
use Exception;
use Stringable;

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

    public function id(): TaskId
    {
        return $this->id;
    }

    public function taskTitle(): TaskTitle
    {
        return $this->taskTitle;
    }

    public function taskDescription(): TaskDescription
    {
        return $this->taskDescription;
    }

    public function taskDueDate(): TaskDueDate
    {
        return $this->taskDueDate;
    }

    public function taskStatus(): TaskStatus
    {
        return $this->taskStatus;
    }


    /**
     * @param array{id: string, title: string, description: string, due_date:string, status: string} $data
     * @throws Exception
     */
    public static function fromArray(array $data): self
    {
        return new self(
            new TaskId($data['id']),
            new TaskTitle($data['title']),
            new TaskDescription($data['description']),
            new TaskDueDate(new DateTime($data['due_date'])),
            new TaskStatus($data['status']),
        );
    }


    /**
     * @return  array<array-key, Stringable|null|scalar>
     */
    public function toArray(): array
    {
        return array (
            'id' => $this->id()->value(),
            'title' => $this->taskTitle()->value(),
            'description' => $this->taskDescription()->value(),
            'due_date' => $this->taskDueDate(),
            'status' => $this->taskStatus()->value(),
        );
    }
}
