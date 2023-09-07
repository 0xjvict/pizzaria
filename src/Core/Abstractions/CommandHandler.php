<?php

namespace Core\Abstractions;

use EventSauce\EventSourcing\AggregateRootRepository;

abstract class CommandHandler
{
    abstract public function handle(Command $command): void;
}
