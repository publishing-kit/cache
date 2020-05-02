<?php

declare(strict_types=1);

namespace Tests\Unit\Factories;

use PublishingKit\Cache\Factories\DoctrineCacheFactory;
use Tests\SimpleTestCase;
use Mockery as m;

final class DoctrineCacheFactoryTest extends SimpleTestCase
{
    public function testDefault()
    {
        $factory = new DoctrineCacheFactory();
        $pool = $factory->make([]);
        $this->assertInstanceOf('Cache\Adapter\Doctrine\DoctrineCachePool', $pool);
        $this->assertInstanceOf('Psr\Cache\CacheItemPoolInterface', $pool);
    }

    public function testFilesystem()
    {
        $factory = new SymfonyCacheFactory();
        $pool = $factory->make([
            'driver' => 'filesystem',
        ]);
        $this->assertInstanceOf('Cache\Adapter\Doctrine\DoctrineCachePool', $pool);
        $this->assertInstanceOf('Psr\Cache\CacheItemPoolInterface', $pool);
    }
}
