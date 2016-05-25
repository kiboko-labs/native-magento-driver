<?php

namespace Kiboko\Component\MagentoTransformer\Attribute\Type;

use Akeneo\Bundle\MeasureBundle\Family\WeightFamilyInterface;
use Kiboko\Component\MagentoDriver\Model\Attribute;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface as KibokoAttributeInterface;
use Kiboko\Component\MagentoMapper\Mapper\EntityTypeMapperInterface;
use Kiboko\Component\MagentoMapper\Transformer\AttributeTransformerInterface;
use Pim\Bundle\CatalogBundle\Model\AttributeInterface as PimAttributeInterface;
use Pim\Bundle\CatalogBundle\Model\MetricInterface;

class SimpleSelectAttributeTransformer
    implements AttributeTransformerInterface
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
     * @param int|null $mappedId
     * @return KibokoAttributeInterface
     */
    public function transform(PimAttributeInterface $attribute, $mappedId = null)
    {
        return Attribute::buildNewWith(
            $mappedId,                                      // attribute_id
            $this->entityTypeMapper->map($attribute),       // entity_type_id
            $attribute->getCode(),                          // attribute_code
            null,                                           // attribute_model
            'int',                                          // backend_type
            null,                                           // backend_model
            null,                                           // backend_table
            null,                                           // frontend_model
            'select',                                       // frontend_input
            $attribute->getLabel(),                         // frontend_label
            null,                                           // frontend_class
            'eav/entity_attribute_source_table',            // source_model
            $attribute->isRequired(),                       // is_required
            true,                                           // is_user_defined
            $attribute->isUnique(),                         // is_unique
            null,                                           // default_value
            null                                            // note
        );
    }

    /**
     * @param PimAttributeInterface $attribute
     * @return bool
     */
    public function supportsTransformation(PimAttributeInterface $attribute)
    {
        return $attribute->getAttributeType() === 'pim_catalog_simpleselect';
    }
}