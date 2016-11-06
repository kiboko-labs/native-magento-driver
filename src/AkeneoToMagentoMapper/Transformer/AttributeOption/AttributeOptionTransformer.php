<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Transformer\AttributeOption;

use Kiboko\Component\MagentoORM\Model\AttributeOption;
use Kiboko\Component\MagentoORM\Model\AttributeOptionInterface as KibokoAttributeOptionInterface;
use Kiboko\Component\AkeneoToMagentoMapper\Mapper\AttributeMapperInterface;
use Kiboko\Component\AkeneoToMagentoMapper\Mapper\AttributeOptionMapperInterface;
use Kiboko\Component\AkeneoToMagentoMapper\Transformer\AttributeOptionTransformerInterface;
use Pim\Component\Catalog\Model\AttributeOptionInterface as PimAttributeOptionInterface;

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
     *
     * @param AttributeMapperInterface       $attributeMapper
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
        $option = AttributeOption::buildNewWith(
            $this->attributeOptionMapper->map($attributeOption->getCode()),
            $this->attributeMapper->map($attributeOption->getAttribute()->getCode()),
            $attributeOption->getSortOrder()
        );

        $option->setMappingCode($attributeOption->getCode());

        yield $option;
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
