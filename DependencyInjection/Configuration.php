<?php

/*
 * This file is part of the ciconia-bundle package.
 *
 * (c) Marco Polichetti <gremo1982@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gremo\CiconiaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('gremo_ciconia');

        $rootNode
            ->fixXmlConfig('extension')
            ->children()
                ->scalarNode('renderer')
                    ->defaultNull()
                    ->validate()
                        ->ifNotInArray(array(null, 'html', 'xhtml'))
                            ->thenInvalid(
                                'Unrecognized renderer "%s", allowed: '.json_encode([null, 'html', 'xhtml']).'.'
                            )
                    ->end()
                ->end()
                ->arrayNode('extensions')
                    ->treatFalseLike([])
                    ->beforeNormalization()
                        ->ifTrue(function ($v) {
                            return null === $v || true === $v;
                        })
                        ->then(function ($v) {
                            $v = [];
                            foreach (glob(__DIR__.'/../Resources/config/extensions/*.xml') as $pathname) {
                                $v[basename($pathname, '.xml')] = true;
                            }

                            return $v;
                        })
                    ->end()
                    ->useAttributeAsKey('name')
                    ->prototype('boolean')
                        ->treatNullLike(true)
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
