<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Transformer\Magento19\Attribute\Type;

use Kiboko\Component\AkeneoToMagentoMapper\Mapper\AttributeMapperInterface;
use Kiboko\Component\MagentoORM\Model\Attribute;
use Kiboko\Component\MagentoORM\Model\AttributeInterface as KibokoAttributeInterface;
use Kiboko\Component\MagentoORM\Model\Magento19\CatalogAttribute;
use Kiboko\Component\MagentoORM\Model\Magento19\CatalogAttributeExtension;
use Kiboko\Component\AkeneoToMagentoMapper\Mapper\EntityTypeMapperInterface;
use Kiboko\Component\AkeneoToMagentoMapper\Transformer\AttributeTransformerInterface;
use Pim\Component\Catalog\Model\AttributeInterface as PimAttributeInterface;

class DatetimeAttributeTransformer implements AttributeTransformerInterface
{
    /**
     * @var AttributeMapperInterface
     */
    private $attributeMapper;

    /**
     * @var EntityTypeMapperInterface
     */
    private $entityTypeMapper;

    /**
     * @param AttributeMapperInterface $attributeMapper
     * @param EntityTypeMapperInterface $entityTypeMapper
     */
    public function __construct(
        AttributeMapperInterface $attributeMapper,
        EntityTypeMapperInterface $entityTypeMapper
    ) {
        $this->entityTypeMapper = $entityTypeMapper;
    }

    /**
     * @param PimAttributeInterface $attribute
     *
     * @return KibokoAttributeInterface[]
     */
    public function transform(PimAttributeInterface $attribute)
    {
        $attributeId = $this->attributeMapper->map($attribute->getCode());
        $entityTypeId = $this->entityTypeMapper->map($attribute->getEntityType());
        yield new CatalogAttribute(
            Attribute::buildNewWith(
                $attributeId,
                $entityTypeId,                           // entity_type_id
                $attribute->getCode(),                   // attribute_code
                null,                                    // attribute_model
                'datetime',                              // backend_type
                'eav/entity_attribute_backend_datetime', // backend_model
                null,                                    // backend_table
                null,                                    // frontend_model
                'date',                                  // frontend_input
                $attribute->getLabel(),                  // frontend_label
                null,                                    // frontend_class
                null,                                    // source_model
                $attribute->isRequired(),                // is_required
                true,                                    // is_user_defined
                $attribute->isUnique(),                  // is_unique
                null,                                    // default_value
                null                                     // note
            ),
            new CatalogAttributeExtension(
                $attributeId,
                ''
            )
        );
    }

    /**
     * @param PimAttributeInterface $attribute
     *
     * @return bool
     */
    public function supportsTransformation(PimAttributeInterface $attribute)
    {
        return $attribute->getAttributeType() === 'pim_catalog_date';
    }
}
