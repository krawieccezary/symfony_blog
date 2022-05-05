<?php

declare(strict_types=1);

namespace App\CQRS\Command\Post;

use App\Type\MyUuid;

class DeletePostCommand
{
    public function __construct(private MyUuid $id)
    {
    }
    
    public function getId(): MyUuid
    {
        return $this->id;
    }

}