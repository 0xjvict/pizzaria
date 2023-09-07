<?php

namespace Core\Abstractions;

use EventSauce\EventSourcing\AggregateAppliesKnownEvents;
use EventSauce\EventSourcing\EventRecorder;
use EventSauce\EventSourcing\EventSourcedAggregate;

abstract class Aggregate implements EventSourcedAggregate
{
    use AggregateAppliesKnownEvents;

    public function __construct(private readonly EventRecorder $eventRecorder)
    {
    }
}
