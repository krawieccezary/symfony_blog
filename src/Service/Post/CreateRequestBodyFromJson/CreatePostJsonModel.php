<?php

declare(strict_types=1);

namespace App\Service\Post\CreateRequestBodyFromJson;

class CreatePostJsonModel
{
    private string $title;
    private string $content;
    private bool $active;

    public function __construct(array $parameters)
    {
        $this->title = $parameters['title'];
        $this->content = $parameters['content'];
        $this->active = $parameters['active'];
    }

    public function getTitle(): mixed
    {
        return $this->title;
    }

    public function getContent(): mixed
    {
        return $this->content;
    }
    
    public function getActive(): mixed
    {
        return $this->active;
    }


}