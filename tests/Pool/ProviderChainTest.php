<?php

namespace SilasJoisten\Sonata\MultiUploadBundle\Tests\Pool;

use PHPUnit\Framework\TestCase;
use SilasJoisten\Sonata\MultiUploadBundle\Pool\ProviderChain;
use Sonata\MediaBundle\Provider\MediaProviderInterface;

class ProviderChainTest extends TestCase
{
    public function testAddProvider(): void
    {
        $chain = new ProviderChain();

        self::assertEmpty($chain->getProviders());

        $provider = $this->createMock(MediaProviderInterface::class);
        $provider->method('getName')->willReturn('sample-name');

        $chain->addProvider($provider);

        self::assertCount(1, $chain->getProviders());
    }

    public function testHasProviderWithExistentProvider(): void
    {
        $chain = new ProviderChain();

        self::assertEmpty($chain->getProviders());

        $provider = $this->createMock(MediaProviderInterface::class);
        $provider->method('getName')->willReturn('sample-name');

        $chain->addProvider($provider);

        self::assertTrue($chain->hasProvider($provider));
    }

    public function testHasProviderWithNonExistentProvider(): void
    {
        $chain = new ProviderChain();

        self::assertEmpty($chain->getProviders());

        $provider = $this->createMock(MediaProviderInterface::class);
        $provider->method('getName')->willReturn('sample-name');

        self::assertFalse($chain->hasProvider($provider));
    }

    public function testRemoveProvider(): void
    {
        $chain = new ProviderChain();

        self::assertEmpty($chain->getProviders());

        $provider = $this->createMock(MediaProviderInterface::class);
        $provider->method('getName')->willReturn('sample-name');

        $chain->addProvider($provider);

        self::assertCount(1, $chain->getProviders());

        $chain->removeProvider($provider);

        self::assertEmpty($chain->getProviders());
    }

    public function testRemoveProviderNonExistentProvider(): void
    {
        $chain = new ProviderChain();

        self::assertEmpty($chain->getProviders());

        $nonExistentProvider = $this->createMock(MediaProviderInterface::class);
        $nonExistentProvider->method('getName')->willReturn('sample-name');

        self::expectException(\InvalidArgumentException::class);

        $chain->removeProvider($nonExistentProvider);
    }
}
