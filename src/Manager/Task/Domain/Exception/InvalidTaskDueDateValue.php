<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Domain\Exception;

use Exception;

class InvalidTaskDueDateValue extends Exception
{
    public static function fromValue(string $dueDate): self
    {
        return new self('The task due date ' . $dueDate . ' is not valid');
    }
}
