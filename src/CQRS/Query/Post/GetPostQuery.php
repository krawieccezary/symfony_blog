<?php

declare(strict_types=1);

namespace App\CQRS\Query\Post;

use App\CQRS\Query\QueryInterface;
use Symfony\Component\Uid\Uuid;

class GetPostQuery implements QueryInterface
{
    public function __construct(private Uuid $id)
    {
    }

    public function getId(): Uuid
    {
        return $this->id;
    }
}