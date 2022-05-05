<?php

declare(strict_types=1);

namespace App\Service\User\CreateUser;

use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function create(CreateUserModel $createUserModel): void
    {
        $user = new User();
        $user
            ->setId($createUserModel->getId())
            ->setUsername($createUserModel->getUsername())
            ->setName($createUserModel->getName())
            ->setSurname($createUserModel->getSurname())
            ->setEmail($createUserModel->getEmail())
            ->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    $createUserModel->getPlainPassword()
                )
            )
            ->setRoles(User::ROLE_USER);

        $this->userRepository->save($user);
    }
}