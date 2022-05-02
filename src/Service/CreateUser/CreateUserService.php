<?php

declare(strict_types=1);

namespace App\Service\CreateUser;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUserService
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function create(CreateUserModel $createUserModel): User
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
            ->setRoles($createUserModel->getRoles());

        return $user;
    }
}