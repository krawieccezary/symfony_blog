<?php

declare(strict_types=1);

namespace App\CQRS\Command\User;

use App\Service\User\CreateUser\CreateUserModel;
use App\Service\User\CreateUser\CreateUserService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateUserHandler implements MessageHandlerInterface
{
    public function __construct(private CreateUserService $createUserService)
    {
    }

    public function __invoke(CreateUserCommand $createUserCommand): void
    {
        $createUserModel = CreateUserModel::createUserFromArray($createUserCommand);

        $this->createUserService->create($createUserModel);
    }

}