<?php

declare(strict_types=1);

namespace PublishingKit\Cache\Factories;

use Stash\Pool;
use Stash\Driver\Apc;
use Stash\Driver\BlackHole;
use Stash\Driver\Composite;
use Stash\Driver\Ephemeral;
use Stash\Driver\FileSystem;
use Stash\Driver\Memcache;
use Stash\Driver\Redis;
use Stash\Driver\Sqlite;
use Stash\Interfaces\DriverInterface;
use PublishingKit\Cache\Contracts\Factories\CacheFactory;
use Psr\Cache\CacheItemPoolInterface;
use PublishingKit\Cache\Exceptions\Factories\PathNotSet;

final class StashCacheFactory implements CacheFactory
{
    public function make(array $config): CacheItemPoolInterface
    {
        $driver = $this->createAdapter($config);
        return new Pool($driver);
    }

    private function createAdapter(array $config): DriverInterface
    {
        if (!isset($config['driver'])) {
            $config['driver'] = 'filesystem';
        }
        switch ($config['driver']) {
            case 'test':
                $driver = $this->createBlackHoleAdapter();
                break;
            case 'ephemeral':
                $driver = $this->createEphemeralAdapter();
                break;
            case 'composite':
                $driver = $this->createCompositeAdapter($config);
                break;
            case 'sqlite':
                $driver = $this->createSqliteAdapter($config);
                break;
            case 'apc':
                $driver = $this->createApcAdapter($config);
                break;
            case 'memcache':
                $driver = $this->createMemcacheAdapter($config);
                break;
            case 'redis':
                $driver = $this->createRedisAdapter($config);
                break;
            default:
                $driver = $this->createFilesystemAdapter($config);
                break;
        }
        return $driver;
    }

    private function createFilesystemAdapter(array $config): FileSystem
    {
        if (!isset($config['path'])) {
            throw new PathNotSet('Path must be set for the filesystem adapter');
        }
        $adapterConfig = [
            'path' => $config['path'],
        ];
        if (isset($config['dirSplit'])) {
            $adapterConfig['dirSplit'] = $config['dirSplit'];
        }
        if (isset($config['filePermissions'])) {
            $adapterConfig['filePermissions'] = $config['filePermissions'];
        }
        if (isset($config['dirPermissions'])) {
            $adapterConfig['dirPermissions'] = $config['dirPermissions'];
        }
        return new FileSystem($adapterConfig);
    }

    private function createBlackHoleAdapter(): BlackHole
    {
        return new BlackHole();
    }

    private function createEphemeralAdapter(): Ephemeral
    {
        return new Ephemeral();
    }

    private function createCompositeAdapter(array $config): Composite
    {
        $drivers = [];
        foreach ($config['subdrivers'] as $driver) {
            $drivers[] = $this->createAdapter($driver);
        }
        return new Composite([
            'drivers' => $drivers
        ]);
    }

    private function createSqliteAdapter(array $config): Sqlite
    {
        return new Sqlite([
            'extension' => isset($config['extension']) ? $config['extension'] : null,
            'version' => isset($config['version']) ? $config['version'] : null,
            'nesting' => isset($config['nesting']) ? $config['nesting'] : null,
            'path' => isset($config['path']) ? $config['path'] : null,
            'filePermissions' => isset($config['filePermissions']) ? $config['filePermissions'] : null,
            'dirPermissions' => isset($config['dirPermissions']) ? $config['dirPermissions'] : null
        ]);
    }

    private function createApcAdapter(array $config): Apc
    {
        return new Apc([
            'ttl' => isset($config['ttl']) ? $config['ttl'] : null,
            'namespace' => isset($config['namespace']) ? $config['namespace'] : null
        ]);
    }

    private function createMemcacheAdapter(array $config): Memcache
    {
        $options = [
            'servers' => isset($config['servers']) ? $config['servers'] : null,
        ];
        if (isset($config['extension'])) {
            $options['extension'] = $config['extension'];
        }
        if (isset($config['prefix_key'])) {
            $options['prefix_key'] = $config['prefix_key'];
        }
        return new Memcache($options);
    }

    private function createRedisAdapter(array $config): Redis
    {
        return new Redis([
            'servers' => isset($config['servers']) ? $config['servers'] : null,
        ]);
    }
}
