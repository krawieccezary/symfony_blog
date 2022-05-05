<?php

declare(strict_types=1);

namespace App\CQRS\Query\Post;

use App\Entity\Post;
use App\Repository\PostRepositoryInterface;

class GetPostQueryHandler
{
    public function __construct(private PostRepositoryInterface $postRepository)
    {
    }

    public function __invoke(GetPostQuery $getPostQuery): Post
    {
        $id = $getPostQuery->getId();
        return $this->postRepository->getPost($id);
    }
}