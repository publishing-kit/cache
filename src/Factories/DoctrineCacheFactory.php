<?php

declare(strict_types=1);

namespace PublishingKit\Cache\Factories;

use Cache\Adapter\Doctrine\DoctrineCachePool;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\Cache\PhpFileCache;
use Doctrine\Common\Cache\VoidCache;
use Psr\Cache\CacheItemPoolInterface;
use PublishingKit\Cache\Contracts\Factories\CacheFactory;
use PublishingKit\Cache\Exceptions\Factories\PathNotSet;

final class DoctrineCacheFactory implements CacheFactory
{
    public function make(array $config): CacheItemPoolInterface
    {
        return new DoctrineCachePool($this->createAdapter($config));
    }

    private function createAdapter(array $config): Cache
    {
        if (!isset($config['driver'])) {
            $config['driver'] = 'filesystem';
        }
        switch ($config['driver']) {
            case 'array':
                $driver = $this->createArrayAdapter();
                break;
            case 'php-files':
                $driver = $this->createPhpFilesAdapter($config);
                break;
            case 'void':
                $driver = $this->createVoidAdapter();
                break;
            default:
                $driver = $this->createFilesystemAdapter($config);
                break;
        }
        return $driver;
    }

    private function createFilesystemAdapter(array $config): FilesystemCache
    {
        if (!isset($config['path'])) {
            throw new PathNotSet('Path must be set for the filesystem adapter');
        }
        return new FilesystemCache($config['path']);
    }

    private function createArrayAdapter(): ArrayCache
    {
        return new ArrayCache();
    }

    private function createPhpFilesAdapter(array $config): PhpFileCache
    {
        if (!isset($config['path'])) {
            throw new PathNotSet('Path must be set for the PHP file adapter');
        }
        return new PhpFileCache($config['path']);
    }

    private function createVoidAdapter(): VoidCache
    {
        return new VoidCache();
    }
}
