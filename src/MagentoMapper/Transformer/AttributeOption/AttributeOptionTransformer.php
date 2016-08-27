<?php


namespace Kiboko\Component\MagentoMapper\Transformer\AttributeOption;

use Kiboko\Component\MagentoDriver\Model\AttributeOption;
use Kiboko\Component\MagentoDriver\Model\AttributeOptionInterface as KibokoAttributeOptionInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeOptionValue;
use Kiboko\Component\MagentoDriver\Repository\StoreRepositoryInterface;
use Kiboko\Component\MagentoMapper\Mapper\AttributeMapperInterface;
use Kiboko\Component\MagentoMapper\Mapper\AttributeOptionMapperInterface;
use Kiboko\Component\MagentoMapper\Mapper\AttributeOptionValueMapperInterface;
use Kiboko\Component\MagentoMapper\Transformer\AttributeOptionTransformerInterface;
use Pim\Component\Catalog\Model\AttributeOptionInterface as PimAttributeOptionInterface;
use Pim\Component\Catalog\Model\AttributeOptionValueInterface;

class AttributeOptionTransformer implements AttributeOptionTransformerInterface
{
    /**
     * @var AttributeMapperInterface
     */
    private $attributeMapper;

    /**
     * @var AttributeOptionMapperInterface
     */
    private $attributeOptionMapper;

    /**
     * AttributeOptionTransformer constructor.
     * @param AttributeMapperInterface $attributeMapper
     * @param AttributeOptionMapperInterface $attributeOptionMapper
     */
    public function __construct(
        AttributeMapperInterface $attributeMapper,
        AttributeOptionMapperInterface $attributeOptionMapper
    ) {
        $this->attributeMapper = $attributeMapper;
        $this->attributeOptionMapper = $attributeOptionMapper;
    }

    /**
     * @param PimAttributeOptionInterface $attributeOption
     *
     * @return KibokoAttributeOptionInterface[]|\Traversable
     */
    public function transform(PimAttributeOptionInterface $attributeOption)
    {
        return [
            $attributeOption->getCode() => AttributeOption::buildNewWith(
                $this->attributeOptionMapper->map($attributeOption->getCode()),
                $this->attributeMapper->map($attributeOption->getAttribute()->getCode()),
                $attributeOption->getSortOrder()
            )
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
