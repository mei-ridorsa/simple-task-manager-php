<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Domain;

final class TaskDescription
{
    public function __construct(protected string $value)
    {
    }

    public function value(): string
    {
        return $this->value;
    }
}
