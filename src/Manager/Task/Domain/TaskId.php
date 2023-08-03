<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Domain;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Stringable;

final class TaskId implements Stringable
{
    public function __construct(protected string $value)
    {
        $this->ensureIsValidUuid($value);
    }

    public static function generate(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }

    private function ensureIsValidUuid(string $id): void
    {
        if (!Uuid::isValid($id)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', self::class, $id));
        }
    }
}
