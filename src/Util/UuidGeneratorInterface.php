<?php

declare(strict_types=1);

namespace App\Util;

use Symfony\Component\Uid\Uuid;

interface UuidGeneratorInterface
{
    public function generate(): Uuid;
}