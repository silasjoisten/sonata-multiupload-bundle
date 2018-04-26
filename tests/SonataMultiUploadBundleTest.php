<?php

namespace SilasJoisten\Sonata\MultiUploadBundle\Tests;

use PHPUnit\Framework\TestCase;
use SilasJoisten\Sonata\MultiUploadBundle\DependencyInjection\Compiler\MultiUploadCompilerPass;
use SilasJoisten\Sonata\MultiUploadBundle\SonataMultiUploadBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SonataMultiUploadBundleTest extends TestCase
{
    public function testBuild()
    {
        $container = $this->createMock(ContainerBuilder::class);
        $container->expects($this->once())
            ->method('addCompilerPass')
            ->with(new MultiUploadCompilerPass())
            ->willReturnSelf();

        $bundle = new SonataMultiUploadBundle();
        $bundle->build($container);
    }
}
