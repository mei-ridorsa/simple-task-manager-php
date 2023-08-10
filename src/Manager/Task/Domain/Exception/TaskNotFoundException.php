<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Domain\Exception;

use Exception;

final class TaskNotFoundException extends Exception
{
    public static function fromId(string $id): self
    {
        return new self('The task ' . $id . ' is not found');
    }
}
