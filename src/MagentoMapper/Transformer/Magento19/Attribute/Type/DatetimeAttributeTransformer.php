<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoMapper\Transformer\Magento19\Attribute\Type;

use Kiboko\Component\MagentoDriver\Model\Attribute;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface as KibokoAttributeInterface;
use Kiboko\Component\MagentoDriver\Model\CatalogAttribute;
use Kiboko\Component\MagentoDriver\Model\Magento19\CatalogAttributeExtension;
use Kiboko\Component\MagentoMapper\Mapper\EntityTypeMapperInterface;
use Kiboko\Component\MagentoMapper\Transformer\AttributeTransformerInterface;
use Pim\Component\Catalog\Model\AttributeInterface as PimAttributeInterface;

class DatetimeAttributeTransformer implements AttributeTransformerInterface
{
    /**
     * @var EntityTypeMapperInterface
     */
    private $entityTypeMapper;

    /**
     * @param EntityTypeMapperInterface $entityTypeMapper
     */
    public function __construct(
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
        $attributeId = $this->entityTypeMapper->map($attribute->getEntityType());
        yield new CatalogAttribute(
            new Attribute(
                $attributeId,                            // entity_type_id
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
                '',
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
