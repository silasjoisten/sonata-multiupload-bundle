<?php

namespace SilasJoisten\Sonata\MultiUploadBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SonataMultiUploadExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('sonata_multi_upload.max_upload_filesize', $config['max_upload_filesize']);
        $container->setParameter('sonata_multi_upload.redirect_to', $config['redirect_to']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('controller.yaml');
        $loader->load('admin_extensions.yaml');
    }
}
