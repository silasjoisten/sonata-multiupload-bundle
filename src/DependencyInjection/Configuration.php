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
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sonata_multi_upload');

        $rootNode
            ->children()
                ->integerNode('max_upload_filesize')
                    ->defaultValue(0)
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
