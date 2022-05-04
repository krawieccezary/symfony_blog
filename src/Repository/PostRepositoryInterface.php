<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Post;

interface PostRepositoryInterface
{
    public function save(Post $entity, bool $flush = true): void;

    public function remove(Post $entity, bool $flush = true): void;
}