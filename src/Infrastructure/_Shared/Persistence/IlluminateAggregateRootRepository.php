<?php

namespace Infrastructure\_Shared\Persistence;

use EventSauce\EventSourcing\EventSourcedAggregateRootRepository;
use EventSauce\EventSourcing\MessageRepository;
use EventSauce\EventSourcing\Serialization\ConstructingMessageSerializer;
use EventSauce\IdEncoding\StringIdEncoder;
use EventSauce\MessageRepository\IlluminateMessageRepository\IlluminateMessageRepository;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;

abstract class IlluminateAggregateRootRepository extends EventSourcedAggregateRootRepository
{
    public function __construct(string $aggregateRootClassName, private readonly string $tableName)
    {
        parent::__construct(
            aggregateRootClassName: $aggregateRootClassName,
            messageRepository: $this->IlluminateMessageRepository()
        );
    }

    private function IlluminateMessageRepository(): MessageRepository
    {
        return new IlluminateMessageRepository(
            connection: $this->connection(),
            tableName: $this->tableName,
            serializer: new ConstructingMessageSerializer(),
            aggregateRootIdEncoder: new StringIdEncoder(),
            eventIdEncoder: new StringIdEncoder(),
        );
    }

    private function connection(): ConnectionInterface
    {
        return DB::connection();
    }
}
