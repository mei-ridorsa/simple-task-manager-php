<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Domain;

final class TaskTitle
{
    public function __construct(protected string $value)
    {
    }

    public function value(): string
    {
        return $this->value;
    }
}
