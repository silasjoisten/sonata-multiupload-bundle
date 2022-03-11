<?php

namespace SilasJoisten\Sonata\MultiUploadBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use SilasJoisten\Sonata\MultiUploadBundle\Admin\MultiUploadAdminExtension;
use SilasJoisten\Sonata\MultiUploadBundle\Controller\MultiUploadController;
use SilasJoisten\Sonata\MultiUploadBundle\DependencyInjection\SonataMultiUploadExtension;
use SilasJoisten\Sonata\MultiUploadBundle\Pool\ProviderChain;
use SilasJoisten\Sonata\MultiUploadBundle\Twig\MultiUploadExtension;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

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

    public function testLoadFailsIfProviderMissing(): void
    {
        self::expectException(InvalidConfigurationException::class);

        $this->load();
    }

    public function testLoadDefault(): void
    {
        $this->load(['providers' => []]);

        $this->assertTrue($this->container->hasParameter('sonata_multi_upload.max_upload_filesize'));
        $this->assertTrue($this->container->hasParameter('sonata_multi_upload.redirect_to'));
        $this->assertSame(0, $this->container->getParameter('sonata_multi_upload.max_upload_filesize'));
        $this->assertNull($this->container->getParameter('sonata_multi_upload.redirect_to'));
    }

    public function testLoadWithConfig(): void
    {
        $this->load(['max_upload_filesize' => 300000, 'redirect_to' => 'admin_sonata_media_media_list', 'providers' => ['sonata.image.provider.test']]);

        $this->assertTrue($this->container->hasParameter('sonata_multi_upload.max_upload_filesize'));
        $this->assertTrue($this->container->hasParameter('sonata_multi_upload.redirect_to'));
        $this->assertSame(300000, $this->container->getParameter('sonata_multi_upload.max_upload_filesize'));
        $this->assertSame('admin_sonata_media_media_list', $this->container->getParameter('sonata_multi_upload.redirect_to'));
    }

    public function testLoadingServiceDefinitions(): void
    {
        $this->load(['providers' => []]);

        $this->assertTrue($this->container->hasDefinition(MultiUploadController::class));
        $this->assertTrue($this->container->hasDefinition(MultiUploadAdminExtension::class));
        $this->assertTrue($this->container->hasDefinition(ProviderChain::class));
        $this->assertTrue($this->container->hasDefinition(MultiUploadExtension::class));
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensions(): array
    {
        return [
            new SonataMultiUploadExtension(),
        ];
    }
}
