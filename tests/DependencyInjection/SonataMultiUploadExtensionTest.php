<?php

namespace SilasJoisten\Sonata\MultiUploadBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use SilasJoisten\Sonata\MultiUploadBundle\Admin\MultiUploadAdminExtension;
use SilasJoisten\Sonata\MultiUploadBundle\Controller\MultiUploadController;
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

        $this->assertTrue($this->container->hasParameter('sonata_multi_upload.max_upload_filesize'));
        $this->assertTrue($this->container->hasParameter('sonata_multi_upload.redirect_to'));
        $this->assertSame(0, $this->container->getParameter('sonata_multi_upload.max_upload_filesize'));
        $this->assertNull($this->container->getParameter('sonata_multi_upload.redirect_to'));
    }

    public function testLoadWithConfig()
    {
        $this->load(['max_upload_filesize' => 300000, 'redirect_to' => 'admin_sonata_media_media_list']);

        $this->assertTrue($this->container->hasParameter('sonata_multi_upload.max_upload_filesize'));
        $this->assertTrue($this->container->hasParameter('sonata_multi_upload.redirect_to'));
        $this->assertSame(300000, $this->container->getParameter('sonata_multi_upload.max_upload_filesize'));
        $this->assertSame('admin_sonata_media_media_list', $this->container->getParameter('sonata_multi_upload.redirect_to'));
    }

    public function testLoadingServiceDefinitions()
    {
        $this->load();

        $this->assertTrue($this->container->hasDefinition(MultiUploadController::class));
        $this->assertTrue($this->container->hasDefinition(MultiUploadAdminExtension::class));
    }

    public function getContainerExtensions()
    {
        return [
            new SonataMultiUploadExtension(),
        ];
    }
}
