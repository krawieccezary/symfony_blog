<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $entity, bool $flush = true):void;

    public function remove(User $entity, bool $flush = true):void;
}