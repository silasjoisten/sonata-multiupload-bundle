<?php

namespace SilasJoisten\Sonata\MultiUploadBundle\Tests\Admin;

use PHPUnit\Framework\TestCase;
use SilasJoisten\Sonata\MultiUploadBundle\Admin\MultiUploadAdminExtension;
use SilasJoisten\Sonata\MultiUploadBundle\Tests\Fixture\Admin\FakeAdmin;
use SilasJoisten\Sonata\MultiUploadBundle\Tests\Fixture\Entity\Fake;
use Sonata\AdminBundle\Model\AuditManager;
use Sonata\AdminBundle\Route\PathInfoBuilder;
use Sonata\AdminBundle\Security\Handler\NoopSecurityHandler;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Routing\Route;

class MultiUploadAdminExtensionTest extends TestCase
{
    public function testConfigureRoutes(): void
    {
        $admin = new FakeAdmin(FakeAdmin::class, Fake::class, '');
        $admin->setRouteBuilder(new PathInfoBuilder(new AuditManager(new Container())));
        $admin->setSecurityHandler(new NoopSecurityHandler());

        $extension = new MultiUploadAdminExtension();
        $extension->configureRoutes($admin, $admin->getRoutes());

        self::assertInstanceOf(Route::class, $admin->getRoutes()->get('multi_upload'));
    }
}
