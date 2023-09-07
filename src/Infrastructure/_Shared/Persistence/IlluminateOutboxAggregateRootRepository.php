<?php

namespace Infrastructure\_Shared\Persistence;

use EventSauce\EventSourcing\EventSourcedAggregateRootRepository;
use EventSauce\EventSourcing\MessageRepository;
use EventSauce\EventSourcing\Serialization\ConstructingMessageSerializer;
use EventSauce\IdEncoding\StringIdEncoder;
use EventSauce\MessageOutbox\IlluminateOutbox\IlluminateOutboxRepository;
use EventSauce\MessageOutbox\IlluminateOutbox\IlluminateTransactionalMessageRepository;
use EventSauce\MessageOutbox\OutboxRepository;
use EventSauce\MessageRepository\IlluminateMessageRepository\IlluminateMessageRepository;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;

abstract class IlluminateOutboxAggregateRootRepository extends EventSourcedAggregateRootRepository
{
    public function __construct(
        string                  $aggregateRootClassName,
        private readonly string $tableName,
        private readonly string $outboxTableName,
    )
    {
        parent::__construct(
            aggregateRootClassName: $aggregateRootClassName,
            messageRepository: $this->IlluminateTransactionalMessageRepository()
        );
    }

    private function IlluminateTransactionalMessageRepository(): MessageRepository
    {
        return new IlluminateTransactionalMessageRepository(
            connection: $this->connection(),
            messageRepository: $this->IlluminateMessageRepository(),
            outboxRepository: $this->IlluminateOutboxRepository(),
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

    private function IlluminateOutboxRepository(): OutboxRepository
    {
        return new IlluminateOutboxRepository(
            connection: $this->connection(),
            tableName: $this->outboxTableName,
            serializer: new ConstructingMessageSerializer(),
        );
    }

    private function connection(): ConnectionInterface
    {
        return DB::connection();
    }
}
