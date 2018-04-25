<?php

namespace SilasJoisten\Sonata\MultiUploadBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use SilasJoisten\Sonata\MultiUploadBundle\DependencyInjection\SonataMultiUploadExtension;

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
