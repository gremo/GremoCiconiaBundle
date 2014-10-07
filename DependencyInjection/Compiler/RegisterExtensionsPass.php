<?php

/*
 * This file is part of the ciconia-bundle package.
 *
 * (c) Marco Polichetti <gremo1982@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gremo\CiconiaBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterExtensionsPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('ciconia')) {
            return;
        }

        $definition = $container->getDefinition('ciconia');

        $taggedServices = $container->findTaggedServiceIds('ciconia.extension');
        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall('addExtension', array(new Reference($id)));
        }
    }
}
