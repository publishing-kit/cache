<?php

declare(strict_types=1);

namespace PublishingKit\Cache\Factories;

use Cache\Adapter\Doctrine\DoctrineCachePool;
use Doctrine\Common\Cache\Cache;
use Psr\Cache\CacheItemPoolInterface;
use PublishingKit\Cache\Contracts\Factories\CacheFactory;

final class DoctrineCacheFactory implements CacheFactory
{
    public function make(array $config): CacheItemPoolInterface
    {
        return new DoctrineCachePool($this->createAdapter($config));
    }

    private function createAdapter(array $config): Cache
    {
    }
}
