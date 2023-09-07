<?php

namespace Core\Abstractions;

use EventSauce\EventSourcing\AggregateAppliesKnownEvents;
use EventSauce\EventSourcing\EventSourcedAggregate;

abstract class Aggregate implements EventSourcedAggregate
{
    use AggregateAppliesKnownEvents;
}
