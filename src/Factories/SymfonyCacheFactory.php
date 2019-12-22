<?php

declare(strict_types=1);

namespace PublishingKit\Cache\Factories;

use Psr\Cache\CacheItemPoolInterface;
use PublishingKit\Cache\Contracts\Factories\CacheFactory;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

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
}
