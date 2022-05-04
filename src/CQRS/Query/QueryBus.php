<?php

declare(strict_types=1);

namespace App\CQRS\Query;

use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class QueryBus implements QueryBusInterface
{
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function query(QueryInterface $query): array
    {
        $envelope = $this->messageBus->dispatch($query);
        $handled = $envelope->last(HandledStamp::class);
        return $handled->getResult();
    }
}