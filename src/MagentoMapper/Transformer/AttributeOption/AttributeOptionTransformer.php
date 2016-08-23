<?php


namespace Kiboko\Component\MagentoMapper\Transformer\AttributeOption;

use Kiboko\Component\MagentoDriver\Model\AttributeOption;
use Kiboko\Component\MagentoDriver\Model\AttributeOptionInterface as KibokoAttributeOptionInterface;
use Kiboko\Component\MagentoMapper\Transformer\AttributeOptionTransformerInterface;
use Pim\Component\Catalog\Model\AttributeOptionInterface as PimAttributeOptionInterface;

class AttributeOptionTransformer implements AttributeOptionTransformerInterface
{
    /**
     * @param PimAttributeOptionInterface $attributeOption
     *
     * @return KibokoAttributeOptionInterface
     */
    public function transform(PimAttributeOptionInterface $attributeOption)
    {
        $option = AttributeOption::buildNewWith(
            0,
            $attributeOption->getAttribute()->getId(),
            $attributeOption->getSortOrder()
        );

        return [
            $option
        ];
    }

    /**
     * @param PimAttributeOptionInterface $attributeOption
     *
     * @return bool
     */
    public function supportsTransformation(PimAttributeOptionInterface $attributeOption)
    {
        return true;
    }
}
