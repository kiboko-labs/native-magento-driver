<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Factory;

use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Model\CatalogAttributeExtensionInterface;

interface ProductAttributeFactoryInterface
{
    /**
     * @param array $options
     *
     * @return AttributeInterface|CatalogAttributeExtensionInterface
     */
    public function buildNew(array $options);
}
