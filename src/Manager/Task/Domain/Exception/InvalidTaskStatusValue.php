<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Domain\Exception;

use Exception;

final class InvalidTaskStatusValue extends Exception
{
    public static function fromValue(string $status): self
    {
        return new self('The task status ' . $status . ' is not valid');
    }
}
