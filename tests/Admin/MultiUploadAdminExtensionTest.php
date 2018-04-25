<?php

namespace SilasJoisten\Sonata\MultiUploadBundle\Tests\Admin;

use PHPUnit\Framework\TestCase;
use SilasJoisten\Sonata\MultiUploadBundle\Admin\MultiUploadAdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Route\RouteCollection;

class MultiUploadAdminExtensionTest extends TestCase
{
    public function testConfigureRoutes()
    {
        $admin = $this->createMock(AdminInterface::class);
        $routeCollection = $this->createMock(RouteCollection::class);
        $routeCollection->expects($this->once())
            ->method('add')
            ->with('multi_upload', 'multi-upload')
            ->willReturnSelf();

        $extension = new MultiUploadAdminExtension();
        $extension->configureRoutes($admin, $routeCollection);
    }
}
