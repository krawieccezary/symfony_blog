<?php

declare(strict_types=1);

namespace App\CQRS\Command\User;

use App\CQRS\Command\CommandInterface;
use App\Service\CreateUser\CreateUserModel;
use Symfony\Component\Uid\Uuid;

class CreateUserCommand implements CommandInterface
{
    private Uuid $id;
    private string $username;
    private string $name;
    private string $surname;
    private string $email;
    private string $plainPassword;
    private array $roles;

    public function __construct(CreateUserModel $createUserModel)
    {
        $this->id = $createUserModel->getId();
        $this->username = $createUserModel->getUsername();
        $this->name = $createUserModel->getName();
        $this->surname = $createUserModel->getSurname();
        $this->email = $createUserModel->getEmail();
        $this->plainPassword = $createUserModel->getPlainPassword();
        $this->roles = $createUserModel->getRoles();
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