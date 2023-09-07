<?php

namespace Core\Abstractions;

use EventSauce\EventSourcing\AggregateRootBehaviour;

abstract class AggregateRoot implements \EventSauce\EventSourcing\AggregateRoot
{
    use AggregateRootBehaviour;
}
