<?php

namespace Kiboko\Component\MagentoDriver\Persister;

use Kiboko\Component\MagentoDriver\Model\CatalogAttributeExtensionInterface;

interface CatalogAttributeExtensionPersisterInterface
{
    public function initialize();

    /**
     * @param CatalogAttributeExtensionInterface $attribute
     */
    public function persist(CatalogAttributeExtensionInterface $attribute);

    /**
     * @param CatalogAttributeExtensionInterface $attribute
     */
    public function __invoke(CatalogAttributeExtensionInterface $attribute);

    public function flush();
}
