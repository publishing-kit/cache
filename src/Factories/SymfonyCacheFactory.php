<?php

declare(strict_types=1);

namespace PublishingKit\Cache\Factories;

use Psr\Cache\CacheItemPoolInterface;
use PublishingKit\Cache\Contracts\Factories\CacheFactory;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\ApcuAdapter;
use Symfony\Component\Cache\Adapter\MemcachedAdapter;

final class SymfonyCacheFactory implements CacheFactory
{
    public function make(array $config): CacheItemPoolInterface
    {
        return $this->createAdapter($config);
    }

    private function createAdapter(array $config): CacheItemPoolInterface
    {
        if (!isset($config['driver'])) {
            $config['driver'] = 'filesystem';
        }
        switch ($config['driver']) {
            case 'array':
                $driver = $this->createArrayAdapter($config);
                break;
            case 'apcu':
                $driver = $this->createApcuAdapter($config);
                break;
            case 'memcached':
                $driver = $this->createMemcachedAdapter($config);
                break;
            default:
                $driver = $this->createFilesystemAdapter($config);
                break;
        }
        return $driver;
    }

    private function createFilesystemAdapter(array $config): FilesystemAdapter
    {
        return new FilesystemAdapter();
    }

    private function createArrayAdapter(array $config): ArrayAdapter
    {
        return new ArrayAdapter();
    }

    private function createApcuAdapter(array $config): ApcuAdapter
    {
        return new ApcuAdapter();
    }

    private function createMemcachedAdapter(array $config): MemcachedAdapter
    {
        $client = MemcachedAdapter::createConnection(
            $config['servers']
        );
        return new MemcachedAdapter();
    }
}
