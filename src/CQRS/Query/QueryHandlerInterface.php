<?php

declare(strict_types=1);

namespace App\CQRS\Query;

interface QueryHandlerInterface
{
    public function __invoke(QueryInterface $query);
}