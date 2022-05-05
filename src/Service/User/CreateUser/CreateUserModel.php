<?php

declare(strict_types=1);

namespace App\Service\User\CreateUser;

use Symfony\Component\Uid\Uuid;

class CreateUserModel
{
    public function __construct(
        private Uuid $id,
        private string $username,
        private string $name,
        private string $surname,
        private string $email,
        private string $plainPassword,
        private array $roles
    ) {
    }

    public static function createUserFromArray($parameters): self
    {
        return new CreateUserModel(
            $parameters['id'],
            $parameters['username'],
            $parameters['name'],
            $parameters['surname'],
            $parameters['email'],
            $parameters['plainPassword'],
            $parameters['roles']
        );
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function setId(Uuid $id): self
    {
        $this->id = $id;

        return $this;
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