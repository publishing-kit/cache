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
        $pool = $factory->make([
            'path' => 'tests/filesystem/cache',
        ]);
        $this->assertInstanceOf('Cache\Adapter\Doctrine\DoctrineCachePool', $pool);
        $this->assertInstanceOf('Psr\Cache\CacheItemPoolInterface', $pool);
        $this->assertInstanceOf('Doctrine\Common\Cache\FilesystemCache', $pool->getCache());
    }

    public function testFilesystem()
    {
        $factory = new DoctrineCacheFactory();
        $pool = $factory->make([
            'driver' => 'filesystem',
            'path' => 'tests/filesystem/cache',
        ]);
        $this->assertInstanceOf('Cache\Adapter\Doctrine\DoctrineCachePool', $pool);
        $this->assertInstanceOf('Psr\Cache\CacheItemPoolInterface', $pool);
        $this->assertInstanceOf('Doctrine\Common\Cache\FilesystemCache', $pool->getCache());
    }

    public function testFilesystemPathNotSet()
    {
        $this->expectException('PublishingKit\Cache\Exceptions\Factories\PathNotSet');
        $factory = new DoctrineCacheFactory();
        $config = [
            'driver' => 'filesystem',
        ];
        $pool = $factory->make($config);
    }

    public function testArray()
    {
        $factory = new DoctrineCacheFactory();
        $pool = $factory->make([
            'driver' => 'array',
        ]);
        $this->assertInstanceOf('Cache\Adapter\Doctrine\DoctrineCachePool', $pool);
        $this->assertInstanceOf('Psr\Cache\CacheItemPoolInterface', $pool);
        $this->assertInstanceOf('Doctrine\Common\Cache\ArrayCache', $pool->getCache());
    }

    public function testPhpFiles()
    {
        $factory = new DoctrineCacheFactory();
        $pool = $factory->make([
            'driver' => 'php-files',
            'path' => 'tests/filesystem/cache',
        ]);
        $this->assertInstanceOf('Cache\Adapter\Doctrine\DoctrineCachePool', $pool);
        $this->assertInstanceOf('Psr\Cache\CacheItemPoolInterface', $pool);
        $this->assertInstanceOf('Doctrine\Common\Cache\PhpFileCache', $pool->getCache());
    }

    public function testPhpFilesPathNotSet()
    {
        $this->expectException('PublishingKit\Cache\Exceptions\Factories\PathNotSet');
        $factory = new DoctrineCacheFactory();
        $config = [
            'driver' => 'php-files',
        ];
        $pool = $factory->make($config);
    }
}
