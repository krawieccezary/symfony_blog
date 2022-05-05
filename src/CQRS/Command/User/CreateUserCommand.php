<?php

declare(strict_types=1);

namespace App\CQRS\Command\User;

use App\CQRS\Command\CommandInterface;
use App\Service\User\CreateUser\CreateUserModel;
use Symfony\Component\Uid\Uuid;

class CreateUserCommand implements CommandInterface
{
    public function __construct(
        private Uuid $id,
        private string $username,
        private string $name,
        private string $surname,
        private string $email,
        private string $plainPassword,
        private array $roles,
    ) {
    }

    public static function createFromArray(array $parameters): self
    {
        return new CreateUserCommand(
            $parameters['id'],
            $parameters['username'],
            $parameters['name'],
            $parameters['surname'],
            $parameters['email'],
            $parameters['plainPassword'],
            $parameters['roles']
        );
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }
}