<?php

namespace PublishingKit\Cache\Contracts\Factories;

use Psr\Cache\CacheItemPoolInterface;
use Zend\Config\Config;

interface CacheFactory
{
    public function make(Config $config): CacheItemPoolInterface;
}
