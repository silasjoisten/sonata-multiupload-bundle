<?php

declare(strict_types=1);

namespace SilasJoisten\Sonata\MultiUploadBundle\Admin;

use SilasJoisten\Sonata\MultiUploadBundle\Controller\MultiUploadController;
use Sonata\AdminBundle\Admin\AbstractAdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

final class MultiUploadAdminExtension extends AbstractAdminExtension
{
    public function configureRoutes(AdminInterface $admin, RouteCollectionInterface $collection): void
    {
        $collection->add('multi_upload', 'multi-upload', [
            '_controller' => sprintf('%s::multiUpload', MultiUploadController::class),
        ]);
    }
}
