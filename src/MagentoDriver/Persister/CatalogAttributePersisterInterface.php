<?php

namespace Luni\Component\MagentoDriver\Persister;

use Luni\Component\MagentoDriver\Model\CatalogAttributeInterface;

interface CatalogAttributePersisterInterface
{
    /**
     * @return void
     */
    public function initialize();

    /**
     * @param CatalogAttributeInterface $attribute
     */
    public function persist(CatalogAttributeInterface $attribute);

    /**
     * @param CatalogAttributeInterface $attribute
     */
    public function __invoke(CatalogAttributeInterface $attribute);

    /**
     * @return void
     */
    public function flush();
}
