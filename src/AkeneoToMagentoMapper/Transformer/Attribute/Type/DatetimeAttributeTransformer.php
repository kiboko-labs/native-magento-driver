<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Transformer\Attribute\Type;

use Kiboko\Component\MagentoORM\Model\Attribute;
use Kiboko\Component\MagentoORM\Model\AttributeInterface as KibokoAttributeInterface;
use Kiboko\Component\MagentoORM\Model\CatalogAttribute;
use Kiboko\Component\MagentoORM\Model\Magento19\CatalogAttributeExtension;
use Kiboko\Component\AkeneoToMagentoMapper\Mapper\EntityTypeMapperInterface;
use Kiboko\Component\AkeneoToMagentoMapper\Transformer\AttributeTransformerInterface;
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
        $entityTypeId = $this->entityTypeMapper->map($attribute->getEntityType());
        yield new CatalogAttribute(
            new Attribute(
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
