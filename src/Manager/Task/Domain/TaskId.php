<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Domain;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Stringable;

final class TaskId implements Stringable
{
    //This ID is a UUID. I realized later that this doesn't make a lot of sense and that it would be more user firendly
    //to just use any numerical ID
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
