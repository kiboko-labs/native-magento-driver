<?php

namespace Kiboko\Bundle\MagentoDriverBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;

class KibokoMagentoDriverExtension
    extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('database.yml');
        $loader->load('parameters.yml');
        $loader->load('filesystem.yml');
        $loader->load('brokers.yml');
        $loader->load('writers.yml');
        $loader->load('deleters.yml');
        $loader->load('mappers.yml');
        $loader->load('processors.yml');
        $loader->load('transformers.yml');
        $loader->load('query_builders.yml');
        $loader->load('factories.yml');
        $loader->load('repositories.yml');
        $loader->load('deleters.yml');
        $loader->load('standard_dml/persisters.yml');
        //$loader->load('flatfile/persisters.yml');
    }
}