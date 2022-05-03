<?php

declare(strict_types=1);

namespace App\CQRS\Query\User;

use App\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetUsersQueryHandler implements MessageHandlerInterface
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(GetUsersQuery $getUsersQuery): array
    {
        return $this->userRepository->getUsers();
    }
}