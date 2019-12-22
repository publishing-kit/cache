<?php

declare(strict_types=1);

namespace Tests\Unit\Factories;

use Tests\SimpleTestCase;
use PublishingKit\Cache\Factories\SymfonyCacheFactory;
use Mockery as m;

final class SymfonyCacheFactoryTest extends SimpleTestCase
{
    public function testFilesystem()
    {
        $factory = new SymfonyCacheFactory();
        $pool = $factory->make([]);
        $this->assertInstanceOf('Symfony\Component\Cache\Adapter\FilesystemAdapter', $pool);
        $this->assertInstanceOf('Symfony\Contracts\Cache\CacheInterface', $pool);
    }
}
