<?php

namespace SilasJoisten\Sonata\MultiUploadBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('sonata_multi_upload');

        $treeBuilder->getRootNode()
            ->children()
                ->integerNode('max_upload_filesize')
                    ->info('in bytes (3000000 == 3MB), 0 means to allow every size')
                    ->defaultValue(0)
                ->end()
                ->scalarNode('redirect_to')
                    ->info('allows a redirect to a route after success')
                    ->defaultNull()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
