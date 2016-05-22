<?php

namespace Kiboko\Bundle\MagentoDriverBundle\DependencyInjection\CompilerPass;

use Luni\Component\MagentoDriver\Matcher\BackendTypeAttributeValueMatcher;
use Luni\Component\MagentoDriver\Matcher\FrontendAndBackendTypeAttributeValueMatcher;
use Luni\Component\MagentoDriver\Matcher\FrontendTypeAttributeValueMatcher;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class DirectPersistersCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('kiboko.magento_driver.persister.direct.attribute_value.broker')) {
            return;
        }

        $definition = $container->getDefinition(
            'kiboko.magento_driver.persister.direct.attribute_value.broker'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'kiboko.magento_driver.backend.attribute_value'
        );

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                if (isset($attributes['frontend']) && isset($attributes['backend'])) {
                    $matcher = new BackendTypeAttributeValueMatcher($attributes['backend']);
                } else if (isset($attributes['frontend'])) {
                    $matcher = new FrontendTypeAttributeValueMatcher($attributes['frontend']);
                } else if (isset($attributes['backend'])) {
                    $matcher = new FrontendAndBackendTypeAttributeValueMatcher(
                        $attributes['frontend'], $attributes['backend']);
                } else {
                    continue;
                }

                $definition->addMethodCall(
                    'addPersister',
                    [new Reference($id), $matcher]
                );
            }
        }
    }
}