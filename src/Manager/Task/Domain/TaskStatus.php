<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Domain;

use TaskManager\Manager\Task\Domain\Exception\InvalidTaskStatusValue;

final class TaskStatus implements \Stringable
{
    /**
     * @var list<string>
     */
    protected array $acceptedValues = ['Completed', 'Pending'];

    /**
     * @throws InvalidTaskStatusValue
     */
    public function __construct(protected string $value)
    {
        $this->ensureIsBetweenAcceptedValues($value);
    }

    /**
     * @return list<string>
     */
    public function acceptedValues(): array
    {
        return $this->acceptedValues;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }

    /**
     * @throws InvalidTaskStatusValue
     */
    private function ensureIsBetweenAcceptedValues(string $value): void
    {
        if (!in_array($value, $this->acceptedValues(), true)) {
            throw InvalidTaskStatusValue::fromValue($value);
        }
    }
}
