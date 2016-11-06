<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Transformer;

use Kiboko\Component\MagentoORM\Model\AttributeGroupInterface as KibokoAttributeGroupInterface;
use Pim\Component\Catalog\Model\AttributeGroupInterface as PimAttributeGroupInterface;

interface AttributeGroupTransformerInterface
{
    /**
     * @param PimAttributeGroupInterface $group
     *
     * @return KibokoAttributeGroupInterface[]|\Traversable
     */
    public function transform(PimAttributeGroupInterface $group);

    /**
     * @param PimAttributeGroupInterface $group
     *
     * @return bool
     */
    public function supportsTransformation(PimAttributeGroupInterface $group);
}
