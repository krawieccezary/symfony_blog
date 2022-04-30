<?php

declare(strict_types=1);

namespace App\Command\User;

use App\Command\CommandBusInterface;

class CreateUserHandler
{
 public function __construct(
     private UserRepositoryInterface $userRepository,
     private CommandBusInterface $commandBus
 )
 {
 }

 public function __invoke()
 {
     // TODO: Implement __invoke() method.
 }
}