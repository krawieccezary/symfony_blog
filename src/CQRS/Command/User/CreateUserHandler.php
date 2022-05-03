<?php

declare(strict_types=1);

namespace App\CQRS\Command\User;

use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUserHandler implements MessageHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function __invoke(CreateUserCommand $createUserCommand): void
    {
        $user = new User();
        $user
            ->setId($createUserCommand->getId())
            ->setUsername($createUserCommand->getUsername())
            ->setName($createUserCommand->getName())
            ->setSurname($createUserCommand->getSurname())
            ->setEmail($createUserCommand->getEmail())
            ->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    $createUserCommand->getPlainPassword()
                )
            )
            ->setRoles($createUserCommand->getRoles());

        $this->userRepository->save($user);
    }

}