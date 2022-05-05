<?php

declare(strict_types=1);

namespace App\CQRS\Query\Post;

use App\Repository\PostRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetPostsQueryHandler implements MessageHandlerInterface
{
    public function __construct(private PostRepositoryInterface $postRepository)
    {
    }

    public function __invoke(GetPostsQuery $getPostsQuery)
    {
        return $this->postRepository->getPosts();
    }
}