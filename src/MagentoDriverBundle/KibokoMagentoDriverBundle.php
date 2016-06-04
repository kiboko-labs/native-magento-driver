<?php

namespace Kiboko\Bundle\MagentoDriverBundle;

use Kiboko\Bundle\MagentoDriverBundle\DependencyInjection\CompilerPass\StandardDmlPersistersCompilerPass;
use Kiboko\Bundle\MagentoDriverBundle\DependencyInjection\CompilerPass\TransformersCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class KibokoMagentoDriverBundle extends Bundle
{
    /**
     * Builds the bundle.
     *
     * It is only ever called once when the cache is empty.
     *
     * This method can be overridden to register compilation passes,
     * other extensions, ...
     *
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new StandardDmlPersistersCompilerPass());
        $container->addCompilerPass(new TransformersCompilerPass());
    }
}
