<?php

declare(strict_types=1);

namespace App\CQRS\Command\Post;

use App\CQRS\Command\CommandInterface;
use App\Repository\PostRepositoryInterface;

class DeletePostHandler implements CommandInterface
{
    public function __construct(private PostRepositoryInterface $postRepository)
    {
    }

    public function dispatch(DeletePostCommand $deletePostCommand)
    {
        $this->postRepository->removeById($deletePostCommand->getId());
    }
}