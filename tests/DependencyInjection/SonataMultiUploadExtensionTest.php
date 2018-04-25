<?php

namespace SilasJoisten\Sonata\MultiUploadBundle\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class SonataMultiUploadExtensionTest extends AbstractExtensionTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->setParameter('kernel.bundles', ['SonataMultiUpload' => true]);
    }

    public function testLoadDefault(): void
    {
        $this->load();
    }

    public function getContainerExtensions()
    {
        return [
            new SonataMultiUploadExtension(),
        ];
    }

}
