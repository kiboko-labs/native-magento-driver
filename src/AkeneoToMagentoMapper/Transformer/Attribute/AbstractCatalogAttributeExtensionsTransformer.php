<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Transformer\Attribute;

use Kiboko\Component\AkeneoToMagentoMapper\Mapper\AttributeMapperInterface;
use Kiboko\Component\AkeneoToMagentoMapper\Transformer\CatalogAttributeExtensionsTransformerInterface;
use Pim\Component\Catalog\Model\AttributeInterface as PimAttributeInterface;

abstract class AbstractCatalogAttributeExtensionsTransformer implements CatalogAttributeExtensionsTransformerInterface
{
    protected $attributeMapper;

    /**
     * AbstractCatalogAttributeExtensionsTransformer constructor.
     *
     * @param AttributeMapperInterface $attributeMapper
     */
    public function __construct(AttributeMapperInterface $attributeMapper)
    {
        $this->attributeMapper = $attributeMapper;
    }

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
