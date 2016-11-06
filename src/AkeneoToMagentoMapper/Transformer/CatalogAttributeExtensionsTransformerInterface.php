<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Transformer;

use Kiboko\Component\MagentoORM\Model\CatalogAttributeExtensionInterface as KibokoCatalogAttributeExtensionInterface;
use Pim\Component\Catalog\Model\AttributeInterface as PimAttributeInterface;

interface CatalogAttributeExtensionsTransformerInterface
{
    /**
     * @param PimAttributeInterface $attribute
     *
     * @return KibokoCatalogAttributeExtensionInterface[]
     */
    public function transform(PimAttributeInterface $attribute);

    /**
     * @param PimAttributeInterface $attribute
     *
     * @return bool
     */
    public function supportsTransformation(PimAttributeInterface $attribute);
}
