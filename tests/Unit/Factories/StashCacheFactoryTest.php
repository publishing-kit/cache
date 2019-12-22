<?php

declare(strict_types=1);

namespace Tests\Unit\Factories;

use Tests\SimpleTestCase;
use PublishingKit\Cache\Factories\StashCacheFactory;
use Stash\Exception\RuntimeException;
use Mockery as m;

final class StashCacheFactoryTest extends SimpleTestCase
{
    public function testDefault()
    {
        $factory = new StashCacheFactory();
        $config = [
            'path' => 'tests/filesystem/cache',
        ];
        $pool = $factory->make($config);
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\FileSystem', $pool->getDriver());
    }

    public function testFilesystem()
    {
        $factory = new StashCacheFactory();
        $config = [
            'path' => 'tests/filesystem/cache',
            'driver' => 'filesystem',
            'filePermissions' => 0660,
            'dirPermissions' => 0770,
            'dirSplit' => 2,
        ];
        $pool = $factory->make($config);
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\FileSystem', $pool->getDriver());
    }

    public function testFilesystemPathNotSet()
    {
        $this->expectException('PublishingKit\Cache\Exceptions\Factories\PathNotSet');
        $factory = new StashCacheFactory();
        $config = [
            'driver' => 'filesystem',
            'filePermissions' => 0660,
            'dirPermissions' => 0770,
            'dirSplit' => 2,
        ];
        $pool = $factory->make($config);
    }

    public function testBlackhole()
    {
        $factory = new StashCacheFactory();
        $config = [
            'driver' => 'test'
        ];
        $pool = $factory->make($config);
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\BlackHole', $pool->getDriver());
    }

    public function testEphemeral()
    {
        $factory = new StashCacheFactory();
        $config = [
            'driver' => 'ephemeral'
        ];
        $pool = $factory->make($config);
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\Ephemeral', $pool->getDriver());
    }

    public function testComposite()
    {
        $factory = new StashCacheFactory();
        $config = [
            'driver' => 'composite',
            'subdrivers' => [[
                'driver' => 'ephemeral',
            ], [
                'driver' => 'filesystem',
                'path' => 'tests/filesystem/cache',
            ]]
        ];
        $pool = $factory->make($config);
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\Composite', $pool->getDriver());
    }

    public function testSqlite()
    {
        $factory = new StashCacheFactory();
        $config = [
            'driver' => 'sqlite'
        ];
        $pool = $factory->make($config);
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\Sqlite', $pool->getDriver());
    }

    public function testApc()
    {
        $factory = new StashCacheFactory();
        try {
            $config = [
                'driver' => 'apc'
            ];
            $pool = $factory->make($config);
        } catch (RuntimeException $e) {
            $this->markTestSkipped('Dependency not installed');
        }
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\Apc', $pool->getDriver());
    }

    public function testMemcache()
    {
        $factory = new StashCacheFactory();
        /* try { */
            $config = [
                'driver' => 'memcache',
                'servers' => [[
                    '127.0.0.1',
                    '11211'
                ]],
                'prefix_key' => 'test',
            ];
            $pool = $factory->make($config);
        /* } catch (RuntimeException $e) { */
        /*     $this->markTestSkipped('Dependency not installed'); */
        /* } */
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\Memcache', $pool->getDriver());
    }

    public function testRedis()
    {
        $factory = new StashCacheFactory();
        try {
            $config = [
                'driver' => 'redis',
                'servers' => [[
                    '127.0.0.1',
                    '6379'
                ]]
            ];
            $pool = $factory->make($config);
        } catch (RuntimeException $e) {
            $this->markTestSkipped('Dependency not installed');
        }
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\Redis', $pool->getDriver());
    }
}
