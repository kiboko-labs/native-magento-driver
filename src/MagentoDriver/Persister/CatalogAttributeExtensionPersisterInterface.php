<?php

namespace Luni\Component\MagentoDriver\Persister;

use Luni\Component\MagentoDriver\Model\CatalogAttributeExtensionInterface;

interface CatalogAttributeExtensionPersisterInterface
{
    /**
     * @return void
     */
    public function initialize();

    /**
     * @param CatalogAttributeExtensionInterface $attribute
     */
    public function persist(CatalogAttributeExtensionInterface $attribute);

    /**
     * @param CatalogAttributeExtensionInterface $attribute
     */
    public function __invoke(CatalogAttributeExtensionInterface $attribute);

    /**
     * @return void
     */
    public function flush();
}
