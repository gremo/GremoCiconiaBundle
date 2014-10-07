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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class GremoCiconiaExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('ciconia.xml');

        // Sets the renderer alias
        if (null !== $config['renderer']) {
            $container->setAlias('ciconia.renderer.default', 'ciconia.renderer.'.$config['renderer']);
        }

        // Load extension definitions
        foreach ($config['extensions'] as $name => $enabled) {
            if (true === $enabled) {
                $loader->load('extensions/'.$name.'.xml');
            }
        }
    }
}
