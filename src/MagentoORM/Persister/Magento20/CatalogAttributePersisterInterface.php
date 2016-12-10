<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister\Magento20;

use Kiboko\Component\MagentoORM\Model\Magento20\CatalogAttributeInterface;

interface CatalogAttributePersisterInterface
{
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
     * @return \Traversable
     */
    public function flush();
}
