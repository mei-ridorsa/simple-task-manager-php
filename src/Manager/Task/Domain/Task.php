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

    public function getId(): TaskId
    {
        return $this->id;
    }

    public function getTaskTitle(): TaskTitle
    {
        return $this->taskTitle;
    }

    public function getTaskDescription(): TaskDescription
    {
        return $this->taskDescription;
    }

    public function getTaskDueDate(): TaskDueDate
    {
        return $this->taskDueDate;
    }

    public function getTaskStatus(): TaskStatus
    {
        return $this->taskStatus;
    }

    public function setTaskTitle(TaskTitle $taskTitle): void
    {

        $this->taskTitle = $taskTitle;
    }

    public function setTaskDescription(TaskDescription $taskDescription): void
    {

        $this->taskDescription = $taskDescription;
    }

    public function setTaskDueDate(TaskDueDate $taskDueDate): void
    {

        $this->taskDueDate = $taskDueDate;
    }

    public function setTaskStatus(TaskStatus $taskStatus): void
    {

        $this->taskStatus = $taskStatus;
    }


    /**
     * @param list<string> $data
     * @throws Exception
     */
    public static function fromArray(array $data): self
    {
        return new self(
            new TaskId($data['0']),
            new TaskTitle($data['1']),
            new TaskDescription($data['2']),
            new TaskDueDate(new DateTime($data['3'])),
            new TaskStatus($data['4']),
        );
    }


    /**
     * @return  array<array-key, Stringable|null|scalar>
     */
    public function toArray(): array
    {
        return array (
            'id' => $this->getId()->value(),
            'title' => $this->getTaskTitle()->value(),
            'description' => $this->getTaskDescription()->value(),
            'due_date' => $this->getTaskDueDate(),
            'status' => $this->getTaskStatus()->value(),
        );
    }
}
