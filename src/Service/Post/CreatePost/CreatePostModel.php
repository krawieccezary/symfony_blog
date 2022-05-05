<?php

declare(strict_types=1);

namespace App\Service\Post\CreatePost;

use App\Entity\User;
use Symfony\Component\Uid\Uuid;

class CreatePostModel
{
    private Uuid $id;
    private string $title;
    private string $content;
    private \DateTimeImmutable $createdAt;
    private bool $active;
    private User $author;


    public static function create(
        Uuid $id,
        string $title,
        string $content,
        bool $active,
        User $author
    ): self {
        return (new CreatePostModel())
            ->setId($id)
            ->setTitle($title)
            ->setContent($content)
            ->setCreatedAt()
            ->setActive($active)
            ->setAuthor($author);
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(): self
    {
        $this->createdAt = new \DateTimeImmutable();

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(User $author): self
    {
        $this->author = $author;

        return $this;
    }
}