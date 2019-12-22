<?php

declare(strict_types=1);

namespace Tests\Unit\Factories;

use Tests\SimpleTestCase;
use PublishingKit\Cache\Factories\SymfonyCacheFactory;
use Mockery as m;

final class SymfonyCacheFactoryTest extends SimpleTestCase
{
    public function testDefault()
    {
        $factory = new SymfonyCacheFactory();
        $pool = $factory->make([]);
        $this->assertInstanceOf('Symfony\Component\Cache\Adapter\FilesystemAdapter', $pool);
        $this->assertInstanceOf('Symfony\Contracts\Cache\CacheInterface', $pool);
        $this->assertInstanceOf('Psr\Cache\CacheItemPoolInterface', $pool);
    }

    public function testFilesystem()
    {
        $factory = new SymfonyCacheFactory();
        $pool = $factory->make([
            'driver' => 'filesystem',
        ]);
        $this->assertInstanceOf('Symfony\Component\Cache\Adapter\FilesystemAdapter', $pool);
        $this->assertInstanceOf('Symfony\Contracts\Cache\CacheInterface', $pool);
        $this->assertInstanceOf('Psr\Cache\CacheItemPoolInterface', $pool);
    }

    public function testArray()
    {
        $factory = new SymfonyCacheFactory();
        $pool = $factory->make([
            'driver' => 'array',
        ]);
        $this->assertInstanceOf('Symfony\Component\Cache\Adapter\ArrayAdapter', $pool);
        $this->assertInstanceOf('Symfony\Contracts\Cache\CacheInterface', $pool);
        $this->assertInstanceOf('Psr\Cache\CacheItemPoolInterface', $pool);
    }
}
