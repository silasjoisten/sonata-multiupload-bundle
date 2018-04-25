<?php

namespace SilasJoisten\Sonata\MultiUploadBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MultiUploadCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds('sonata.media.provider') as $id => $attributes) {
            foreach ($attributes as $attribute) {
                if (($attribute['multi_upload'] ?? false) === true) {
                    $container->getDefinition($id)->addMethodCall('setMultiUpload', [$attribute['multi_upload']]);
                }
            }
        }
    }
}
