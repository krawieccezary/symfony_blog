<?php

declare(strict_types=1);

namespace App\CQRS\Query;

use Symfony\Component\Messenger\Envelope;

interface QueryBusInterface
{
    public function query(QueryInterface $query): array;

}