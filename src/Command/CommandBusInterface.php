<?php

declare(strict_types=1);

namespace App\Command;

interface CommandBusInterface
{
    public function dispatch(Command $command): void;
}