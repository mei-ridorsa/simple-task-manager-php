<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Domain;

use DateTime;
use Stringable;
use TaskManager\Manager\Task\Domain\Exception\InvalidTaskDueDateValue;

final class TaskDueDate implements Stringable
{
    public function __construct(protected DateTime $value)
    {
    }

    /**
     * @throws InvalidTaskDueDateValue
     */
    public function createFromString(string $value): self
    {
        if (!$dateTime = DateTime::createFromFormat('d-m-Y', $value)) {
            throw InvalidTaskDueDateValue::fromValue($value);
        }

        return new self($dateTime);
    }

    public function __toString(): string
    {
        return $this->value->format('d-m-Y');
    }
}
