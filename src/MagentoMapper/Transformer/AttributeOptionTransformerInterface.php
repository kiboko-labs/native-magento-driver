<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoMapper\Transformer;

use Kiboko\Component\MagentoDriver\Model\AttributeOptionInterface as KibokoAttributeOptionInterface;
use Pim\Component\Catalog\Model\AttributeOptionInterface as PimAttributeOptionInterface;

interface AttributeOptionTransformerInterface
{
    /**
     * @param PimAttributeOptionInterface $attributeOption
     *
     * @return KibokoAttributeOptionInterface[]
     */
    public function transform(PimAttributeOptionInterface $attributeOption);

    /**
     * @param PimAttributeOptionInterface $attributeOption
     *
     * @return bool
     */
    public function supportsTransformation(PimAttributeOptionInterface $attributeOption);
}
