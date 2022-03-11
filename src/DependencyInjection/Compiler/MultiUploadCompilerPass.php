<?php

declare(strict_types=1);

namespace SilasJoisten\Sonata\MultiUploadBundle\DependencyInjection\Compiler;

use SilasJoisten\Sonata\MultiUploadBundle\Pool\ProviderChain;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\Reference;

final class MultiUploadCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $config = $container->getExtensionConfig('sonata_multi_upload');

        $definiton = new Definition();
        $definiton->setPublic(true);
        $definiton->setClass(ProviderChain::class);

        foreach ($config[0]['providers'] as $providerName) {
            if (!$container->has($providerName)) {
                throw new ServiceNotFoundException($providerName);
            }

            $definiton->addMethodCall('addProvider', [new Reference($providerName)]);
        }

        $container->setDefinition($definiton->getClass(), $definiton);
    }
}
