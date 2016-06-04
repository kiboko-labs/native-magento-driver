<?php

namespace Kiboko\Bundle\MagentoDriverBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class TransformersCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('kiboko.magento_driver.transformer.attribute')) {
            return;
        }

        $definition = $container->getDefinition(
            'kiboko.magento_driver.transformer.attribute'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'kiboko.magento_driver.transformer.attribute'
        );

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall(
                'addAttributeTransformer',
                [new Reference($id)]
            );
        }
    }
}
