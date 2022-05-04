<?php

declare(strict_types=1);

namespace App\CQRS\Command\Post;

use App\CQRS\Command\CommandInterface;
use App\Entity\User;
use App\Service\Post\CreatePost\CreatePostModel;
use Symfony\Component\Uid\Uuid;

class CreatePostCommand implements CommandInterface
{
    private Uuid $id;
    private string $title;
    private string $content;
    private \DateTimeImmutable $createdAt;
    private bool $active;
    private User $author;

    public function __construct(CreatePostModel $createPostModel)
    {
        $this->id = $createPostModel->getId();
        $this->title = $createPostModel->getTitle();
        $this->content = $createPostModel->getContent();
        $this->createdAt = $createPostModel->getCreatedAt();
        $this->active = $createPostModel->isActive();
        $this->author = $createPostModel->getAuthor();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function isActive(): bool
    {
        return $this->active;
    }
    
    public function getAuthor(): User
    {
        return $this->author;
    }


}