<?php

declare(strict_types=1);

namespace PublishingKit\Cache\Contracts\Factories;

use Psr\Cache\CacheItemPoolInterface;

interface CacheFactory
{
    public function make(array $config): CacheItemPoolInterface;
}
