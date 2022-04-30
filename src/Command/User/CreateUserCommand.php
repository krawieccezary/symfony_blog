<?php

declare(strict_types=1);

namespace App\Command\User;

class CreateUserCommand
{
    public function __construct(
        private readonly string $name,
        private readonly string $surname,
        private readonly string $username,
        private readonly string $email,
        private readonly string $password
    )
    {
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}