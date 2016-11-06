<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoMapper\Transformer\Attribute;

use Kiboko\Component\MagentoMapper\Transformer\CatalogAttributeExtensionsTransformerInterface;
use Pim\Component\Catalog\Model\AttributeInterface as PimAttributeInterface;

abstract class AbstractCatalogAttributeExtensionsTransformer implements CatalogAttributeExtensionsTransformerInterface
{
    /**
     * @param PimAttributeInterface $attribute
     *
     * @return bool
     */
    public function supportsTransformation(PimAttributeInterface $attribute)
    {
        return true;
    }
}
