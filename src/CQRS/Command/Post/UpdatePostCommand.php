<?php

declare(strict_types=1);

namespace App\CQRS\Command\Post;

use App\CQRS\Command\CommandInterface;
use App\Entity\Post;

class UpdatePostCommand implements CommandInterface
{
    private string $title;
    private string $content;
    private bool $active;

    public function __construct(string $s)
    {
        $this->title = $s;
        $this->content = $s;
        $this->active = false;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getActive(): bool
    {
        return $this->active;
    }
}