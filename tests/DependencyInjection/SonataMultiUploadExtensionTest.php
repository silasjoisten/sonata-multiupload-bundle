<?php

namespace SilasJoisten\Sonata\MultiUploadBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use SilasJoisten\Sonata\MultiUploadBundle\DependencyInjection\SonataMultiUploadExtension;

class SonataMultiUploadExtensionTest extends AbstractExtensionTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->setParameter('kernel.bundles', ['SonataMultiUpload' => true]);
    }

    public function testLoadDefault()
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
