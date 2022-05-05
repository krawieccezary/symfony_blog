<?php

declare(strict_types=1);

namespace App\CQRS\Command\Post;

use App\CQRS\Command\CommandInterface;
use App\Entity\User;
use Symfony\Component\Uid\Uuid;

class CreatePostCommand implements CommandInterface
{

    public function __construct(
        private Uuid $id,
        private string $title,
        private string $content,
        private bool $active,
        private User $author,
    ) {
    }

    public static function createFromArray(array $parameters): self
    {
        return new CreatePostCommand(
            $parameters['id'],
            $parameters['title'],
            $parameters['content'],
            $parameters['active'],
            $parameters['author'],
        );
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

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

}