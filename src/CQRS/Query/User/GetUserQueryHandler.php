<?php

declare(strict_types=1);

namespace App\CQRS\Query\User;

use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetUserQueryHandler implements MessageHandlerInterface
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(GetUserQuery $getUserQuery): User
    {
        $id = $getUserQuery->getId();
        return $this->userRepository->getUser($id);
    }
}