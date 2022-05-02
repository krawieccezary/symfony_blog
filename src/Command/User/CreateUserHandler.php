<?php

declare(strict_types=1);

namespace App\Command\User;

use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateUserHandler implements MessageHandlerInterface
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(CreateUserCommand $createUserCommand): void
    {
        $user = (new User())
            ->setId($createUserCommand->getId())
            ->setName($createUserCommand->getName())
            ->setSurname($createUserCommand->getSurname())
            ->setEmail($createUserCommand->getEmail())
            ->setUsername($createUserCommand->getUsername());

        $this->userRepository->save($user);
    }

}