<?php

declare(strict_types=1);

namespace App\CQRS\Command\Post;

use App\Entity\Post;
use App\Repository\PostRepositoryInterface;

class CreatePostHandler
{
    public function __construct(private PostRepositoryInterface $postRepository)
    {
    }

    public function __invoke(CreatePostCommand $createPostCommand): void
    {
        $post = new Post();
        $post
            ->setId($createPostCommand->getId())
            ->setTitle($createPostCommand->getTitle())
            ->setContent($createPostCommand->getContent())
            ->setCreatedAt($createPostCommand->getCreatedAt())
            ->setActive($createPostCommand->isActive())
            ->setAuthor($createPostCommand->getAuthor());

        $this->postRepository->save($post);
    }
}