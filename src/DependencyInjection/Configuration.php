<?php

declare(strict_types=1);

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

        // Keep compatibility with symfony/config < 4.2
        if (!method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->root('sonata_admin');
        } else {
            $rootNode = $treeBuilder->getRootNode();
        }

        $rootNode
            ->children()
                ->arrayNode('providers')
                    ->info('list of SonataMedia providers to enable multiupload.')
                    ->isRequired()
                    ->prototype('scalar')
                        ->defaultValue([])
                    ->end()
                ->end()
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
