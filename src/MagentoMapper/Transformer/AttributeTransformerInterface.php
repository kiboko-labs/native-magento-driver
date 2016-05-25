<?php

namespace Kiboko\Component\MagentoMapper\Transformer;

use Kiboko\Component\MagentoDriver\Model\AttributeInterface as KibokoAttributeInterface;
use Pim\Bundle\CatalogBundle\Model\AttributeInterface as PimAttributeInterface;

interface AttributeTransformerInterface
{
    /**
     * @param PimAttributeInterface $attribute
     *
     * @return KibokoAttributeInterface
     */
    public function transform(PimAttributeInterface $attribute);

    /**
     * @param PimAttributeInterface $attribute
     *
     * @return bool
     */
    public function supportsTransformation(PimAttributeInterface $attribute);
}
