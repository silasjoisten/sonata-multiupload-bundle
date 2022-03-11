<?php

namespace SilasJoisten\Sonata\MultiUploadBundle\Tests\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractContainerBuilderTestCase;
use SilasJoisten\Sonata\MultiUploadBundle\DependencyInjection\Compiler\MultiUploadCompilerPass;
use SilasJoisten\Sonata\MultiUploadBundle\Pool\ProviderChain;
use Sonata\MediaBundle\Provider\ImageProvider;
use Symfony\Component\DependencyInjection\Definition;

class MultiUploadCompilerPassTest extends AbstractContainerBuilderTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->container->addCompilerPass(new MultiUploadCompilerPass());
    }

    public function testProcess(): void
    {
        $this->container->prependExtensionConfig('sonata_multi_upload', [
            'providers' => [ImageProvider::class],
        ]);

        $definition = new Definition();
        $definition->setClass(ImageProvider::class);

        $this->setDefinition(ImageProvider::class, $definition);

        $this->compile();

        $this->assertContainerBuilderHasService(ProviderChain::class);
    }
}
