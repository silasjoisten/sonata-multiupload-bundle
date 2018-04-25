<?php

namespace SilasJoisten\Sonata\MultiUploadBundle\Admin;

use SilasJoisten\Sonata\MultiUploadBundle\Controller\MultiUploadController;
use Sonata\AdminBundle\Admin\AbstractAdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Route\RouteCollection;

class MultiUploadAdminExtension extends AbstractAdminExtension
{
    public function configureRoutes(AdminInterface $admin, RouteCollection $collection)
    {
        $collection->add('multi_upload', 'multi-upload');
    }
}