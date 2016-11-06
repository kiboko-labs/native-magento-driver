<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Transformer\Magento20\Attribute;

use Kiboko\Component\MagentoORM\Model\CatalogAttributeExtensionInterface as KibokoCatalogAttributeExtensionInterface;
use Kiboko\Component\AkeneoToMagentoMapper\Transformer\Attribute\AbstractCatalogAttributeExtensionsTransformer;
use Pim\Component\Catalog\Model\AttributeInterface as PimAttributeInterface;

class CatalogAttributeExtensionsTransformer extends AbstractCatalogAttributeExtensionsTransformer
{
    /**
     * @param PimAttributeInterface $attribute
     *
     * @return KibokoCatalogAttributeExtensionInterface[]
     */
    public function transform(PimAttributeInterface $attribute)
    {
        return [];
    }
}
