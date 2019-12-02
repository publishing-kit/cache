<?php

declare(strict_types=1);

namespace PublishingKit\Cache\Contracts\Factories;

use Psr\Cache\CacheItemPoolInterface;
use Zend\Config\Config;

interface CacheFactory
{
    public function make(Config $config): CacheItemPoolInterface;
}
