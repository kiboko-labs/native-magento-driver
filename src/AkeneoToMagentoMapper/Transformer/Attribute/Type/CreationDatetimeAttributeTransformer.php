<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Transformer\Attribute\Type;

use Kiboko\Component\MagentoORM\Model\Attribute;
use Kiboko\Component\MagentoORM\Model\AttributeInterface as KibokoAttributeInterface;
use Kiboko\Component\AkeneoToMagentoMapper\Mapper\EntityTypeMapperInterface;
use Kiboko\Component\AkeneoToMagentoMapper\Transformer\AttributeTransformerInterface;
use Pim\Component\Catalog\Model\AttributeInterface as PimAttributeInterface;

/**
 * Class NativeDatetimeAttributeTransformer.
 *
 * @attributes custom_design_to,news_to_date,special_to_date
 */
class CreationDatetimeAttributeTransformer implements AttributeTransformerInterface
{
    /**
     * @var EntityTypeMapperInterface
     */
    private $entityTypeMapper;

    /**
     * @var string[]
     */
    private $supportedAttributeCodes;

    /**
     * @param EntityTypeMapperInterface $entityTypeMapper
     * @param string[]
     */
    public function __construct(
        EntityTypeMapperInterface $entityTypeMapper,
        array $supportedAttributeCodes = null
    ) {
        $this->entityTypeMapper = $entityTypeMapper;

        if ($supportedAttributeCodes === null) {
            $this->supportedAttributeCodes = [
                'custom_design_to',
                'news_to_date',
                'special_to_date',
            ];
        } else {
            $this->supportedAttributeCodes = $supportedAttributeCodes;
        }
    }

    /**
     * @param PimAttributeInterface $attribute
     * @param int|null              $mappedId
     *
     * @return KibokoAttributeInterface[]
     */
    public function transform(PimAttributeInterface $attribute, $mappedId = null)
    {
        return [
            Attribute::buildNewWith(
                $mappedId,                                      // attribute_id
                $this->entityTypeMapper->map($attribute),       // entity_type_id
                $attribute->getCode(),                          // attribute_code
                null,                                           // attribute_model
                'datetime',                                     // backend_type
                'eav/entity_attribute_backend_datetime',        // backend_model
                null,                                           // backend_table
                null,                                           // frontend_model
                'date',                                         // frontend_input
                $attribute->getLabel(),                         // frontend_label
                null,                                           // frontend_class
                null,                                           // source_model
                $attribute->isRequired(),                       // is_required
                false,                                          // is_user_defined
                $attribute->isUnique(),                         // is_unique
                null,                                           // default_value
                null                                            // note
            ),
        ];
    }

    /**
     * @param PimAttributeInterface $attribute
     *
     * @return bool
     */
    public function supportsTransformation(PimAttributeInterface $attribute)
    {
        return $attribute->getAttributeType() === 'pim_catalog_date'
            && in_array($attribute->getCode(), $this->supportedAttributeCodes);
    }
}
