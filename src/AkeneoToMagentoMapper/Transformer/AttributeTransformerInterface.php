<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Transformer;

use Kiboko\Component\MagentoORM\Model\CatalogAttributeInterface as KibokoAttributeInterface;
use Pim\Component\Catalog\Model\AttributeInterface as PimAttributeInterface;

interface AttributeTransformerInterface
{
    /**
     * @param PimAttributeInterface $attribute
     *
     * @return KibokoAttributeInterface[]
     */
    public function transform(PimAttributeInterface $attribute);

    /**
     * @param PimAttributeInterface $attribute
     *
     * @return bool
     */
    public function supportsTransformation(PimAttributeInterface $attribute);
}
