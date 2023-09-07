<?php

namespace Core\Abstractions;

use Ramsey\Uuid\Uuid;

abstract class AggregateRootId implements \EventSauce\EventSourcing\AggregateRootId
{
    private function __construct(private readonly string $value)
    {
    }

    public static function generate(): static
    {
        return new static(Uuid::uuid4()->toString());
    }

    public static function fromString(string $aggregateRootId): static
    {
        return new static($aggregateRootId);
    }

    public function toString(): string
    {
        return $this->value;
    }
}
