<?php

declare(strict_types=1);

namespace App\CQRS\Command;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;
}